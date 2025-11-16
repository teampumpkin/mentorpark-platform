<!-- Menu -->
<!-- Sidenav Menu Start -->
<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
                <span class="logo-light">
                    <span class="logo-lg"><img src="https://www.internpark.com/images/mentorpark_logo.jpg" alt="logo"></span>
                    <span class="logo-sm"><img src="https://www.internpark.com/images/mentorpark_logo.jpg" alt="small logo"></span>
                </span>

        <span class="logo-dark">
                    <span class="logo-lg"><img src="https://www.internpark.com/images/mentorpark_logo.jpg" alt="dark logo"></span>
                    <span class="logo-sm"><img src="https://www.internpark.com/images/mentorpark_logo.jpg" alt="small logo"></span>
                </span>
    </a>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-fullsidebar">
        <i class="ri-close-line align-middle"></i>
    </button>

    <div data-simplebar>

        <!--- Sidenav Menu -->
        <ul class="side-nav">
            <li class="side-nav-title">Navigation</li>

            <li class="side-nav-item">
                <a href="{{ route('dashboard') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="airplay"></i></span>
                    <span class="menu-text"> Dashboard </span>
{{--                    <span class="badge bg-danger rounded">3</span>--}}
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('users.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="user"></i></span>
                    <span class="menu-text"> Users </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarRoles" aria-expanded="false" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="shield-check"></i></span>
                    <span class="menu-text"> Roles & Permissions</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarRoles">
                    <ul class="sub-menu">
                        <li class="side-nav-item"><a href="{{ route('roles.index') }}" class="side-nav-link">Roles</a></li>
                        <li class="side-nav-item"><a href="{{ route('permissions.index') }}" class="side-nav-link">Permissions</a></li>
                    </ul>
                </div>
            </li>


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarInvoice" aria-expanded="false" aria-controls="sidebarInvoice"
                   class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="layout-grid"></i></span>
                    <span class="menu-text"> Masters</span>
                    <span class="menu-arrow"></span>
                </a>


                <div class="collapse" id="sidebarInvoice" style="">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('master.goals.index') }}" class="side-nav-link">
                                <span class="menu-text">Goals</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('master.skills.index') }}" class="side-nav-link">
                                <span class="menu-text">Skills</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('organization.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="user"></i></span>
                    <span class="menu-text"> Organization </span>
                </a>
            </li>


        </ul>

        <div class="clearfix"></div>
    </div>
</div>
<!-- Sidenav Menu End -->
