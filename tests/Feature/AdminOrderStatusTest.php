<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function admin_can_update_order_status()
    {
        $admin = User::where('role', 'admin')->first();

        $order = Order::factory()->create([
            'status' => Order::STATUS_NEW,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.orders.update', $order), [
                'status' => Order::STATUS_IN_PROGRESS,
            ]);

        $response->assertRedirect();
        $this->assertEquals(Order::STATUS_IN_PROGRESS, $order->fresh()->status);
    }
}
