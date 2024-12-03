@extends('layouts.master')

@section('content')
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-section-head>
                    <p style = "font-size: 13px">
                        
                    </p>
                    Create a new user:
                </x-section-head>
                <form action="{{route('dashboard.users.store')}}" method = "POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label><span class = "required">*</span>
                        <x-form-input type="text" name="name" placeholder="Enter User Name" value="{{ old('name')}}"></x-form-input>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label><span class = "required">*</span>
                        @error("email")
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <x-form-input type="email" name="email" placeholder="Enter Email Address" value="{{ old('email')}}"></x-form-input>
                    </div>
                    <div class="form-group">
                        <label for="position">Confirm Password:</label><span class = "required">*</span>
                        <x-form-input type="password" name="password" value="{{ old('password')}}"></x-form-input>
                    </div>
                    <div class="form-group">
                        <label for="position">Confirm Password:</label><span class = "required">*</span>
                        <x-form-input type="password" name="password_confirmation" value="{{ old('confirm_password')}}"></x-form-input>
                    </div>
                    <x-button type="submit" buttonClass="btn btn-primary">Create</x-button>
                </form>
            </div>
        </div>
    </x-shadow-box>
@endsection