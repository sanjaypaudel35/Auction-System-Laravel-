@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{ route('dashboard.profile.update') }}" method = "post">
                    @csrf
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
                    <div class="form-group">
                        <label for="current_password">Old Password:</label><span class="required">*</span>
                        <input type="password" class="form-control" required = "required" name = "old_password" placeholder = "Enter your Current Password">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password:</label><span class="required">*</span>
                        <input type="password" class="form-control" required = "required" name = "password" placeholder = "Enter your New Password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label><span class="required">*</span>
                        <input type="password" class="form-control" required = "required" name = "password_confirmation" placeholder = "Confirm your password.">
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