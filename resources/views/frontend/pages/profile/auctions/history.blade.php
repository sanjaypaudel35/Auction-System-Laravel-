@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-section-head>
                    {{ $info['title'] }}
                </x-section-head>
            </div>
            <div class="col-md-12">
                @include('frontend.pages.profile.auctions.partial.auction-head-tabs')
            </div>
            <div class="col-md-12">
                @include('frontend.pages.profile.auctions.partial.auction-history-filter')
            </div>
            <div class="col-md-12">
                <div class="tab-content">
                    <div id="paid_auction" class="tab-pane fade show active">
                        @include('frontend.pages.profile.auctions.partial.paid-auction')
                    </div>
                    <div id="unpaid_auction" class="tab-pane fade">
                        @include('frontend.pages.profile.auctions.partial.unpaid-auction')
                    </div>
                    <div id="unsuccess_auction" class="tab-pane fade">
                        @include('frontend.pages.profile.auctions.partial.unsuccess-auction')
                    </div>
                </div>
            </div>
        </div>
</div>
</x-shadow-box>
</div>
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