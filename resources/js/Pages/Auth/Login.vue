<template>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center align-content-center vh-100">
                        <div class="col-lg-5">

                            <div class="card shadow-lg border-0 rounded-15 animate__animated animate__zoomIn">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <inertia-link href="/" class="text-muted no-decoration">
                                            <app-logo class="me-2" /> DEVADMIN
                                        </inertia-link>
                                    </div>

                                    <div v-if="status" class="mb-3 alert alert-success">
                                        {{ status }}
                                    </div>

                                    <form @submit.prevent="submit">

                                        <div class="form-floating mb-3">
                                            <breeze-input id="email" type="email" v-model="form.email" required autofocus placeholder="Username" autocomplete="email" />
                                            <label for="email">Username</label>
                                            <validation :validation="form.errors.email" />
                                        </div>

                                        <div class="form-floating mb-3">
                                            <breeze-input id="password" type="password" v-model="form.password" required placeholder="Password" autocomplete="current-password" />
                                            <label for="password">Password</label>
                                            <validation :validation="form.errors.password" />
                                        </div>

                                        <div class="form-check mb-3">
                                            <breeze-checkbox id="remember_me" v-model:checked="form.remember" />
                                            <label class="form-check-label" for="remember_me">Remember Me</label>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <breeze-button :disabled="form.processing" class="btn-primary btn-sm">
                                                <i class="fas fa-sign-in-alt fa-sm fa-fw"></i>
                                                Log in
                                            </breeze-button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
    import BreezeButton from '@/Components/Button'
    import BreezeGuestLayout from "@/Layouts/Guest"
    import BreezeInput from '@/Components/Input'
    import Validation from '@/Components/Validation'
    import BreezeCheckbox from '@/Components/Checkbox'
    import AppLogo from '@/Components/ApplicationLogo'

    export default {
        layout: BreezeGuestLayout,

        components: {
            BreezeButton,
            BreezeInput,
            Validation,
            BreezeCheckbox,
            AppLogo
        },

        props: {
            canResetPassword: Boolean,
            status: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('login'), {
                    onFinish: () => this.form.reset('password'),
                })
            }
        }
    }
</script>
