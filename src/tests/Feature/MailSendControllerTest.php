<?php

namespace Tests\Feature;

use App\Mail\SendAdminToUserMail;
use App\Mail\SendAdminToUsersMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailSendControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminToUser()
    {
        Mail::fake();

        $user = User::factory()->create();
        $subject = 'Test Subject';
        $content = 'Test mail content';

        $response = $this->actingAs($user)->post(route('mail.send.admin_to_user'), [
            'user_id' => $user->id,
            'subject' => $subject,
            'content' => $content,
        ]);

        Mail::assertSent(SendAdminToUserMail::class, function ($mail) use ($user, $subject, $content) {
            return $mail->hasTo($user->email) &&
                $mail->subject === $subject &&
                $mail->content === $content;
        });

        $response->assertRedirect('/admin-page/users');
        $response->assertSessionHas('message', $user->name . 'さんにメールを送信しました。');
    }

    public function testAdminToUsers()
    {
        Mail::fake();

        $admin_user = User::factory()->create();
        $users = User::factory()->count(5)->create();
        $subject = 'Bulk Test Subject';
        $content = 'Bulk test mail content';
        $user_emails = $users->pluck('email')->toArray();

        $response = $this->actingAs($admin_user)->post(route('mail.send.admin_to_users'), [
            'users' => json_encode($user_emails),
            'subject' => $subject,
            'content' => $content,
        ]);

        Mail::assertSent(SendAdminToUsersMail::class, function ($mail) use ($user_emails, $subject, $content) {
            foreach ($user_emails as $email) {
                if (!$mail->hasTo($email)) {
                    return false;
                }
            }
            return $mail->subject === $subject && $mail->content === $content;
        });

        $response->assertRedirect('/admin-page/users');
        $response->assertSessionHas('message', 'メールを一括送信しました。');
    }
}
