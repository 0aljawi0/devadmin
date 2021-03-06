<template>
    <div
        class="container-fluid"
        @dragover.prevent="dragOver"
        @dragleave.prevent="dragLeave"
        @drop.prevent="drop($event)"
    >

        <div v-show="process" class="backdrop">
            <div class="container h-100">
                <div class="row h-100 justify-content-center align-content-center">
                    <div class="col text-light text-center">
                        <h3>Uploading...</h3>
                        <h4>{{percentage}}%</h4>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" :style="{width: percentage+'%'}" :aria-valuenow="percentage" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="drop" v-show="dropped == 2"></div>

        <!-- Error Message -->
        <div v-show="error" class="error">
            {{ error }}
        </div>

        <!-- To inform user how to upload image -->
        <div v-show="Imgs.length == 0" class="beforeUpload">
            <input
                type="file"
                style="z-index: 1"
                accept="image/*"
                ref="uploadInput"
                @change="previewImgs"
                multiple
            />

            <image-upload-logo />

            <p class="mainMessage">
                {{ uploadMsg ? uploadMsg : "Click to upload or drop your images here" }}
            </p>
        </div>

        <div class="imgsPreview" v-show="Imgs.length > 0">
            <button type="button" class="clearButton" @click="reset">
                {{ clearAll ? clearAll : "clear All" }}
            </button>

            <div class="imageHolder" v-for="(img, i) in Imgs" :key="i">
                <img :src="img" />
                <span class="delete" style="color: white" @click="deleteImg(--i)">
                    <image-upload-icon-trash />
                </span>
                <div class="plus ms-2" @click="append" v-if="++i == Imgs.length">+</div>
            </div>
        </div>
    </div>
</template>

<script>
    import ImageUploadLogo from '@/Components/ImageUploadLogo'
    import ImageUploadIconTrash from '@/Components/ImageUploadIconTrash'

    export default {
        name: "VueUploadImages",

        components: {
            ImageUploadLogo,
            ImageUploadIconTrash,
        },

        data() {
            return {
                error: "",
                files: [],
                dropped: 0,
                Imgs: [],
            };
        },

        props: {
            max: Number,
            uploadMsg: String,
            maxError: String,
            fileError: String,
            clearAll: String,
            process: {
                type: Boolean,
                default: true,
            },
            percentage: {
                type: Number,
                default: 0,
            }
        },

        methods: {
            dragOver() {
                this.dropped = 2;
            },

            dragLeave() {},

            drop(e) {
                let status = true;
                let files = Array.from(e.dataTransfer.files)
                if (e && files) {
                    files.forEach((file) => {
                        if (file.type.startsWith("image") === false) status = false;
                    });

                    if (status == true) {
                        if (
                            this.$props.max &&
                            files.length + this.files.length > this.$props.max
                        ) {
                            this.error = this.$props.maxError
                            ? this.$props.maxError
                            : `Maximum files is ` + this.$props.max;
                        } else {
                            this.files.push(...files);
                            this.previewImgs();
                        }
                    } else {
                        this.error = this.$props.fileError
                            ? this.$props.fileError
                            : `Unsupported file type`;
                    }
                }
                this.dropped = 0;
            },

            append() {
                this.$refs.uploadInput.click();
            },

            readAsDataURL(file) {
                return new Promise(function (resolve, reject) {
                    let fr = new FileReader();
                    fr.onload = function () {
                        resolve(fr.result);
                    };
                    fr.onerror = function () {
                        reject(fr);
                    };
                    fr.readAsDataURL(file);
                });
            },

            deleteImg(index) {
                this.Imgs.splice(index, 1);
                this.files.splice(index, 1);
                this.$emit("changed", this.files);
                this.$refs.uploadInput.value = null;
            },

            previewImgs(event) {
                if (
                    this.$props.max &&
                    event &&
                    event.currentTarget.files.length + this.files.length > this.$props.max
                ) {
                    this.error = this.$props.maxError
                    ? this.$props.maxError
                    : `Maximum files is ` + this.$props.max;
                    return;
                }

                if (this.dropped == 0) this.files.push(...event.currentTarget.files);

                this.error = "";
                this.$emit("changed", this.files);
                let readers = [];

                if (!this.files.length) return;

                for (let i = 0; i < this.files.length; i++) {
                    readers.push(this.readAsDataURL(this.files[i]));
                }

                Promise.all(readers).then((values) => {
                    this.Imgs = values;
                });
            },

            reset() {
                this.$refs.uploadInput.value = null;
                this.Imgs = [];
                this.files = [];
                // this.$emit("changed", this.files);
            },
        },
    };
</script>

<style scoped>
    .container-fluid {
        background: #f7fafc;
        border: 0.5px solid #a3a8b1;
        border-radius: 15px;
        padding: 30px;
        position: relative;
    }

    .backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        border-radius: 15px;
        z-index: 1000;
    }

    .drop {
        width: 100%;
        height: 100%;
        top: 0;
        border-radius: 10px;
        position: absolute;
        background-color: #f4f6ff;
        left: 0;
        border: 3px dashed #a3a8b1;
    }

    .error {
        text-align: center;
        color: red;
        font-size: 15px;
    }

    .beforeUpload {
        position: relative;
        text-align: center;
    }

    .beforeUpload input {
        width: 100%;
        margin: auto;
        height: 100%;
        opacity: 0;
        position: absolute;
        background: red;
        display: block;
    }

    .beforeUpload input:hover {
        cursor: pointer;
    }

    .beforeUpload .icon {
        width: 150px;
        margin: auto;
        display: block;
    }

    .imgsPreview .imageHolder {
        width: 150px;
        height: 150px;
        background: #fff;
        position: relative;
        border-radius: 10px;
        margin: 5px 5px;
        display: inline-block;
    }

    .imgsPreview .imageHolder img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .imgsPreview .imageHolder .delete {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 29px;
        height: 29px;
        color: #fff;
        background: red;
        border-radius: 50%;
    }

    .imgsPreview .imageHolder .delete:hover {
        cursor: pointer;
    }

    .imgsPreview .imageHolder .delete .icon {
        width: 66%;
        height: 66%;
        display: block;
        margin: 4px auto;
    }

    .imgsPreview .imageHolder .plus {
        color: #2d3748;
        background: #f7fafc;
        border-radius: 50%;
        font-size: 21pt;
        height: 30px;
        width: 30px;
        text-align: center;
        border: 1px dashed;
        line-height: 23px;
        position: absolute;
        right: -42px;
        bottom: 43%;
    }

    .plus:hover {
        cursor: pointer;
    }

    .clearButton {
        color: #2d3748;
        position: absolute;
        top: 7px;
        right: 7px;
        background: none;
        border: none;
        cursor: pointer;
    }
</style>
