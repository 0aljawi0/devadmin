<template>
    <authenticated-layout>
        <div v-if="roles.manages[0].pivot.read == 1" class="container-fluid px-4">
            <breadcrumbs title="Images">
                <li class="breadcrumb-item"><i class="fas fa-cog fa-lg fa-fw"></i></li>
                <li class="breadcrumb-item active">Images</li>
            </breadcrumbs>

            <div class="row">
                <div class="col">
                    <card>
                        <template #header>
                            <div class="btn-group">
                                Image Manager
                            </div>
                        </template>

                        <div v-show="roles.manages[0].pivot.add == 1" class="row mt-3">
                            <div class="col">
                                <upload-image :max="5" @changed="uploadImages" :process="progress" :percentage="percentage" ref="uploadImage"/>
                            </div>
                        </div>

                        <div v-if="images.data.length > 0" class="row mt-3">
                            <div v-for="item in images.data" :key="item.id" class="col-md-2 p-2">
                                <div class="card rounded-15 shadow-sm">
                                    <img :src="asset+'/thumbnail/'+item.image" class="card-img-top rounded-15-top" :alt="item.title">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item py-0 bg-admin"><small>{{item.title}}</small></li>
                                        <li class="list-group-item py-0 bg-admin"><small>{{item.type}}, {{item.size}}</small></li>
                                        <li class="list-group-item py-0 bg-admin"><small>{{item.pixel}}</small></li>
                                    </ul>
                                    <div class="card-body bg-admin text-center rounded-15-bottom p-0 py-1">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-search-plus fa-lg fa-fw"></i></button>
                                            <button v-show="roles.manages[0].pivot.delete == 1" @click="destroy(item.id)" type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash fa-lg fa-fw"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 v-else><i class="fas fa-tired fa-sm fa-fw mt-3"></i> No image, Let's upload it</h3>

                        <pagination v-if="images.data.length > 0" :links="images.links" />
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
    import Modal from '@/Components/Modal'
    import BreezeInput from '@/Components/Input'
    import BreezeButton from '@/Components/Button'
    import ButtonLabel from '@/Components/ButtonLabel'
    import Validation from '@/Components/Validation'
    import Pagination from '@/Components/Pagination'
    import UploadImage from '@/Components/UploadImage'
    import { createToast } from 'mosha-vue-toastify'

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
            UploadImage,
        },

        props: ['images', 'roles', 'asset'],

        data() {
            return {
                progress: false,
                percentage: 0,
            }
        },

        methods: {
            uploadImages(files) {
                let data = new FormData();
                for (let i = 0; i < files.length; i++) {
                    data.append('image[]', files[i]);
                }

                this.$inertia.post(route('images.store'), data, {
                    preserveScroll: true,
                    onProgress: progress => {
                        this.progress = true,
                        this.percentage = progress.percentage;
                    },
                    onSuccess: page => {
                        this.progress = false;
                        this.percentage = 0;
                        this.$refs.uploadImage.reset();
                        createToast(this.$page.props.flash.message, {type: 'success'});
                    }
                })
            },

            destroy(id) {
                this.$inertia.delete(route('images.destroy', {image: id}), {
                    preserveScroll: true,
                    onSuccess: page => {
                        createToast(this.$page.props.flash.message, {type: 'success'});
                    }
                })
            }
        }
    }
</script>
