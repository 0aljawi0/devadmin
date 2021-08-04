<template>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-topbar">

        <a class="navbar-brand ps-3" :href="route('dashboard')">
            <app-logo class="me-2"/>
            <span class="text-light">DEVADMIN</span>
        </a>

        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#"><i class="far fa-minus-square fa-lg fa-fw"></i></button>

        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </div>

        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v fa-lg fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end rounded-10 scale-in-top" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" :href="route('users.index')">User Management</a></li>
                    <li><a class="dropdown-item" :href="route('roles.index')">Role Management</a></li>
                    <li><a class="dropdown-item" :href="route('activitylog.index')">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <inertia-link class="dropdown-item" :href="route('logout')" method="post" as="button">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw"></i>
                            Sign Out
                        </inertia-link>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</template>

<script>
    import AppLogo from '@/Components/ApplicationLogoLight'

    export default {
        components: {
            AppLogo
        }
    }
</script>
