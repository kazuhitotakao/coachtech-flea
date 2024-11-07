<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserImageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUpload()
    {
        Storage::fake('local');
        $user = User::factory()->create();
        Auth::login($user);

        $files = [
            UploadedFile::fake()->image('profile1.jpg'),
            UploadedFile::fake()->image('profile2.jpg'),
        ];

        $response = $this->post(route('user.images.upload'), [
            'images' => $files,
        ]);

        // ファイルが指定したディレクトリに保存されたか確認
        // ここでは '/images/users' が保存先ディレクトリと仮定
        foreach ($files as $file) {
            Storage::disk('local')->assertExists('public/images/users/' . $file->hashName());
        }

        $response->assertRedirect('/my-page/profile');
    }
}
