<script setup>
import { ref, reactive, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

const url = ref("");
const shortUrl = ref("");
const errors = reactive({});

const page = usePage();

onMounted(() => {
    if (page.props.short_url) {
        shortUrl.value = page.props.short_url;
    }
});

const submit = () => {
    const form = useForm({ url: url.value });
    form.post("/shorten", {
        onSuccess: (page) => {
            if (page.props.short_url) {
                shortUrl.value = page.props.short_url;
            }
            errors.url = "";
        },
        onError: (formErrors) => {
            errors.url = formErrors.url;
        },
    });
};
</script>

<template>
    <div>
        <form @submit.prevent="submit">
            <input v-model="url" type="url" placeholder="Enter URL" required />
            <button type="submit">Shorten</button>
        </form>
        <p v-if="shortUrl">
            Short URL: <a :href="shortUrl" target="_blank">{{ shortUrl }}</a>
        </p>
        <div v-if="errors.url" class="error">{{ errors.url }}</div>
    </div>
</template>

<style scoped>
.error {
    color: red;
}
</style>
