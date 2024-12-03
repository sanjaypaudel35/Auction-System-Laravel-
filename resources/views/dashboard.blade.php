
@extends('layouts.master')

@section('content')
<x-shadow-box shadowClass="shadow">
    <div class="container-fluid">
        <x-dashboard-overall-visualizer
            :pendingAuctionsCount="$pending_auctions"
            :liveAuctionsCount="$live_auctions"
            :upcomingAuctionsCount="$upcoming_auctions"
            :pendingFundTransfer="$pending_fund_transfer"
            :oldAuctions="$expiredProducts"
            :systemAdmins="$system_admins"
            :registeredUsers="$registered_users"
        >
        </x-dashboard-overall-visualizer>
    </div>
</x-shadow-box>
@endsection

