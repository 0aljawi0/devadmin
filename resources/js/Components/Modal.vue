<template>
    <div class="modal fade" :id="id" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" :class="big ? 'modal-lg' : ''">
            <div class="modal-content shadow-lg rounded-15">
                <div class="modal-body">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: String,
            big: {
                type: Boolean,
                default: false,
            }
        }
    }
</script>
