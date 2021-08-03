<template>
    <small v-show="validation" class="text-danger">{{validation}}</small>
</template>

<script>
    export default {
        props: ['validation'],
    }
</script>
