<template>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="#" method="post" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" v-model="form.email" name="email">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" v-model="form.password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" :disabled="form.errors.any()">Sign In
                            <loading v-if="form.loading"></loading>
                        </button>

                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</template>

<script type="text/babel">
    import {Form} from "../Form";

    export default {

        data() {
            return {
                form: new Form({
                    email: '',
                    password: '',
                }),
            };
        },

        methods: {
            onSubmit() {
                this.form.post('/login')
                    .then(data => window.location.href = '/')
                    .catch(errors => console.log(errors));
            }
        },

        mounted() {
        }
    }
</script>
