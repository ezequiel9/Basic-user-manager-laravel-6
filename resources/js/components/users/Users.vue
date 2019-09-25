<template>
    <div class="list">
        <h2>Users <a href="/users/create" class="btn btn-success" >Add new</a></h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Created at</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(user, index) in users">
                <th scope="row">{{user.id}}</th>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.role}}</td>
                <td>{{user.created_at}}</td>
                <td>
                    <div>
                        <a :href="`/users/${user.id}/edit`" class="btn btn-primary" v-if="canEditOrDelete(user)">Edit</a>
                        <button class="btn btn-danger" v-if="canEditOrDelete(user)" @click="deleteUser(user, index)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <button v-if="page" class="btn btn-dark" @click="loadUsers(page)">Load more</button>
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
                users: [],
                page: 1,
            }
        },
        mounted() {
            this.loadUsers(this.page);
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

            canEditOrDelete(user){
                if(user.role === 'administrator'){
                    if(this.current_user.role === 'administrator'){
                        return true;
                    }
                    return false;
                }
                return true
            },


            deleteUser(user, index){
                var self = this;
                alertify.confirm("Do you want to delete this user?",
                    function(){
                        axios.delete(route('users.destroy', {user: user.id} ).url())
                            .then((response) => {
                                console.log(response)
                                alertify.success('User deleted Successfully.');
                                self.users.splice(index, 1);
                                //window.location.reload();
                            })
                            .catch((error) => {
                                console.log('error', error)
                                alertify.alert('sorry, we could not delete the user. please try again');
                            })
                    }
                );
            },
        }
    }
</script>
