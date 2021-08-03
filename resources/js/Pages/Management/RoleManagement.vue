<template>
    <authenticated-layout>
        <div class="container-fluid px-4">
            <breadcrumbs title="Role Management">
                <li class="breadcrumb-item"><a :href="route('dashboard')"><i class="fas fa-tachometer-alt fa-lg fa-fw"></i></a></li>
                <li class="breadcrumb-item active">Role Management</li>
            </breadcrumbs>

            <div class="row">
                <div class="col">
                    <card>
                        <template #header>
                            <div class="btn-group">
                                <button v-on:click="openModalRole" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle fa-lg fa-fw"></i> Add Role</button>
                                <button v-if="roles.data.length > 0" v-on:click="deleteRoleBulk" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt fa-lg fa-fw"></i> Delete Bulk</button>
                            </div>

                        </template>

                        <table v-if="roles.data.length > 0" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%"><i class="fas fa-hashtag fa-sm fa-fw"></i></th>
                                    <th width="70%">Title</th>
                                    <th width="20%">Manages</th>
                                    <th width="5%"><i class="fas fa-ellipsis-h fa-sm fa-fw"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in roles.data" :key="item.id">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" v-model="check" :value="item.id">
                                        </div>
                                    </td>
                                    <td>{{item.title}}</td>
                                    <td>
                                        <button v-on:click="openModalManage(item.manages)"  class="btn btn-secondary btn-sm">Manage Role</button>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button v-on:click="openModalRoleUpdate(item)" class="btn btn-outline-primary btn-sm"><i class="fas fa-pencil-alt fa-lg fa-fw"></i></button>
                                            <button v-on:click="deleteRole(item.id)" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt fa-lg fa-fw"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 v-else><i class="fas fa-tired fa-sm fa-fw"></i> No data, Let's make it</h3>

                        <pagination v-if="roles.data.length > 0" :links="roles.links" />
                    </card>
                </div>
            </div>
        </div>

        <!-- Modal Manages -->
        <div class="modal fade" id="modalManage" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered ">
                <div class="modal-content shadow-lg">
                    <div class="modal-body">

                        <table v-if="manages.length > 0" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="30%">MENU NAME</th>
                                    <th width="15%" class="text-center">READ</th>
                                    <th width="15%" class="text-center">ADD</th>
                                    <th width="15%" class="text-center">UPDATE</th>
                                    <th width="15%" class="text-center">DELETE</th>
                                    <th width="10%" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in manages" :key="item.id">
                                    <td class="text-uppercase">{{item.menu}}</td>
                                    <td class="text-uppercase text-center">
                                        <p v-if="item.pivot.read" class="text-success mb-0">
                                            <i class="fas fa-check-circle fa-sm fa-fw"></i>
                                        </p>
                                        <p v-else class="text-danger mb-0">
                                            <i class="fas fa-times-circle fa-sm fa-fw"></i>
                                        </p>
                                    </td>
                                    <td class="text-uppercase text-center">
                                        <p v-if="item.pivot.add" class="text-success mb-0">
                                            <i class="fas fa-check-circle fa-sm fa-fw"></i>
                                        </p>
                                        <p v-else class="text-danger mb-0">
                                            <i class="fas fa-times-circle fa-sm fa-fw"></i>
                                        </p>
                                    </td>
                                    <td class="text-uppercase text-center">
                                        <p v-if="item.pivot.update" class="text-success mb-0">
                                            <i class="fas fa-check-circle fa-sm fa-fw"></i>
                                        </p>
                                        <p v-else class="text-danger mb-0">
                                            <i class="fas fa-times-circle fa-sm fa-fw"></i>
                                        </p>
                                    </td>
                                    <td class="text-uppercase text-center">
                                        <p v-if="item.pivot.delete" class="text-success mb-0">
                                            <i class="fas fa-check-circle fa-sm fa-fw"></i>
                                        </p>
                                        <p v-else class="text-danger mb-0">
                                            <i class="fas fa-times-circle fa-sm fa-fw"></i>
                                        </p>
                                    </td>
                                    <td>
                                        <button v-on:click="openModalManageForm(item)" class="btn btn-sm btn-outline-primary"><i class="fas fa-pen-alt fa-lg fa-fw"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="btn-group">
                            <button type="button" v-on:click="closeModalManage" class="btn btn-danger btn-sm"><i class="fas fa-times-circle fa-lg fa-fw"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Manage Form -->
        <div class="modal fade" id="modalManageForm" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content shadow-lg">
                    <div class="modal-body">

                        <h4 class="mb-3 text-uppercase">{{formManage.menu}}</h4>

                        <form @submit.prevent="submitManage">
                            <input type="hidden" v-model="formManage.id">

                            <div class="d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="formManage.read" true-value="1" false-value="0">
                                    <label class="form-check-label">Read</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="formManage.add" true-value="1" false-value="0">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="formManage.update" true-value="1" false-value="0">
                                    <label class="form-check-label">Update</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="formManage.delete" true-value="1" false-value="0">
                                    <label class="form-check-label">Delete</label>
                                </div>
                            </div>

                            <hr>

                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary btn-sm" :disabled="formManage.processing">
                                    <span v-if="formManage.processing">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        process...
                                    </span>
                                    <span v-else><i class="fas fa-save fa-lg fa-fw"></i> Save</span>
                                </button>
                                <button type="button" v-on:click="closeModalManageForm" class="btn btn-danger btn-sm" :disabled="formManage.processing"><i class="fas fa-times-circle fa-lg fa-fw"></i> Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Role Form -->
        <div class="modal fade" id="modalRole" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content shadow-lg">
                    <div class="modal-body">
                        <form @submit.prevent="submitRole">
                            <input type="hidden" v-model="formRole.id">

                            <div class="mb-3">
                                <label for="title">Role Title</label>
                                <breeze-input id="title" type="title" v-model="formRole.title"/>
                                <validation :validation="formRole.errors.title" />
                            </div>

                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary btn-sm" :disabled="formRole.processing">
                                    <span v-if="formRole.processing">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        process...
                                    </span>
                                    <span v-else><i class="fas fa-save fa-lg fa-fw"></i> Save</span>
                                </button>
                                <button type="button" v-on:click="closeModalRole" class="btn btn-danger btn-sm" :disabled="formRole.processing"><i class="fas fa-times-circle fa-lg fa-fw"></i> Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </authenticated-layout>
