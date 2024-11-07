<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\PaymentDetail;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;
use Stripe\Charge;
use Stripe\Exception\CardException;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // StripeのAPIキーをセット
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));
    }

    /** @test */
    public function user_can_purchase_an_item()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $user->id]);

        // ログインしているユーザーを認証
        Auth::login($user);

        $fake_charge = Mockery::mock('alias:Stripe\Charge');
        $fake_charge->shouldReceive('create')
            ->once()
            ->with(\Mockery::on(function ($args) {
                return $args['amount'] == 1000 && // 金額のチェック
                    $args['currency'] == 'jpy' && // 通貨のチェック
                    $args['source'] == 'tok_visa'; // ソーストークンのチェック
            }))
            ->andReturn([
                'id' => 'ch_123456789',
                'amount' => 1000
            ]);

        $this->app->instance(Charge::class, $fake_charge);

        // PaymentMethod モデルのインスタンスを作成し、データベースに保存
        $payment_method = PaymentMethod::create([
            'name' => 'クレジットカード',
            'description' => 'Visa, MasterCard, JCBなどのクレジットカードで支払います',
        ]);
        $payment_method_id = $payment_method->id;

        // PaymentDetail モデルのインスタンスを作成し、データベースに保存
        $payment_detail = PaymentDetail::create([
            'user_id' => $user->id,
            'payment_method_id' => $payment_method_id
        ]);
        $payment_detail_id = $payment_detail->id;

        $response = $this->post(route('payment.store', ['item_id' => $item->id]), [
            'stripeToken' => 'tok_visa', // フェイクのトークン
            'item_id' => $item->id,
            'paid_price' => 1000,
            'payment_detail_id' => $payment_detail_id
        ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'buyer_id' => $user->id,
            'seller_id' => $item->user_id,
            'paid_price' => '1000.00'
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', "{$item->name}を購入しました。");

        // Mockeryが期待通りに呼び出されたか確認
        Mockery::close();
    }
}
