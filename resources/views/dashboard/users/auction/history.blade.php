@extends('layouts.master')

@section('content')
<x-shadow-box shadowClass="shadow">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <p style = "font-size: 13px">

            </p>
            <x-user-auction-visualizer
                :pendingAuctionsCount="$_pending_auctions"
                :liveAuctionsCount="$_live_auctions"
                :upcomingAuctionsCount="$_upcoming_auctions"
                :oldAuctionsCount=0
                :oldAuctionsCount="$_old_auctions"
                >
            </x-user-auction-visualizer>
            <x-section-head>
                <div class = "d-flex flex-column">
                    <!-- <span>{{ $info['title'] }}</span> -->
                    <span class = "badge badge-secondary" style = "font-size: 12px">{{ $info['user']->name}} - {{ $info['user']->email}}</span>
                </div>
            </x-section-head>
        </div>
        <div class="col-md-12">
            @include('dashboard.users.auction.partial.auction-head-tabs')
        </div>
        <div class = "col-md-12">
            <div class = "row">
            <div class = "col-md-12">
                    <div style = "" class = "p-2 shadow">
                        @include('dashboard.users.auction.partial.unpaid-auction')
                    </div>
                </div>
                <div class = "col-md-12 mt-5">
                    <div style = "" class = "p-2 shadow">
                        @include('dashboard.users.auction.partial.paid-auction')
                    </div>
                </div>
                <div class = "col-md-12 mt-5">
                    <div style = "" class = "p-2 shadow">
                        @include('dashboard.users.auction.partial.failed-auction')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-shadow-box>
@endsection