<template>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <a class="nav-link" :class="route().current('dashboard') ? 'active' : ''" :href="route('dashboard')">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-fw"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Settings</div>
                <a class="nav-link" :class="route().current('images.index') ? 'active' : ''" :href="route('images.index')">
                    <div class="sb-nav-link-icon"><i class="fas fa-images fa-fw"></i></div>
                    Images
                </a>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <small>{{$page.props.auth.user.name}}</small> /
            <small>{{$page.props.auth.user.email}}</small>
        </div>
    </nav>
</template>
