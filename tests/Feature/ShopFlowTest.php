<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopFlowTest extends TestCase
{
    use RefreshDatabase;

    private function product(int $stock = 10): Product
    {
        $category = Category::create(['name' => 'Food', 'type' => 'makanan', 'slug' => 'food-' . uniqid()]);

        return Product::create([
            'category_id' => $category->id,
            'name'        => 'Kibble Adult',
            'brand'       => 'Meow',
            'price'       => 45000,
            'stock'       => $stock,
            'sold'        => 0,
        ]);
    }

    public function test_user_can_add_product_to_cart(): void
    {
        $user = User::factory()->create();
        $product = $this->product();

        $this->actingAs($user)->post('/cart/add/' . $product->id, ['quantity' => 2])->assertRedirect();

        $this->assertDatabaseHas('carts', [
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);

        $this->actingAs($user)->get('/cart')->assertOk();
    }

    public function test_user_cannot_touch_another_users_cart_item(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $cart = Cart::create([
            'user_id'    => $owner->id,
            'product_id' => $this->product()->id,
            'quantity'   => 1,
        ]);

        $this->actingAs($other)->patch('/cart/' . $cart->id, ['quantity' => 5])->assertForbidden();
        $this->actingAs($other)->delete('/cart/' . $cart->id)->assertForbidden();

        $this->assertDatabaseHas('carts', ['id' => $cart->id, 'quantity' => 1]);
    }

    public function test_user_can_checkout_and_view_receipt(): void
    {
        $user = User::factory()->create();
        $product = $this->product();

        $this->actingAs($user)->post('/cart/add/' . $product->id, ['quantity' => 2]);

        $response = $this->actingAs($user)->post('/checkout', [
            'payment_method' => 'BCA',
            'address'        => 'Jl. Merdeka 1',
            'phone'          => '08123456789',
        ]);

        $order = Order::firstWhere('user_id', $user->id);

        $this->assertNotNull($order);
        $response->assertRedirect(route('receipt', $order));
        $this->assertDatabaseHas('order_items', ['order_id' => $order->id, 'product_id' => $product->id, 'quantity' => 2]);
        $this->assertDatabaseMissing('carts', ['user_id' => $user->id]);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'sold' => 2, 'stock' => 8]);

        $this->actingAs($user)->get('/receipt/' . $order->id)->assertOk();
    }

    public function test_user_cannot_view_another_users_receipt(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $order = Order::create([
            'order_code'     => 'SPH-TEST',
            'user_id'        => $owner->id,
            'total'          => 1000,
            'payment_method' => 'BCA',
            'status'         => 'pending',
            'address'        => 'Jl. Merdeka 1',
            'phone'          => '0812',
        ]);

        $this->actingAs($other)->get('/receipt/' . $order->id)->assertForbidden();
    }

    public function test_orders_index_only_shows_own_orders(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        Order::create([
            'order_code' => 'SPH-MINE', 'user_id' => $user->id, 'total' => 1000,
            'payment_method' => 'BCA', 'status' => 'pending', 'address' => 'a', 'phone' => 'p',
        ]);
        Order::create([
            'order_code' => 'SPH-OTHER', 'user_id' => $other->id, 'total' => 1000,
            'payment_method' => 'BCA', 'status' => 'pending', 'address' => 'a', 'phone' => 'p',
        ]);

        $response = $this->actingAs($user)->get('/orders')->assertOk();

        $response->assertSee('SPH-MINE');
        $response->assertDontSee('SPH-OTHER');
    }

    public function test_user_can_submit_review(): void
    {
        $user = User::factory()->create();
        $product = $this->product();

        $this->actingAs($user)
            ->post('/product/' . $product->id . '/review', ['rating' => 5, 'comment' => 'Enak!'])
            ->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'rating'     => 5,
        ]);

        $this->actingAs($user)
            ->post('/product/' . $product->id . '/review', ['rating' => 4, 'comment' => 'Lumayan'])
            ->assertRedirect();

        $this->assertSame(1, Review::where('user_id', $user->id)->where('product_id', $product->id)->count());
    }

    public function test_admin_area_is_restricted(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin/dashboard')->assertForbidden();
        $this->actingAs(User::factory()->create())->get('/admin/orders')->assertForbidden();
        $this->actingAs(User::factory()->create(['role' => 'admin']))->get('/admin/dashboard')->assertOk();
        $this->actingAs(User::factory()->create(['role' => 'admin']))->get('/admin/orders')->assertOk();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/cart')->assertRedirect('/login');
        $this->get('/orders')->assertRedirect('/login');
    }
}
