<template>
    <loading v-if="form.loading"></loading>
    <section v-else="" class="content">
        <div class="container-fluid">
            <form action="#" method="post" @submit.prevent="onSubmit">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Full name" name="name" v-model="form.name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                </div>

                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" v-model="form.email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
            </form>
        </div>
    </section>
</template>

<script>
    import {Form} from "../Form"
    export default {
        props: ['id'],
        data() {
            return {
                form: new Form({
                    name: '',
                    email: '',
                    loading:true,
                }),
            };
        },
        methods: {
            onSubmit() {
                this.form.post('/update-profile/'+this.id)
                    .then(function (response) {
                        this.form.name = response.name;
                        this.form.email = response.email;
                    }.bind(this))
                    .catch(errors => console.log(errors));
            },

            getUserData(){
                this.form.loading = true;
                axios.get('/users/'+this.id)
                    .then(function (response) {
                        this.form.loading = false;
                        this.form.name = response.data.name;
                        this.form.email = response.data.email;
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                    })
            },

        },
        mounted() {
            this.getUserData();
        },

    }
</script>