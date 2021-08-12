<template>
    <authenticated-layout>
        <div v-if="roles.manages[0].pivot.read == 1" class="container-fluid px-4">
            <breadcrumbs title="Pages">
                <li class="breadcrumb-item"><i class="fas fa-cog fa-lg fa-fw"></i></li>
                <li class="breadcrumb-item active">Pages</li>
            </breadcrumbs>

            <div class="row">
                <div class="col">
                    <card>
                        <template #header>
                            <div class="btn-group">
                                <a v-show="roles.manages[0].pivot.add == 1" :href="route('pages.action')" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle fa-lg fa-fw"></i> New Page</a>
                                <button v-show="roles.manages[0].pivot.delete == 1 && pages.data.length > 0" @click="destroyBulk" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt fa-lg fa-fw"></i> Delete Bulk</button>
                            </div>
                        </template>

                        <table v-if="pages.data.length > 0" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%"><i class="fas fa-hashtag fa-sm fa-fw"></i></th>
                                    <th width="35%">Title</th>
                                    <th width="15%">Status</th>
                                    <th width="10%">Type</th>
                                    <th width="20%">Date</th>
                                    <th width="10%" class="text-center"><i class="fas fa-ellipsis-h fa-sm fa-fw"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in pages.data" :key="item.id">
                                    <td>
                                        <div v-show="roles.manages[0].pivot.delete == 1" class="form-check">
                                            <input v-show="item.type == 'Page'" class="form-check-input" type="checkbox" v-model="check" :value="item.id">
                                        </div>
                                    </td>
                                    <td>{{item.title}}</td>
                                    <td>
                                        <span>{{item.status}}</span>
                                        <button v-show="roles.manages[0].pivot.update == 1 && item.type == 'Page'" @click="updateStatus(item.id)" class="btn btn-outline-primary btn-sm ms-2"><i class="fas fa-exchange-alt fa-lg fa-fw"></i></button>
                                    </td>
                                    <td><small class="text-primary">{{item.type}}</small></td>
                                    <td><small class="text-muted">{{dateFormat(item.updated_at)}}</small></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a v-show="roles.manages[0].pivot.update == 1 && item.type == 'Page'" :href="route('pages.action', {id: item.id})" class="btn btn-outline-primary btn-sm"><i class="fas fa-pencil-alt fa-lg fa-fw"></i></a>
                                            <button v-show="roles.manages[0].pivot.delete == 1 && item.type == 'Page'" @click="destroy(item.id)" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt fa-lg fa-fw"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 v-else><i class="fas fa-tired fa-sm fa-fw"></i> No data, Let's make it</h3>

                        <pagination v-if="pages.data.length > 0" :links="pages.links" />
                    </card>
                </div>
            </div>
        </div>

        <div v-else class="container-fluid px-4">
            <breadcrumbs title="Warning!">
                <li for="breadcrumb-item"><h3><i class="fas fa-lock fa-sm fa-fw"></i> You are not authorized to open this page</h3></li>
            </breadcrumbs>
        </div>

    </authenticated-layout>
</template>

<script>
    import AuthenticatedLayout from '@/Layouts/Authenticated'
    import Breadcrumbs from '@/Components/Breadcrumbs'
    import Card from '@/Components/Card'
    import Pagination from '@/Components/Pagination'
    import { createToast } from 'mosha-vue-toastify'
    import moment from 'moment'

    export default {
        components: {
            AuthenticatedLayout,
            Breadcrumbs,
            Card,
            Pagination,
        },

        props: ['pages', 'roles', 'asset'],

        data() {
            return {
                check: [],
            }
        },

        computed: {
            dateFormat() {
                return date => moment(date).format('ddd, MMM Do YY hh:mm a')
            }
        },

        methods: {
            updateStatus(id) {
                this.$inertia.get(route('pages.update.status', {id: id}), {
                    preserveScroll: true,
                    onSuccess: () => createToast(this.$page.props.flash.message, {type: 'success'})
                })
            },

            destroy(id) {
                this.$inertia.delete(this.route('pages.destroy', {page: id}), {
                    preserveScroll: true,
                    onSuccess: () => createToast(this.$page.props.flash.message, {type: 'success'})
                })
            },

            destroyBulk() {
                if (this.check.length > 0) {
                    this.$inertia.post(this.route('pages.destroy.bulk'), {check: this.check}, {
                        preserveScroll: true,
                        onSuccess: () => createToast(this.$page.props.flash.message, {type: 'success'})
                    })
                } else {
                    createToast(`Select the data to be deleted`, {type: 'warning'})
                }
            },
        },
    }
</script>
