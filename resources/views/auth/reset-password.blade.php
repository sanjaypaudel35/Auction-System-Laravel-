@extends('layouts.login_page_master')

@section('content')
<div class="container" style = "height: 100vh">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card py-4">
                <div class = "d-flex flex-column align-items-center">
                    <h3><b style="color: teal">ART AUCTION</b></h3>
                    <h3>Reset Password</h3></br>
                    <i class="fa-solid fa-key fa-2x"></i></br>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class = "col-form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
        <label for="email" class = "col-form-label">Password</label>

            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="email" class = "col-form-label">Confirm Password</label>


            <input id="password_confirmation" class="form-control"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

              @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
        <button type="submit" class="btn btn-primary">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>
@endsection