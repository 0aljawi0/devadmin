<template>
    <div class="sb-nav-fixed">

        <top-navigation />

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <side-navigation />
            </div>

            <div id="layoutSidenav_content" class="bg-admin">
                <main class="mb-4">
                    <slot />
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; DEVADMIN {{getThisYear}}</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

    </div>
</template>

<script>
    import TopNavigation from '@/Layouts/TopNavigation'
    import SideNavigation from '@/Layouts/SideNavigation'

    export default {
        components: {
            TopNavigation,
            SideNavigation
        },

        computed: {
            getThisYear() {
                let d = new Date();
                return d.getFullYear().toString();
            }
        },

        mounted() {
            let sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
                });
            }
        }
    }
</script>
