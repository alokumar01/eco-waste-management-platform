@extends('layouts.app')

@if(auth()->user()->role === 'provider')
    @section('no_container', true)
    @section('no_top_nav', true)
@else
    @section('no_container', true)
@endif

@section('content')
@if(auth()->user()->role === 'provider')
    <div class="flex h-screen bg-[#F4F7F6] font-sans overflow-hidden">
        <!-- Sidebar -->
        @include('provider-dashboard-sidebar')

        <!-- Main Content Area Wrapper -->
        <div class="flex-1 flex flex-col h-full overflow-hidden">
            @include('provider-dashboard-header')

            <!-- Scrollable Content Body -->
            <div class="flex-1 overflow-y-auto p-6 md:p-10 pb-20 bg-[#F4F7F6]">
                <div class="max-w-[800px] mx-auto">
                    @include('notifications.partials.list')
                </div>
            </div>
        </div>
    </div>
@else
    <div class="min-h-screen bg-[#F8F9FA] font-sans pb-20 select-none">
        <div class="max-w-[800px] mx-auto px-4 sm:px-6 lg:px-8 pt-10 space-y-8">
            @include('notifications.partials.list')
        </div>
    </div>
@endif
@endsection
