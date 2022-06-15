<script>
import { ref } from "vue";
import axios from "axios";

export default {
    data() {
        const form = ref("");
        const domainsName = ref([]);
        const data = ref();

        const check = async () => {
            let parsed = form.value.split(",").map((el) => el.trim());
            domainsName.value = parsed;
        };

        const whois = async (domain) => {
            // console.log(domain);
            const response = await axios.post("http://127.0.0.1:8000/api/whois", { domain: domain });
            data.value = response.data;
            console.log(data);
        };

        return {
            form,
            check,
            domainsName,
            whois,
            data,
        };
    },
};
</script>

<template>
    <div class="greetings">
        <h1 class="green">Write down domains</h1>
        <textarea
            placeholder="write down domains separating them with colons"
            v-model="form"
            id=""
            cols="50"
            rows="10"
        ></textarea>
    </div>
    <button @click="check" style="margin-bottom: 100px">add</button>

    <div
        style="margin-bottom: 20px; display: flex"
        v-for="(domain, index) in domainsName"
        :key="index"
    >
        <button style="width: 100px" @click="whois(domain)">{{ domain }}</button>
    </div>
    <div v-if="data">
        <p>{{ data.name }}</p>
        <p>{{ data.message }}</p>
    </div>
</template>
<style>
textarea {
    resize: none;
}
</style>
