
@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center p-3">
        @foreach ($products as $key => $product)
        <div class="col-md-4">
            <x-auction-card :product="$product"></x-auction-card>
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
@endsection

