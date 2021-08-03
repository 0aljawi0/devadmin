<template>
    <authenticated-layout>
        <div class="container-fluid px-4">
            <breadcrumbs title="Dashboard">
                <li class="breadcrumb-item active">Dashboard</li>
            </breadcrumbs>

            <div class="row">

            </div>
        </div>
    </authenticated-layout>
</template>

<script>
    import AuthenticatedLayout from '@/Layouts/Authenticated'
    import Breadcrumbs from '@/Components/Breadcrumbs'

    export default {
        components: {
            AuthenticatedLayout,
            Breadcrumbs,
        },
    }
</script>
