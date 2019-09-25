<template>
    <div class="search-template">
        <input class="input-search" type="text" @input="search" v-model="search_string">
        <div class="results" v-if="search_results.companies.length > 0 || search_results.users.length > 0">
            <template v-if="search_results.companies.length > 0">
                <h6>Companies</h6>
                <ul>
                    <li v-for="company in search_results.companies">
                        <a :href="`/companies/${company.id}/edit`">{{company.name}}</a>
                    </li>
                </ul>
            </template>
            <template v-if="search_results.users.length > 0">
                <h6>Users</h6>
                <ul>
                    <li v-for="user in search_results.users">
                        <a :href="`/users/${user.id}/edit`">{{user.name}}</a>
                    </li>
                </ul>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        name: "search",
        data(){
            return {
                search_string: '',
                search_results: {
                    companies: [],
                    users: [],
                },
            }
        },
        methods: {
            search(){
                axios.post(route('search'), {search: this.search_string})
                    .then((response) => {
                        this.search_results.companies = response.data.companies;
                        this.search_results.users = response.data.users;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
