@extends('layouts.superadmin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Payment Gateway Settings</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('superadmin.gateways.update') }}" method="POST">
            @csrf
            <div class="space-y-8">

                <!-- Stripe Settings -->
                <div class="p-6 border rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Stripe</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="stripe_api_key" class="block text-sm font-medium text-gray-700">API Key</label>
                            <input type="password" name="stripe_api_key" id="stripe_api_key" value="{{ $stripe->api_key }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="stripe_secret_key" class="block text-sm font-medium text-gray-700">Secret
                                Key</label>
                            <input type="password" name="stripe_secret_key" id="stripe_secret_key"
                                value="{{ $stripe->secret_key }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="stripe_is_active" class="flex items-center">
                            <input type="checkbox" name="stripe_is_active" id="stripe_is_active" value="1"
                                {{ $stripe->is_active ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 shadow-sm">
                            <span class="ml-2 text-sm text-gray-600">Enable Stripe</span>
                        </label>
                    </div>
                </div>

                <!-- Razorpay Settings -->
                <div class="p-6 border rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Razorpay</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="razorpay_api_key" class="block text-sm font-medium text-gray-700">API Key</label>
                            <input type="password" name="razorpay_api_key" id="razorpay_api_key"
                                value="{{ $razorpay->api_key }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="razorpay_secret_key" class="block text-sm font-medium text-gray-700">Secret
                                Key</label>
                            <input type="password" name="razorpay_secret_key" id="razorpay_secret_key"
                                value="{{ $razorpay->secret_key }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="razorpay_is_active" class="flex items-center">
                            <input type="checkbox" name="razorpay_is_active" id="razorpay_is_active" value="1"
                                {{ $razorpay->is_active ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 shadow-sm">
                            <span class="ml-2 text-sm text-gray-600">Enable Razorpay</span>
                        </label>
                    </div>
                </div>

            </div>
            <div class="mt-8">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
@endsection
