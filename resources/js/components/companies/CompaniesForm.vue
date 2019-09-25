<template>
    <div class="list">
        <h2 v-if="isEdit">Edit {{company.name}}</h2>
        <h2 v-else>Add new company</h2>

        <b-form v-on:submit.prevent="onSubmit">
            <b-form-group id="name" label="Company name:" label-for="name" description="Please input a company name">
                <b-form-input
                    id="name"
                    v-model="company.name"
                    type="text"
                    required
                    placeholder="Enter company name"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="website" label="Webiste:" label-for="website" description="Please enter a valid website">
                <b-form-input
                    id="website"
                    v-model="company.website"
                    type="text"
                    required
                    placeholder="Enter website"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="location" label="Company location:" label-for="location" description="Please enter a location">
                <b-form-input
                    id="location"
                    v-model="company.location"
                    type="text"
                    required
                    placeholder="Enter the location"
                ></b-form-input>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>

    </div>
</template>

<script>
    export default {
        props: {
            company: {
                default: {},
                type: Object
            },
            current_user: {
                default: {},
                type: Object
            }
        },
        data(){
            return {
                isEdit: Object.keys(this.company).length > 0,
                author: null,
            }
        },
        mounted(){
            if(!this.currentUserIsAdmin()){
                window.redirect('/');
            }
        },
        computed:{
        },
        methods: {

            currentUserIsAdmin(){
                return this.current_user.role === 'administrator'
            },

            onSubmit(){
                if(!this.isEdit){
                    this.company.user_id = this.current_user.id;
                }

                if(this.isEdit){
                    axios.patch(route('companies.update', {company: this.company.id} ).url(), this.company )
                        .then((response) => {
                            alertify.success('User updated Successfully.');
                            window.location.reload();
                        })
                        .catch(function (error) {
                            alertify.alert('sorry, we could not update the user this time, please review your data. Error details: ' + error.message);
                        });
                }else{
                    axios.post(route('companies.store'), this.company)
                        .then((response) => {
                            alertify.success('User created Successfully.');
                            window.location.replace(`/companies/${response.data.id}/edit`);
                        })
                        .catch(function (error) {
                            alertify.alert('sorry, we could not create the user this time. please try again');
                        })
                }
            },

        }
    }
</script>
