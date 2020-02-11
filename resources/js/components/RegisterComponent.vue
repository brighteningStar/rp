<template>
    <div class="card">
        <loading v-if="form.loading"></loading>
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>

            <form action="#" method="post" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
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
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" v-model="form.password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation" v-model="form.password_confirmation">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('password_confirmation')" v-text="form.errors.get('password_confirmation')"></span>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script type="text/babel">
    import {Form} from "../Form";

    export default {

        data() {
            return {
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                }),
            };
        },

        methods: {
            onSubmit() {
                this.form.post('/register')
                .then(data => window.location.href = '/')
                .catch(errors => console.log(errors));
            }
        },

        mounted() {
        }
    }
</script>
