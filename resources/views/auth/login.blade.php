@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="col-md-4 mx-auto mt-5">

    <h2 class="mb-3">Login</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

        <button class="btn btn-success w-100">Login</button>
    </form>

    <div class="text-center mt-3">
        <a href="/register">Create account</a>
    </div>

</div>

@endsection