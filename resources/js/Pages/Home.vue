<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/inertia-vue3';

const url = ref('');
const shortUrl = ref('');
const errors = reactive({});

const page = usePage();

onMounted(() => {
    if (page.props.short_url) {
        shortUrl.value = page.props.short_url;
    }
});

const submit = async () => {
    try {
        const response = await axios.post('/shorten', { url: url.value });
        shortUrl.value = response.data.short_url;
        errors.url = '';
    } catch (error) {
        if (error.response && error.response.data.errors) {
            errors.url = error.response.data.errors.url[0];
        } else {
            console.error(error);
        }
    }
};
</script>

<template>
    <div class="m-4">
        <form @submit.prevent="submit" class="mb-4">
            <input v-model="url" type="url" placeholder="Enter URL" required />
            <button
                class="ml-2 rounded-lg px-4 py-2 border-2 border-blue-500 text-blue-500 hover:bg-blue-600 hover:text-blue-100 duration-300"
                type="submit"
            >
                Shorten
            </button>
        </form>
        <p v-if="shortUrl">
            Short URL:
            <a :href="shortUrl" target="_blank" class="hover:underline">{{
                shortUrl
            }}</a>
        </p>
        <div v-if="errors.url" class="text-red-600">{{ errors.url }}</div>
    </div>
</template>

<style scoped>
.error {
    color: red;
}
</style>

