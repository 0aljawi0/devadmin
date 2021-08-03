<template>
    <span>
        <span v-if="processing">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            process...
        </span>
        <span v-else><i class="fas fa-save fa-lg fa-fw"></i> {{label}}</span>
    </span>
</template>

<script>
    export default {
        props: ['processing', 'label']
    }
</script>
