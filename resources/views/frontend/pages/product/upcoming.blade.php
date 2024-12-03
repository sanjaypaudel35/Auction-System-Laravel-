@extends('frontend.layouts.master')

@section('content')
@php
$bgImageUrl = asset("assets/system_images/auction-background.jpg");
@endphp
<div class="live-auction-background-image" style="background-image: url({{$bgImageUrl}})">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="home-page-header-section text-center my-3">
                    <h3>Upcoming Auction</h3>
                    <p>All the upcoming products for bidding.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center p-3">
            @include('includes.frontend.categories')
            <div class="col-md-9">
                <div class="row">
                    @foreach ($products as $key => $product)
                    <div class="col-md-3 my-4">
                        <x-auction-card :product="$product"></x-auction-card>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{ $products->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        @endsection