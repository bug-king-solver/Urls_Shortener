<template>
    <div class="w-full max-w-md mx-auto">
        <h2 class="text-2xl font-bold mb-4">URL Shortener</h2>
        <form @submit.prevent="submitUrl" class="space-y-4">
            <div class="form-group">
                <label for="url" class="block">Enter URL:</label>
                <input 
                    type="text" 
                    id="url" 
                    v-model="url" 
                    placeholder="https://php.test.com" 
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-400 text-black" 
                />
                <p v-if="!isUrlValid" class="text-red-500">Please enter a valid URL.</p>
            </div>
            <div class="form-group">
                <label for="subdir" class="block">Enter SubDirectory (Optional):</label>
                <input 
                    type="text" 
                    id="subdir" 
                    v-model="subdir"
                    placeholder="something" 
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-400 text-black" 
                />
            </div>
            <button type="submit" :disabled="!isFormValid" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Shorten
            </button>
        </form>
    </div>
</template>

<script setup lang="ts">
    import { ref, computed } from 'vue';
    import saveUrl  from '@/composables/ShortenUrl.ts';

    const shortened_prefix = import.meta.env.VITE_API_SHORTENED_PREFIX;

    const redirectUrl = defineModel('redirectUrl');
    const url = ref('');
    const subdir = ref('');

    const isUrlValid = ref(true);

    const submitUrl = async () => {
        if (!isFormValid) return;
        let data = await saveUrl(url.value, subdir.value);
        redirectUrl.value = data.sub ? `${shortened_prefix}${data.sub}/${data.hash}` : `${shortened_prefix}${data.hash}`
    }
    const checkUrlValidity = () => {
        isUrlValid.value = /^https?:\/\//.test(url.value) || /^http?:\/\//.test(url.value);
    }

    const isFormValid = computed(() => {
        checkUrlValidity();
        return isUrlValid.value;
    });
</script>
