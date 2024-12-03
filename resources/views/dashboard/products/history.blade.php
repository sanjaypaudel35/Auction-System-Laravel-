@extends('layouts.master')

@section('content')
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-section-head>
                    {{ $info['title'] }}
                </x-section-head>
            </div>

            <!-- <div class="col-md-12">
                <ul class="nav dashboard-product-tab mb-3" id="myTab" role="tablist">
                    <li>
                        <a class="nav-link active" id = "dashboard.products.pending" href="{{ route('dashboard.products.pending') }}">Pending Products</a>
                    </li>
                    <li>
                        <a class="nav-link" id = "dashboard.products.live" href="{{ route('dashboard.products.live') }}">Live Auction</a>
                    </li>
                    <li>
                        <a class="nav-link" id = "dashboard.products.upcoming" href="{{ route('dashboard.products.upcoming') }}">Upcoming Auction</a>
                    </li>
                    <li>
                        <a class="nav-link" id = "dashboard.products.history" href="{{ route('dashboard.products.history') }}">Auction History</a>
                    </li>
                </ul>
            </div> -->

            <div class = "col-md-12">
                <select class="form-select mb-3" id="auction-selector">
                    <option value="#all_old_auction">All</option>
                    <option value="#old_auction_paid">Paid Auction</option>
                    <option value="#old_auction_unpaid">Unpaid Auction</option>
                    <option value="#old_auction_failed">Failed Auction (No Bids)</option>
                </select>
            </div>
            <div class = "col-md-12">
                <div class="tab-content">
                    <div id="all_old_auction" class="tab-pane fade show active">
                        @include('dashboard.products.partials.auction-history-all')
                    </div>
                    <div id="old_auction_paid" class="tab-pane fade">
                        @include('dashboard.products.partials.auction-history-paid')
                    </div>
                    <div id="old_auction_unpaid" class="tab-pane fade">
                        @include('dashboard.products.partials.auction-history-unpaid')
                    </div>
                    <div id="old_auction_failed" class="tab-pane fade">
                        @include('dashboard.products.partials.auction-history-failed')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-shadow-box>
@endsection
@section("js")
<script>
    $(document).ready(function() {
        // Attach a change event listener to the select input
        $('#auction-selector').change(function() {
            // Hide all tab panes
            $('.tab-pane').removeClass('show active');

            // Show the selected tab pane
            $($(this).val()).addClass('show active');
        });
    });
</script>
@endsection