<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $activeMenus = [3]; // ID for Payments & Billing menu

        // Find or create settings for Stripe and Razorpay
        $stripe = PaymentGateway::firstOrCreate(['name' => 'stripe']);
        $razorpay = PaymentGateway::firstOrCreate(['name' => 'razorpay']);

        return view('superadmin.gateways.index', compact('stripe', 'razorpay', 'activeMenus'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'stripe_api_key' => 'nullable|string',
            'stripe_secret_key' => 'nullable|string',
            'stripe_is_active' => 'nullable|boolean',
            'razorpay_api_key' => 'nullable|string',
            'razorpay_secret_key' => 'nullable|string',
            'razorpay_is_active' => 'nullable|boolean',
        ]);

        // Update Stripe settings
        $stripe = PaymentGateway::firstOrCreate(['name' => 'stripe']);
        $stripe->update([
            'api_key' => $data['stripe_api_key'] ?? null,
            'secret_key' => $data['stripe_secret_key'] ?? null,
            'is_active' => isset($data['stripe_is_active']),
        ]);

        // Update Razorpay settings
        $razorpay = PaymentGateway::firstOrCreate(['name' => 'razorpay']);
        $razorpay->update([
            'api_key' => $data['razorpay_api_key'] ?? null,
            'secret_key' => $data['razorpay_secret_key'] ?? null,
            'is_active' => isset($data['razorpay_is_active']),
        ]);

        return redirect()->route('superadmin.gateways.index')
                         ->with('success', 'Payment gateway settings saved successfully.');
    }
}
