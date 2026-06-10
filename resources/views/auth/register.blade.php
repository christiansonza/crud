@extends('layouts.auth')

@section('title', 'Register')

@section('content')

<div class="col-md-4 mx-auto mt-5">

    <h2 class="mb-3">Register</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>

        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

        <button class="btn btn-primary w-100">Register</button>
    </form>

    <div class="text-center mt-3">
        <a href="/login">Already have an account?</a>
    </div>

</div>

@endsection