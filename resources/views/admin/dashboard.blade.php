@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-6">
                {{ __('Admin Dashboard') }}
            </h2>

            <!-- Analytics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Revenue Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-full">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Bookings Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Bookings</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalBookings) }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-full">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Services Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Listed Services</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalServices) }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-full">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Users Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Users</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-full">
                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as admin!") }}
                    
                    @if (session('success'))
                        <div class="mt-4 text-green-600 bg-green-100 p-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-bold mt-8 mb-4">Service Providers Pending Verification</h3>
                    <table class="w-full text-left bg-gray-50 rounded-lg shadow overflow-hidden">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-3">Name</th>
                                <th class="p-3">Business Details</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($providers as $provider)
                                <tr class="border-b">
                                    <td class="p-3">{{ $provider->name }}<br><span class="text-sm text-gray-500">{{ $provider->email }}</span></td>
                                    <td class="p-3">
                                        @if($provider->profile_completed)
                                            <div><strong>{{ $provider->business_name }}</strong></div>
                                            <div class="text-sm">{{ $provider->phone_number }}</div>
                                        @else
                                            <span class="text-gray-400 italic">Profile Incomplete</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        @if($provider->is_verified)
                                            <span class="text-green-600 font-semibold flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                Verified
                                            </span>
                                        @else
                                            <span class="text-yellow-600 font-semibold">Pending</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        @if($provider->is_verified)
                                            <span class="text-gray-400 text-sm italic">Verification Complete</span>
                                        @elseif($provider->profile_completed)
                                            <form method="POST" action="{{ route('admin.verifyProvider', $provider) }}">
                                                @csrf
                                                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm font-medium transition shadow-sm">
                                                    Mark as Verified
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-sm">Awaiting Profile</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="p-4 text-center text-gray-500">No providers found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
