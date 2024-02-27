<template>
    <div class="mt-8 w-full max-w-md mx-auto" v-if="props.redirectUrl">
        <p>Click below link to redirect to yours.</p>
        <a class="pt-4" :href="props.redirectUrl">
            {{ props.redirectUrl }}
        </a>
    </div>
</template>

<script setup lang="ts">

    const props = defineProps({
        redirectUrl: String,
    });

</script>