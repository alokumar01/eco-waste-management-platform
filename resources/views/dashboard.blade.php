@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    @if(auth()->user()->role === 'provider' && !auth()->user()->profile_completed)
                        <div class="mt-4 alert alert-warning">
                            Please <a href="{{ route('provider.profile.edit') }}" class="font-bold underline">complete your business profile</a> to access your dashboard.
                        </div>
                    @endif

                    <div class="mt-4">
                        @if(auth()->user()->role === 'user')
                            <a href="{{ route('services.list') }}" class="btn btn-primary">Browse Available Services</a>
                        @endif
                        <a href="{{ route('bookings.my') }}" class="btn btn-secondary">View My Bookings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

