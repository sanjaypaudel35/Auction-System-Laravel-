@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('frontend.pages.profile.account.partial.account-head-tabs')
            </div>
            <div class="col-md-12">
                <form action="{{ route('profile.account.password.edit') }}" method = "post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label for="current_password">Current Password:</label><span class="required">*</span>
                        <input type="password" class="form-control" required = "required" name = "current_password" placeholder = "Enter your Current Password">
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