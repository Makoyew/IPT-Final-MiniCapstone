<nav class="navbar navbar-expand-lg p-3" style="background-color: #a5a2ae">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-graduation-cap"></i> LMS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link mx-2" href="/dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                @role('administrator')
                <li class="nav-item">
                    <a class="nav-link mx-2" href="/users">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                @endrole
                <li class="nav-item">
                    <a class="nav-link mx-2" href="/courses">
                        <i class="fas fa-book"></i> Courses
                    </a>
                </li>
                @role('administrator')
                <li class="nav-item">
                    <a class="nav-link mx-2" href="/enrollments">
                        <i class="fas fa-clipboard-check"></i> Enrollments
                    </a>
                </li>
                @endrole
                <li class="nav-item">
                    <a class="nav-link mx-2" href="/charges">
                        <i class="fas fa-dollar-sign"></i> Summary of Charges
                    </a>
                </li>
                @role('administrator')
                <li class="nav-item">
                    <a class="nav-link mx-2" href="/logs">
                        <i class="fas fa-file-alt"></i> Logs
                    </a>
                </li>
                @endrole
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf <!-- Include a CSRF token for security -->
                        <button type="submit" class="nav-link btn btn-link mx-2">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
