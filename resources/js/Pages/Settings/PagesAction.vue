<template>
    <authenticated-layout>
        <div class="container-fluid px-4">
            <breadcrumbs title="Pages">
                <li class="breadcrumb-item"><i class="fas fa-cog fa-lg fa-fw"></i></li>
                <li class="breadcrumb-item"><a :href="route('pages.index')">Pages</a></li>
                <li class="breadcrumb-item active">Action</li>
            </breadcrumbs>

            <div class="row">
                <div class="col-xl-10 col-xxl-8">
                    <card>
                        <template #header>
                            <h4>{{page ? 'Change page : '+page.title : 'Make new page' }}</h4>
                        </template>

                        <form @submit.prevent="submit">

                            <div class="mb-3">
                                <label>Title</label>
                                <breeze-input type="text" v-model="form.title"/>
                                <small class="text-info mt-1">{{ form.title.length }} character</small> <br>
                                <validation :validation="form.errors.title" />
                            </div>

                            <div class="mb-3">
                                <ckeditor :editor="editor" v-model="form.content" @ready="onReady"></ckeditor>
                            </div>

                            <div class="btn-group">
                                <a :href="route('pages.index')" class="btn btn-sm btn-warning" :disabled="form.processing">
                                    <i class="fas fa-chevron-left fa-lg fa-fw"></i> Back
                                </a>
                                <breeze-button class="btn-primary" :disabled="form.processing">
                                    <button-label :processing="form.processing" :label="page ? 'Update' : 'Add'"/>
                                </breeze-button>
                            </div>
                        </form>                      
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
    import Modal from '@/Components/Modal'
    import BreezeInput from '@/Components/Input'
    import BreezeButton from '@/Components/Button'
    import ButtonLabel from '@/Components/ButtonLabel'
    import Validation from '@/Components/Validation'
    import { createToast } from 'mosha-vue-toastify'
    import moment from 'moment'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import UploadAdapter from '../../UploadAdapter'

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
            ClassicEditor
        },

        props: ['page', 'asset'],

        data() {
            return {
                editor: ClassicEditor,
                form: this.$inertia.form({
                    title: this.page ? this.page.title : '',
                    content: this.page ? this.page.content : '',
                })
            }
        },

        computed: {
            dateFormat() {
                return date => {moment(date).format('ddd, MMM Do YY hh:mm a')}
            }
        },

        methods: {
            onReady(editor) {
                editor.plugins.get("FileRepository").createUploadAdapter = loader => {
                    return new UploadAdapter(loader, this.route('editor-image'), this.asset);
                };
            },

            submit() {
                if (this.page) {
                    this.form.put(route('pages.update', {page: this.page.id}), {
                        preserveScroll: true,
                        onSuccess: () => {
                            createToast(this.$page.props.flash.message, {type: 'success'});
                        }
                    })
                } else {
                    this.form.post(route('pages.store'), {
                        preserveScroll: true,
                        onSuccess: () => {
                            createToast(this.$page.props.flash.message, {type: 'success'});
                        }
                    })
                }
            }
        },
    }
</script>
