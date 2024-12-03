
@extends('frontend.layouts.master')

@section('content')
@php
$bgImageUrl = asset("assets/system_images/auction-background.jpg");
@endphp
<div class = "live-auction-background-image" style = "background-image: url({{$bgImageUrl}});">
<div class="container">
    <div class = "row">
        <div class = "col-md-12">
            <div class = "home-page-header-section text-center my-3">
                <h3>Live Auction</h3>
                <p>You are welcome to attend and join in the action at any of our upcoming auctions.</p>
                <a href = "{{ route('auctions.live') }}">View all .. </a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center p-3">
        @foreach ($products["live"] as $key => $product)
        <div class="col-md-4 my-4">
            <x-auction-card :product="$product"></x-auction-card>
        </div>
        @endforeach
    </div>
</div>
<div>
<div class = "upcoming-auction mt-5">
    <div>
    <div class="container">
    <div class = "row">
        <div class = "col-md-12">
            <div class = "home-page-header-section text-center my-3">
                <h2>Upcoming Auction</h2>
                <p>You are welcome to attend and join in the action at any of our upcoming auctions.</p>
                <a href = "{{ route('auctions.upcoming') }}">View all .. </a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center p-3">
        @foreach ($products["upcoming"] as $key => $product)
        <div class="col-md-4 my-4">
            <x-upcoming-auction-card :product="$product"></x-upcoming-auction-card>
        </div>
        @endforeach
        <!-- <div class="col-md-4">
            <x-auction-card/>
        </div>
        <div class="col-md-4">
            <x-auction-card/>
        </div> -->
    </div>
</div>
    </div>
</div>
@endsection



