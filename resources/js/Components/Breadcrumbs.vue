<template>
    <h1 class="mt-4">{{title}}</h1>
    <ol class="breadcrumb mb-4">
        <slot/>
    </ol>
</template>

<script>
    export default {
        props: ['title']
    }
</script>
