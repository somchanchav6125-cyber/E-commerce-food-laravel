<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\KHQRService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_checkout_page_loads_successfully_and_generates_qr_code()
    {
        // 1. Arrange
        $total = 15.50;
        session(['cart_total' => $total]);

        $qrData = KHQRService::generate($total);
        $expectedQrImage = 'data:image/svg+xml;base64,' . base64_encode(QrCode::size(220)->generate($qrData));

        // 2. Act
        $response = $this->get(route('checkout'));

        // 3. Assert
        $response->assertStatus(200);
        $response->assertViewIs('frontend.cart.checkout');
        $response->assertViewHas('qrImage', $expectedQrImage);
        $response->assertViewHas('total', $total);

        // Check that a payment record was created
        $this->assertDatabaseHas('payments', [
            'amount' => $total,
            'status' => 'pending',
        ]);
    }
}
