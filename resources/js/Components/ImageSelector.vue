<template>
    <div class="d-inline-flex">
        <div>
            <label class="mb-2">{{label}}</label>
            <div @click="$emit('openModal')" class="image-selector">
                <div v-if="image">
                    <img :src="asset+'/thumbnail/'+image" alt="Image Preview" class="w-100 rounded-15">
                </div>
                <div v-else class="text-center">
                    <i class="fas fa-images fa-5x fa-fw"></i>
                    <br>
                    Open Image Manager
                </div>
            </div>
        </div>
        <div class="ms-2 py-5 text-info">
            <ul>
                <li v-for="(item, key) in imageInfo" :key="key"><small>{{item}}</small></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        emits: ['openModal'],
        props: {
            image: {
                type: String,
                default: ''
            },
            label: {
                type: String,
                default: 'Label'
            },
            imageInfo: Array,
            asset: String,
        },
    }
</script>
