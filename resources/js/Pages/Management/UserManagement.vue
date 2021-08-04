<template>
    <authenticated-layout>
        <div class="container-fluid px-4">
            <breadcrumbs title="User Management">
                <li class="breadcrumb-item"><a :href="route('dashboard')"><i class="fas fa-tachometer-alt fa-lg fa-fw"></i></a></li>
                <li class="breadcrumb-item active">User Management</li>
            </breadcrumbs>

            <div class="row">
                <div class="col">
                    <card>
                        <template #header>
                            <div class="btn-group">
                                <button @click="openModalUser" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle fa-lg fa-fw"></i> Add User</button>
                                <button v-if="users.data.length > 0" @click="deleteUserBulk" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt fa-lg fa-fw"></i> Delete Bulk</button>
                            </div>
                        </template>

                        <table v-if="users.data.length > 0" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%"><i class="fas fa-hashtag fa-sm fa-fw"></i></th>
                                    <th width="35%">Name</th>
                                    <th width="25%">Email</th>
                                    <th width="25%">Role</th>
                                    <th width="10%" class="text-center"><i class="fas fa-ellipsis-h fa-sm fa-fw"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in users.data" :key="item.id">
                                    <td>
                                        <div v-if="item.role_id > 0" class="form-check">
                                            <input class="form-check-input" type="checkbox" v-model="check" :value="item.id">
                                        </div>
                                    </td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.email}}</td>
                                    <td>{{item.role_id == 0 ? 'Administrator' : item.role.title}}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button @click="openModalProfile(item)" class="btn btn-outline-primary btn-sm"><i class="fas fa-pencil-alt fa-lg fa-fw"></i></button>
                                            <button @click="openModalPassword(item)" class="btn btn-outline-primary btn-sm"><i class="fas fa-key fa-lg fa-fw"></i></button>
                                            <button v-if="item.role_id > 0" @click="deleteUser(item.id)" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt fa-lg fa-fw"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 v-else><i class="fas fa-tired fa-sm fa-fw"></i> No data, Let's make it</h3>

                        <pagination v-if="users.data.length > 0" :links="users.links" />
                    </card>
                </div>
            </div>
        </div>

        <!-- Modal User -->
        <modal id="modalUser">
            <h4 class="mb-3 text-uppercase">add user</h4>

            <form @submit.prevent="submitUser">

                <div class="mb-3">
                    <label>Name</label>
                    <breeze-input type="text" v-model="formUser.name"/>
                    <small class="text-info mt-1">{{ formUser.name.length }} character</small> <br>
                    <validation :validation="formUser.errors.name" />
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <breeze-input type="email" v-model="formUser.email"/>
                    <small class="text-info mt-1">{{ formUser.name.length }} character</small> <br>
                    <validation :validation="formUser.errors.email" />
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <Multiselect v-model="formUser.role_id" label="title" trackBy="title" :options="roles" :searchable="true" placeholder="Select role" />
                    <validation :validation="formUser.errors.role_id" />
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <breeze-input type="password" v-model="formUser.password"/>
                    <validation :validation="formUser.errors.password" />
                </div>

                <div class="mb-3">
                    <label>Password Confirm</label>
                    <breeze-input type="password" v-model="formUser.password_confirmation"/>
                    <validation :validation="formUser.errors.password_confirmation" />
                </div>

                <div class="btn-group">
                    <breeze-button class="btn-primary" :disabled="formUser.processing">
                        <button-label :processing="formUser.processing" label="Save"/>
                    </breeze-button>
                    <breeze-button type="button" @click="closeModalUser" class="btn-warning" :disabled="formUser.processing">
                        <i class="fas fa-times-circle fa-lg fa-fw"></i> Close
                    </breeze-button>
                </div>
            </form>
        </modal>

        <!-- Modal Profile -->
        <modal id="modalProfile">
            <h4 class="mb-3 text-uppercase">update profile</h4>

            <form @submit.prevent="submitProfile">

                <div class="mb-3">
                    <label>Name</label>
                    <breeze-input type="text" v-model="formProfile.name"/>
                    <small class="text-info mt-1">{{ formProfile.name.length }} character</small> <br>
                    <validation :validation="formProfile.errors.name" />
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <breeze-input type="email" v-model="formProfile.email"/>
                    <small class="text-info mt-1">{{ formProfile.email.length }} character</small> <br>
                    <validation :validation="formProfile.errors.email" />
                </div>

                <div v-if="formProfile.role_id != 0" class="mb-3">
                    <label>Role</label>
                    <Multiselect v-model="formProfile.role_id" label="title" trackBy="title" :options="roles" :searchable="true" placeholder="Select role" />
                    <validation :validation="formProfile.errors.role_id" />
                </div>

                <div class="btn-group">
                    <breeze-button class="btn-primary" :disabled="formProfile.processing">
                        <button-label :processing="formProfile.processing" label="Save"/>
                    </breeze-button>
                    <breeze-button type="button" @click="closeModalProfile" class="btn-warning" :disabled="formProfile.processing">
                        <i class="fas fa-times-circle fa-lg fa-fw"></i> Close
                    </breeze-button>
                </div>
            </form>
        </modal>

        <!-- Modal Password -->
        <modal id="modalPassword">
            <h4 class="mb-3 text-uppercase">update password</h4>

            <form @submit.prevent="submitPassword">

                <div class="mb-3">
                    <label>Password</label>
                    <breeze-input type="password" v-model="formPassword.password"/>
                    <validation :validation="formPassword.errors.password" />
                </div>

                <div class="mb-3">
                    <label>Password Confirm</label>
                    <breeze-input type="password" v-model="formPassword.password_confirmation"/>
                    <validation :validation="formPassword.errors.password_confirmation" />
                </div>

                <div class="btn-group">
                    <breeze-button class="btn-primary" :disabled="formPassword.processing">
                        <button-label :processing="formPassword.processing" label="Save"/>
                    </breeze-button>
                    <breeze-button type="button" @click="closeModalPassword" class="btn-warning" :disabled="formPassword.processing">
                        <i class="fas fa-times-circle fa-lg fa-fw"></i> Close
                    </breeze-button>
                </div>
            </form>
        </modal>

    </authenticated-layout>
