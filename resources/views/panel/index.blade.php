@extends('layouts.sidebar')

@section('content')
<div class="main-section">
    <div class="main-header">
        <h3 class="main-title">Dashboard</h3>
        <span class="main-divider"></span>
    </div>

    {{-- HERO --}}
    <div class="dashboard-hero">
        <img src="{{ asset('assets/img/dashboard-hero.png') }}" alt="hero-image">
        <div>
            <h4>Welcome Back, {{ auth()->user()->name }}!</h4>
            <p>Here's what's happening with your platform today.</p>
        </div>
    </div>

    {{-- ANALYTICS --}}
    <div class="analytics-section">
        <div class="analytics-header">
            <h5>Your Links Overview</h5>

            <div class="analytics-grid">
                <div class="analytics-card">
                    <p class="analytics-title">Total Links</p>
                    <p class="analytics-count">{{ $links }}</p>
                    <p class="analytics-caption">All time</p>
                </div>

                <div class="analytics-card">
                    <p class="analytics-title">Total Clicks</p>
                    <p class="analytics-count">{{ $clicks }}</p>
                    <p class="analytics-caption">All time</p>
                </div>
            </div>
        </div>

        {{-- TOP LINKS --}}
        <div class="analytics-body">
            <h5>Top Performing Links</h5>

            @if($toplinks == "[]")
            <p class="analytics-caption text-center">
                You haven’t added any links yet
            </p>
            @else
            <div class="top-perform">
                @foreach($toplinks as $link)
                @if(
                $link->name !== 'phone' &&
                $link->name !== 'heading' &&
                $link->button_id !== 96
                )
                <div class="top-link-item">
                    <p class="text-truncate">{{ $link->title }}</p>

                    <div>
                        <i class="bi bi-box-arrow-up-right"></i>
                        <a href="{{ $link->link }}" target="_blank" class="text-truncate">
                            {{ $link->link }}
                        </a>
                        <p>
                            <span>{{ $link->click_number }}</span>
                            clicks
                        </p>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
        </div>
    </div>

</div>
@endsection