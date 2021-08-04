<template>
    <authenticated-layout>
        <div class="container-fluid px-4">
            <breadcrumbs title="Activity Log">
                <li class="breadcrumb-item"><a :href="route('dashboard')"><i class="fas fa-tachometer-alt fa-lg fa-fw"></i></a></li>
                <li class="breadcrumb-item active">Activity Log</li>
            </breadcrumbs>

            <div class="row">
                <div class="col">
                    <card>
                        <template #header>
                            20 Recent Logs
                        </template>

                        <ul v-if="logs.length > 0" class="list-group list-group-flush">
                            <li v-for="item in logs" :key="item.id" class="list-group-item d-flex justify-content-between">
                                <small>{{item.log}}</small>
                                <small class="text-info">{{dateFormat(item.created_at)}}</small>
                            </li>
                        </ul>

                        <h3 v-else><i class="fas fa-tired fa-sm fa-fw"></i> No logs</h3>
                    </card>
                </div>
            </div>
        </div>

    </authenticated-layout>
</template>

<script>
    import AuthenticatedLayout from '@/Layouts/Authenticated'
    import Breadcrumbs from '@/Components/Breadcrumbs'
    import Card from '@/Components/Card'
    import moment from 'moment'

    export default {
        components: {
            AuthenticatedLayout,
            Breadcrumbs,
            Card,
        },

        props: ['logs'],

        computed: {
            dateFormat() {
                return date => moment(date).format('dddd, MMMM Do YYYY hh:mm:ss')
            }
        }
    }
</script>