</template>

<script>
    import AuthenticatedLayout from '@/Layouts/Authenticated'
    import Breadcrumbs from '@/Components/Breadcrumbs'
    import Card from '@/Components/Card'
    import Modal from '@/Components/Modal'
    import BreezeInput from '@/Components/Input'
    import BreezeButton from '@/Components/Button'
    import ButtonLabel from '@/Components/ButtonLabel'
    import Validation from '@/Components/Validation'
    import Pagination from '@/Components/Pagination'
    import { createToast } from 'mosha-vue-toastify'
    import Multiselect from '@vueform/multiselect'

    export default {
        components: {
            AuthenticatedLayout,
            Breadcrumbs,
            Card,
            Modal,
            BreezeInput,
            BreezeButton,
            ButtonLabel,
            Validation,
            Pagination,
            Multiselect,
        },

        props: ['users', 'roles'],

        data() {
            return {
                modalUser: null,
                modalProfile: null,
                modalPassword: null,
                check:[],
                formUser: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    role_id: ''
                }),
                formProfile: this.$inertia.form({
                    id: '',
                    name: '',
                    email: '',
                    role_id: '',
                }),
                formPassword: this.$inertia.form({
                    id: '',
                    password: '',
                    password_confirmation:''
                }),
            }
        },

        methods: {
            openModalUser() {
                this.formUser.clearErrors();
                this.modalUser.show();
            },

            closeModalUser() {
                this.formUser.reset();
                this.formUser.clearErrors();
                this.modalUser.hide()
            },

            submitUser() {
                this.formUser.post(this.route('users.store'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeModalUser();
                        createToast(this.$page.props.flash.message, {type: 'success'});
                    }
                })
            },

            openModalProfile(user) {
                this.formProfile.id = user.id;
                this.formProfile.name = user.name;
                this.formProfile.email = user.email;
                this.formProfile.role_id = user.role_id;
                this.formProfile.clearErrors();
                this.modalProfile.show();
            },

            closeModalProfile() {
                this.formProfile.reset();
                this.formProfile.clearErrors();
                this.modalProfile.hide()
            },

            submitProfile() {
                this.formProfile.put(this.route('users.update.profile', {user: this.formProfile.id}), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeModalProfile();
                        createToast(this.$page.props.flash.message, {type: 'success'});
                    }
                })
            },

            openModalPassword(user) {
                this.formPassword.id = user.id;
                this.formPassword.clearErrors();
                this.modalPassword.show();
            },

            closeModalPassword() {
                this.formPassword.reset();
                this.formPassword.clearErrors();
                this.modalPassword.hide()
            },

            submitPassword() {
                this.formPassword.put(this.route('users.update.password', {user: this.formPassword.id}), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeModalPassword();
                        createToast(this.$page.props.flash.message, {type: 'success'});
                    }
                })
            },

            deleteUser(id) {
                this.$inertia
                    .delete(this.route('users.destroy', {user: id}), {
                        preserveScroll: true,
                        onSuccess: () => {
                            createToast(this.$page.props.flash.message, {type: 'success'});
                        }
                    })
            },

            deleteUserBulk() {
                if (this.check.length > 0) {
                    this.$inertia.post(this.route('users.destroy.bulk'), {check: this.check}, {
                        preserveScroll: true,
                        onSuccess: () => createToast(this.$page.props.flash.message, {type: 'success'})
                    })
                } else {
                    createToast(`Select the data to be deleted`, {type: 'warning'})
                }
            },
        },

        mounted() {
            this.modalUser = new window.bootstrap.Modal(document.getElementById('modalUser'), {keyboard: false, backdrop: false});
            this.modalProfile = new window.bootstrap.Modal(document.getElementById('modalProfile'), {keyboard: false, backdrop: false});
            this.modalPassword = new window.bootstrap.Modal(document.getElementById('modalPassword'), {keyboard: false, backdrop: false});
        }
    }
</script>