</template>

<script>
    import AuthenticatedLayout from '@/Layouts/Authenticated'
    import Breadcrumbs from '@/Components/Breadcrumbs'
    import Card from '@/Components/Card'
    import BreezeInput from '@/Components/Input'
    import Validation from '@/Components/Validation'
    import Pagination from '@/Components/Pagination'
    import { createToast } from 'mosha-vue-toastify'

    export default {
        components: {
            AuthenticatedLayout,
            Breadcrumbs,
            Card,
            BreezeInput,
            Validation,
            Pagination
        },

        props: ['roles'],

        data() {
            return {
                // ROLE
                modal: null,
                check:[],
                formRole: this.$inertia.form({
                    id: '',
                    title: ''
                }),

                // MANAGE
                modalManage: null,
                modalManageForm: null,
                manages: [],
                formManage: this.$inertia.form({
                    id:'',
                    menu: '',
                    role_id: '',
                    read: 0,
                    add: 0,
                    update: 0,
                    delete: 0
                }),
            }
        },

        methods: {
            // ROLE

            openModalRole() {
                this.formRole.clearErrors();
                this.modal.show();
            },

            closeModalRole() {
                this.formRole.reset();
                this.formRole.clearErrors();
                this.modal.hide();
            },

            openModalRoleUpdate(item) {
                this.formRole.id = item.id;
                this.formRole.title = item.title;
                this.openModalRole();
            },

            submitRole() {
                if (this.formRole.id == '') {
                    this.formRole
                        .post(this.route('roles.store'), {
                            preserveScroll: true,
                            onSuccess: () => {
                                this.closeModalRole();
                                createToast(this.$page.props.flash.message, {type: 'success'});
                            }
                        })
                } else {
                    this.formRole
                        .transform(data => ({
                            ...data,
                            '_method': 'put'
                        }))
                        .post(this.route('roles.update', {role: this.formRole.id}), {
                            preserveScroll: true,
                            onSuccess: () => {
                                this.closeModalRole();
                                createToast(this.$page.props.flash.message, {type: 'success'});
                            }
                        })
                }
            },

            deleteRole(id) {
                this.$inertia
                    .delete(this.route('roles.destroy', {role: id}), {
                        reserveScroll: true,
                        onSuccess: () => {
                            createToast(this.$page.props.flash.message, {type: 'success'});
                        }
                    })
            },

            deleteRoleBulk() {
                if (this.check.length > 0) {
                    this.$inertia.post(this.route('roles.destroy.bulk'), {check: this.check}, {
                        preserveScroll: true,
                        onSuccess: () => createToast(this.$page.props.flash.message, {type: 'success'})
                    })
                } else {
                    createToast(`Select the data to be deleted`, {type: 'warning'})
                }
            },

            // MANAGE

            openModalManage(manages) {
                this.manages = manages;
                this.modalManage.show();
            },

            closeModalManage() {
                this.modalManage.hide();
            },

            openModalManageForm(item) {
                this.formManage.id = item.id;
                this.formManage.menu = item.menu;
                this.formManage.role_id = item.pivot.role_id;
                this.formManage.read = item.pivot.read;
                this.formManage.add = item.pivot.add;
                this.formManage.update = item.pivot.update;
                this.formManage.delete = item.pivot.delete;
                this.modalManageForm.show();
                this.closeModalManage();
            },

            closeModalManageForm() {
                this.formManage.reset();
                this.modalManageForm.hide();
            },

            submitManage() {
                let role_id = this.formManage.role_id;
                this.formManage.put(route('manages.update', {manage: this.formManage.id}), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeModalManageForm();
                        this.roles.data.map(item => {
                            if (item.id == role_id) {
                                this.openModalManage(item.manages);
                            }
                        })
                        createToast(this.$page.props.flash.message, {type: 'success'});
                    }
                })
            }
        },

        mounted() {
            this.modal = new window.bootstrap.Modal(document.getElementById('modalRole'), {keyboard: false, backdrop: false});
            this.modalManage = new window.bootstrap.Modal(document.getElementById('modalManage'), {keyboard: false, backdrop: false});
            this.modalManageForm = new window.bootstrap.Modal(document.getElementById('modalManageForm'), {keyboard: false, backdrop: false});
        }
    }
</script>
