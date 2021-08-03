<template>
    <button :type="type" @click="$emit('click', $event)" class="btn btn-sm">
        <slot />
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        },
    }
</script>
