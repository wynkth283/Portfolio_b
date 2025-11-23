<nav class="navbar container">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-start text-bg-primary" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Admin Portfolio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                <ul class="navbar-nav justify-content-end flex-grow-1">
                    <li class="nav-item nav-item-x">
                        <a class="nav-link text-white" aria-current="page" href="/">Dashboard</a>
                    </li>
                    <li class="nav-item nav-item-x">
                        <a class="nav-link text-white" href="/users">Users</a>
                    </li>
                    <li class="nav-item nav-item-x dropdown">
                        <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Skill Group
                        </a>
                        <ul class="dropdown-menu dropdown-menu-x p-0">
                            <li><a class="dropdown-item" href="/skills-title">Skill title</a></li>
                            <li>
                                <hr class="dropdown-divider m-0">
                            </li>
                            <li><a class="dropdown-item" href="/skills">Skills</a></li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-x dropdown">
                        <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Project Group
                        </a>
                        <ul class="dropdown-menu dropdown-menu-x p-0">
                            <li><a class="dropdown-item" href="/projects">Projects</a></li>
                            <li>
                                <hr class="dropdown-divider m-0">
                            </li>
                            <li><a class="dropdown-item" href="/project-links">Project link</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- dropdown user -->
        <div class="dropdown">
            <button type="button" class="dropdown-toggle btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('IMG/hero.jpg') }}" alt="" width="32" height="32" class="rounded-circle me-2">
                User
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
    </div>
</nav>