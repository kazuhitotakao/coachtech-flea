<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloTest extends TestCase
{
    use RefreshDatabase;

    public function testHello()
    {
        // $this->assertTrue(true);

        // $arr = [];
        // $this->assertEmpty($arr);

        // $txt = "Hello World";
        // $this->assertEquals('Hello World', $txt);

        // $n = random_int(0, 100);
        // $this->assertLessThan(100, $n);

        // $response = $this->get('/no_route');
        // $response->assertStatus(404);

        // $response = $this->get('/guest');
        // $response->assertStatus(200);

        // User::factory()->create([
        //     'name' => 'aaa',
        //     'email' => 'bbb@ccc.com',
        //     'password' => 'test12345'
        // ]);
        // $this->assertDatabaseHas('users', [
        //     'name' => 'aaa',
        //     'email' => 'bbb@ccc.com',
        //     'password' => 'test12345'
        // ]);

        $item = Item::factory()->create(['name' => 'Test Item']);

        $this->assertDatabaseHas('items', ['name' => 'Test Item']);
    }
}
