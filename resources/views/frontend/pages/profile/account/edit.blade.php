@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('frontend.pages.profile.account.partial.account-head-tabs')
            </div>
            <div class="col-md-12">
                <form action="{{ route('profile.account.update') }}" method = "post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label for="usr">Name:</label><span class="required">*</span>
                        <input type="text" class="form-control" value = "{{ auth()->user()->name }}" name = "name" id="name" placeholder = "Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="usr">Address:</label><span class="required">*</span>
                        <input type="text" class="form-control" value = "{{ auth()->user()->address }}" name = "address" id="address" placeholder = "Enter your address">
                    </div>
                    <div class="form-group">
                        <label for="usr">Phone Number:</label><span class="required">*</span>
                        <input type="text" class="form-control" value = "{{ auth()->user()->phone_number }}" name = "phone_number" id="phone_number" placeholder = "Enter your phone number">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </x-shadow-box>
</div>
@endsection
@section('js')
<script>
</script>
@endsection