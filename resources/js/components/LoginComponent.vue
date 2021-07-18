<template>
    <div class="card">
        <loading v-if="form.loading"></loading>
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
                <div class="row mb-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" :disabled="disableForm">Sign In</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span>Don't have an account? Please <a href="/register">Register here</a></span>
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
                    email: '',
                    password: '',
                }),
            };
        },

        computed: {
            disableForm() {
                return !!(this.form.errors.any())
            }
        },

        methods: {
            async onSubmit() {
                await this.form.post('/login')
            }
        }
    }
</script>
