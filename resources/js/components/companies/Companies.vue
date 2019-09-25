<template>
    <div class="list">
        <h2>Companies <a href="/companies/create" class="btn btn-success" >Add new</a></h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Website</th>
                <th scope="col">Location</th>
                <th scope="col">Author</th>
                <th scope="col">Created at</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(company, index) in companies">
                <th scope="row">{{company.id}}</th>
                <td>{{company.name}}</td>
                <td>{{company.website}}</td>
                <td>{{company.location}}</td>
                <td>{{company.author.name}}</td>
                <td>{{company.created_at}}</td>
                <td>
                    <div>
                        <a :href="`/companies/${company.id}/edit`" class="btn btn-primary" v-if="canEditOrDelete(company)">Edit</a>
                        <button class="btn btn-danger" v-if="canEditOrDelete(company)" @click="deleteCompany(company, index)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <button v-if="page" class="btn btn-dark" @click="loadCompanies(page)">Load more</button>
    </div>
</template>

<script>
    export default {
        props: {
            current_user: {
                default: {},
                type: Object
            }
        },
        data(){
            return {
                companies: [],
                page: 1,
            }
        },
        mounted() {
            this.loadCompanies(this.page);
        },
        methods: {
            loadCompanies(page){
                axios.get(route('companies.index'), {params: { page : page } } )
                    .then((response) => {
                        console.log(response.data);
                        this.companies = [...this.companies, ...response.data.data];
                        if(response.data.last_page <= this.page){
                            this.page = false;
                        }else{
                            this.page++;
                        }
                    })
                    .catch(err => (console.log(err)));
            },

            canEditOrDelete(company){
                if(this.current_user.role === 'administrator'){
                    return true;
                }
                return false
            },


            deleteCompany(company, index){
                var self = this;
                alertify.confirm("Do you want to delete this company?",
                    function(){
                        axios.delete(route('companies.destroy', {company: company.id} ).url())
                            .then((response) => {
                                console.log(response)
                                alertify.success('Company deleted Successfully.');
                                self.companies.splice(index, 1);
                                //window.location.reload();
                            })
                            .catch((error) => {
                                console.log('error', error)
                                alertify.alert('sorry, we could not delete the company. please try again');
                            })
                    }
                );
            },
        }
    }
</script>
