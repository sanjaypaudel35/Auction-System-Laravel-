@extends('layouts.login_page_master')

@section('content')
<div class="container" style = "height: 100vh">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card py-4">
                <div class = "d-flex flex-column align-items-center">
                    <h3><b style="color: teal">ART AUCTION</b></h3>
                    <h3>Forget Password</h3></br>
                    <i class="fa-solid fa-key fa-2x"></i></br>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="col-form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Email Password Reset Link') }}
            </button>
            @if (session('status'))
                <div class="alert alert-success mt-2">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </form>

</div>
</div>
</div>
</div>
</div>
@endsection

