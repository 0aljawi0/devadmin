<template>
    <authenticated-layout>
        <div v-if="roles.manages[0].pivot.read == 1" class="container-fluid px-4">
            <breadcrumbs title="Logo">
                <li class="breadcrumb-item"><i class="fas fa-cog fa-lg fa-fw"></i></li>
                <li class="breadcrumb-item active">Logo</li>
            </breadcrumbs>

            <div class="row">
                <div class="col-md-6">
                    <card>
                        <template #header>
                            <div class="btn-group">
                                Logo Setting
                            </div>
                        </template>

                        <form @submit.prevent="submit">

                            <input type="hidden" v-model="form.id">

                            <div class="mb-3 me-3">
                                <image-selector :asset="asset" label="Favicon" :image="form.favicon" :imageInfo="imageInfo.favicon" @openModal="$refs.selectorModal.openModal('favicon')"/>
                                <input type="hidden" v-model="form.favicon">
                                <br>
                                <validation :validation="form.errors.favicon" />
                            </div>

                            <div class="mb-3 me-3">
                                <image-selector :asset="asset" label="Logo Dark" :image="form.logo_dark" :imageInfo="imageInfo.logo_dark" @openModal="$refs.selectorModal.openModal('logo_dark')"/>
                                <input type="hidden" v-model="form.logo_dark">
                                <br>
                                <validation :validation="form.errors.logo_dark" />
                            </div>

                            <div class="mb-3">
                                <image-selector :asset="asset" label="Logo Light" :image="form.logo_light" :imageInfo="imageInfo.logo_light" @openModal="$refs.selectorModal.openModal('logo_light')"/>
                                <input type="hidden" v-model="form.logo_light">
                                <br>
                                <validation :validation="form.errors.logo_light" />
                            </div>

                            <breeze-button class="btn-primary" :disabled="form.processing">
                                <button-label :processing="form.processing" label="Save"/>
                            </breeze-button>
                        </form>
                    </card>
                </div>
            </div>

        </div>

        <div v-else class="container-fluid px-4">
            <breadcrumbs title="Warning!">
                <li for="breadcrumb-item"><h3><i class="fas fa-lock fa-sm fa-fw"></i> You are not authorized to open this page</h3></li>
            </breadcrumbs>
        </div>

        <image-selector-modal :asset="asset" ref="selectorModal" @setImage="handleSetImage"/>
    </authenticated-layout>
</template>

<script>
    import AuthenticatedLayout from '@/Layouts/Authenticated'
    import Breadcrumbs from '@/Components/Breadcrumbs'
    import Card from '@/Components/Card'
    import BreezeButton from '@/Components/Button'
    import ButtonLabel from '@/Components/ButtonLabel'
    import Validation from '@/Components/Validation'
    import ImageSelector from '@/Components/ImageSelector'
    import ImageSelectorModal from '@/Components/ImageSelectorModal'
    import { createToast } from 'mosha-vue-toastify'

    export default {
        components: {
            AuthenticatedLayout,
            Breadcrumbs,
            Card,
            BreezeButton,
            ButtonLabel,
            Validation,
            ImageSelector,
            ImageSelectorModal
        },

        props: ['logo', 'roles', 'asset'],

        data() {
            return {
                form: this.$inertia.form({
                    id: this.logo.id ?? 0,
                    favicon: this.logo.value.favicon ?? '',
                    logo_dark: this.logo.value.logo_dark ?? '',
                    logo_light: this.logo.value.logo_light ?? ''
                }),
                imageInfo: {
                    favicon: [
                        'Website Icon',
                        'Image optimal pixel 128 x 128',
                        'Image extension PNG',
                    ],
                    logo_dark: [
                        'Logo for light background',
                        'Image optimal pixel XXX x XXX',
                        'Image extension PNG',
                    ],
                    logo_light: [
                        'Logo for dark background',
                        'Image optimal pixel XXX x XXX',
                        'Image extension PNG',
                    ],
                }
            }
        },

        methods: {
            handleSetImage(event) {
                this.form[event.input] = event.image;
                this.$refs.selectorModal.closeModal()
            },

            submit() {
                let url = this.form.id == 0 ? route('logo.update') : route('logo.update', {id: this.form.id});
                this.form.post(url,{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.form.clearErrors();
                        createToast(this.$page.props.flash.message, {type: 'success'});
                    }
                })
            }
        },
    }
</script>
