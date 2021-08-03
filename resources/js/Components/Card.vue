<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">
                <slot name="header" />
            </h5>

            <slot/>
        </div>
    </div>
</template>
