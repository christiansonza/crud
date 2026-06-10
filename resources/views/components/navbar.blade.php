<nav class="navbar navbar-dark bg-dark px-3">

    <a class="navbar-brand" href="/dashboard">
        Employee System
    </a>

    <div class="ms-auto d-flex align-items-center gap-3 text-white">

        <span>
            Welcome, {{ Session::get('user_name') }}
        </span>

        <a href="/logout" class="btn btn-danger btn-sm">
            Logout
        </a>

    </div>

</nav>