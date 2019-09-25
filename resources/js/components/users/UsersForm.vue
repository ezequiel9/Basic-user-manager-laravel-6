<template>
    <div class="list">
        <h2 v-if="isEdit">Edit {{user.name}}</h2>
        <h2 v-else>Add new User</h2>

        <b-form v-on:submit.prevent="onSubmit">
            <b-form-group id="username" label="User name:" label-for="username" description="Please input a name">
                <b-form-input
                    id="username"
                    v-model="user.name"
                    type="text"
                    required
                    placeholder="Enter user name"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="email" label="Email Address:" label-for="email" description="Please enter a valid email">
                <b-form-input
                    id="email"
                    v-model="user.email"
                    type="email"
                    required
                    placeholder="Enter email"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="role" label="Role:" label-for="role">
                <b-form-select
                    id="role"
                    v-model="user.role"
                    :options="roles"
                    required
                ></b-form-select>
            </b-form-group>

            <b-form-group id="password" label="Password:" label-for="password">
                <b-form-input
                    id="password"
                    v-model="password"
                    type="password"
                    :placeholder="isEdit ? 'Reset password' : 'Enter password'"
                ></b-form-input>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>

    </div>
</template>

<script>
    export default {
        props: {
            user: {
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
                isEdit: Object.keys(this.user).length > 0,
                password: null,
            }
        },
        mounted(){
            if(!this.currentUserIsAdmin() && this.editUserIsAdmin()){
                window.redirect(route('users.index'));
            }
        },
        computed:{
            roles(){
                if(this.currentUserIsAdmin()){
                    return [{ text: 'Select One', value: null }, 'employee', 'administrator']
                }else{
                    return [{ text: 'Select One', value: null }, 'employee']
                }
            },
        },
        methods: {
            loadUsers(page){
                axios.get(route('users.index'), {params: { page : page } } )
                    .then((response) => {
                        console.log(response.data);
                        this.users = [...this.users, ...response.data.data];
                        if(response.data.last_page <= this.page){
                            this.page = false;
                        }else{
                            this.page++;
                        }
                    })
                    .catch(err => (console.log(err)));
            },

            currentUserIsAdmin(){
                return this.current_user.role === 'administrator'
            },

            editUserIsAdmin(){
                return (this.user && this.user.role === 'administrator')
            },

            onSubmit(){
                if(!this.isEdit && !this.password){
                    alertify.alert('Please choose a password');
                    return;
                }

                if(this.password){
                    this.user.password = this.password;
                }

                if(this.isEdit){
                    axios.patch(route('users.update', {user: this.user.id} ).url(), this.user )
                        .then((response) => {
                            alertify.success('User updated Successfully.');
                            window.location.reload();
                        })
                        .catch(function (error) {
                            alertify.alert('sorry, we could not update the user this time, please review your data. Error details: ' + error.message);
                        });
                }else{
                    axios.post(route('users.store'), this.user)
                        .then((response) => {
                            alertify.success('User created Successfully.');
                            window.location.replace(`/users/${response.data.id}/edit`);
                        })
                        .catch(function (error) {
                            alertify.alert('sorry, we could not create the user this time. please try again');
                        })
                }
            },

        }
    }
</script>
