@extends('layouts.superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Payment Gateway Settings</h1>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('superadmin.gateways.update') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-6">

                    <!-- Stripe Settings -->
                    <div class="p-6 border rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Stripe</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="stripe_api_key" class="block text-sm font-medium text-gray-700 mb-1">API
                                    Key</label>
                                <input type="password" name="stripe_api_key" id="stripe_api_key"
                                    value="{{ $stripe->api_key }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm">
                            </div>
                            <div>
                                <label for="stripe_secret_key" class="block text-sm font-medium text-gray-700 mb-1">Secret
                                    Key</label>
                                <input type="password" name="stripe_secret_key" id="stripe_secret_key"
                                    value="{{ $stripe->secret_key }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm">
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
                                <label for="razorpay_api_key" class="block text-sm font-medium text-gray-700 mb-1">API
                                    Key</label>
                                <input type="password" name="razorpay_api_key" id="razorpay_api_key"
                                    value="{{ $razorpay->api_key }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm">
                            </div>
                            <div>
                                <label for="razorpay_secret_key" class="block text-sm font-medium text-gray-700 mb-1">Secret
                                    Key</label>
                                <input type="password" name="razorpay_secret_key" id="razorpay_secret_key"
                                    value="{{ $razorpay->secret_key }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm">
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

                <div class="pt-4 border-t flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
