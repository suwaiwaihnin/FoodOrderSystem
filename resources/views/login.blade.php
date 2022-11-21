@extends('layouts.master')

@section('title','Login Page')

@section('content')
    <div class="login-form">
        <form action="{{ route('login') }}" method="post">
            @csrf

            @error('terms')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <div class="form-group">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
            </div>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
            </div>

            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>

        </form>

        <div class="register-link">
            <p>
                Don't you have account?
                <a href="{{ route('auth.register') }}">Sign Up Here</a>
            </p>
        </div>
    </div>
@endsection

