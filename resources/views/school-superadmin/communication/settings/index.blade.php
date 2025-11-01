@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Communication Settings</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div x-data="{ currentTab: 'email' }">
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="currentTab = 'email'"
                        :class="currentTab === 'email' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Email (SMTP)
                </button>
                <button @click="currentTab = 'sms'"
                        :class="currentTab === 'sms' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    SMS (Twilio)
                </button>
                <button @click="currentTab = 'whatsapp'"
                        :class="currentTab === 'whatsapp' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    WhatsApp
                </button>
            </nav>
        </div>

        <form action="{{ route('school-superadmin.communication-settings.update') }}" method="POST">
            @csrf
            
            <!-- Email (SMTP) Settings -->
            <div x-show="currentTab === 'email'" class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-700">Email SMTP Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mail_host" class="block text-sm font-medium text-gray-700">Mail Host</label>
                        <input type="text" name="mail_host" id="mail_host" value="{{ old('mail_host', $mail_host ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., smtp.mailgun.org">
                    </div>
                    <div>
                        <label for="mail_port" class="block text-sm font-medium text-gray-700">Mail Port</label>
                        <input type="text" name="mail_port" id="mail_port" value="{{ old('mail_port', $mail_port ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., 587">
                    </div>
                    <div>
                        <label for="mail_username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="mail_username" id="mail_username" value="{{ old('mail_username', $mail_username ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="mail_password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="mail_password" id="mail_password" value="{{ old('mail_password', $mail_password ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" autocomplete="new-password">
                    </div>
                    <div>
                        <label for="mail_encryption" class="block text-sm font-medium text-gray-700">Encryption</label>
                        <select name="mail_encryption" id="mail_encryption" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="tls" {{ ($mail_encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ ($mail_encryption ?? 'tls') == 'ssl' ? 'selected' : '' }}>SSL</option>
                        </select>
                    </div>
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="mail_from_address" class="block text-sm font-medium text-gray-700">From Email Address</label>
                            <input type="email" name="mail_from_address" id="mail_from_address" value="{{ old('mail_from_address', $mail_from_address ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., no-reply@myschool.com">
                        </div>
                        <div>
                            <label for="mail_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                            <input type="text" name="mail_from_name" id="mail_from_name" value="{{ old('mail_from_name', $mail_from_name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., My School Name">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SMS (Twilio) Settings -->
            <div x-show="currentTab === 'sms'" class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-700">SMS Settings (Twilio)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="twilio_sid" class="block text-sm font-medium text-gray-700">Twilio SID</label>
                        <input type="password" name="twilio_sid" id="twilio_sid" value="" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" disabled>
                    </div>
                    <div>
                        <label for="twilio_token" class="block text-sm font-medium text-gray-700">Twilio Auth Token</label>
                        <input type="password" name="twilio_token" id="twilio_token" value="" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" disabled>
                    </div>
                    <div>
                        <label for="twilio_from_number" class="block text-sm font-medium text-gray-700">Twilio From Number</label>
                        <input type="text" name="twilio_from_number" id="twilio_from_number" value="" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" disabled>
                    </div>
                </div>
                <p class="text-sm text-gray-500">SMS configuration is not yet enabled.</p>
            </div>

            <!-- WhatsApp Settings -->
            <div x-show="currentTab === 'whatsapp'" class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-700">WhatsApp Settings</h3>
                <p class="text-sm text-gray-500">WhatsApp configuration is not yet enabled.</p>
            </div>

            <!-- Save Button -->
            <div class="mt-8 pt-6 border-t flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection