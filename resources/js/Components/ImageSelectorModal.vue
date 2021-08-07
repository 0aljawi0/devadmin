<template>
    <modal id="modal" :big="true">
        <!-- Form -->
        <form @submit.prevent="submit">
            <div class="mb-3">
                <input type="file" accept="image/*" class="form-control" ref="fileUpload" @input="image = $event.target.files[0]">
                <ul class="mt-2" v-show="validation.length > 0">
                    <li v-for="(item, key) in validation" :key="key" class="text-danger"><small>{{item}}</small></li>
                </ul>
                <div v-if="progress" class="progress mt-2">
                    <div class="progress-bar bg-success" role="progressbar" :style="{width: percentage+'%'}" :aria-valuenow="percentage" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-sm btn-primary" :disabled="progress">
                    <span v-if="progress">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        process...
                    </span>
                    <span v-else><i class="fas fa-upload fa-sm fa-fw"></i> Upload</span>
                </button>
                <button type="button" @click="closeModal" class="btn btn-sm btn-warning"><i class="fas fa-times-circle fa-sm fa-fw"></i> Close</button>
            </div>
        </form>

        <!-- List -->
        <div v-if="data.length > 0" class="row row-cols-1 row-cols-md-4 g-4 mt-2">
            <div v-for="item in data" :key="item.id" class="col">
                <div class="card h-100 rounded-15 shadow-sm">
                    <img :src="asset+'/thumbnail/'+item.image" class="card-img-top rounded-15-top" :alt="item.title">

                    <div class="card-body bg-admin p-0 rounded-15-bottom">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item py-0 bg-admin"><small>{{item.title}}</small></li>
                            <li class="list-group-item py-0 bg-admin"><small>{{item.type}}, {{item.size}}</small></li>
                            <li class="list-group-item py-0 bg-admin rounded-15-bottom"><small>{{item.pixel}}</small></li>
                        </ul>
                    </div>

                    <div class="card-footer rounded-15-bottom p-0">
                        <button @click="$emit('setImage', {image: item.image, input: input})" type="button" class="btn-choose btn-primary rounded-15-bottom">Choose</button>
                    </div>
                </div>
            </div>
        </div>

        <h3 v-else><i class="fas fa-tired fa-sm fa-fw mt-3"></i> No image, Let's upload it</h3>

        <nav class="mt-3" aria-label="Page navigation" v-if="pagination.length > 3">
            <ul class="pagination">
                <li class="page-item" v-for="(link, key) in pagination" :key="key" v-bind:class="isActive(link)">
                    <a class="page-link" href="#" v-if="link.url" @click.prevent="getImages(link.url)">{{ link.label }}</a>
                    <a class="page-link" href="#" v-else @click.prevent="handleNoLink">{{ link.label }}</a>
                </li>
            </ul>
        </nav>
    </modal>
</template>

<script>
    import Modal from '@/Components/Modal'
    import { createToast } from 'mosha-vue-toastify'


    export default {
        components: {
            Modal,
        },

        props: {
            asset: String
        },

        data() {
            return {
                modal: null,
                input: '',
                data: [],
                pagination: [],
                image: null,
                validation: [],
                progress: false,
                percentage: 0,
            }
        },

        watch() {

        },

        methods: {
            openModal(input) {
                this.input = input;
                this.modal.show();
            },

            closeModal() {
                this.$refs.fileUpload.value=null;
                this.image = null;
                this.validation = [];
                this.modal.hide();
            },

            isActive(link) {
                return (link.active === true) ? 'active' : 'normal'
            },

            handleNoLink() {
                return false
            },

            getImages(url = this.route('all-images')) {
                window.axios.get(url).then(res => {
                    this.data = res.data.data;
                    this.pagination = res.data.links;
                })
            },

            submit() {
                this.progress = true;
                this.validation = [];

                let formData = new FormData();
                formData.append('image', this.image);

                window.axios.post(route('upload-image'), formData, {
                    onUploadProgress: progressEvent => {
                        this.percentage = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                    },
                })
                .then(res => {
                    createToast(res.data.message, {type: 'success'});
                    this.$refs.fileUpload.value=null;
                    this.image = null;
                    this.progress = false;
                    this.getImages();
                })
                .catch(err => {
                    console.log(err);
                    this.validation = err.response.data.data.image;
                    this.progress = false;
                });
            }
        },

        mounted() {
            this.getImages();
            this.modal = new window.bootstrap.Modal(document.getElementById('modal'), {keyboard: false, backdrop: false});
        }
    }
</script>
