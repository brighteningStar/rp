<template>
    <div class="col-md-4">
        <div class="card dt-pull-up">
            <loading v-if="isLoading"></loading>
            <div class="card-body">
                <h5 class="card-title dati-account-title text-center">Sign in to your account</h5>
                <form action="/login" method="POST" class="text-center mt-30 login-form">
                    <div class="alert alert-success dt-success-msg d-none f12"></div>
                    <div class="alert alert-danger dt-error-msg d-none f12"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="email" class="login-email">Email address &#42;</label>
                            <input type="text" class="form-control f14" placeholder="" name="email"/>
                            <select name="" id="" class="form-control input-select">
                                <option value="">Super Admin</option>
                            </select>
                            <input type="password" class="form-control mt-2 f14" placeholder="Password" name="password"/>
                        </div>
                    </div>
                    <div class="row mt-20">
                        <div class="col-md-12 text-left">
                            <button class="btn btn-primary login-btn" type="submit">Sign in</button>
                        </div>
                    </div>
                </form>

                <div class="row login-form mt-30">
                    <div class="col-md-12 p-md-0 text-center">
                        <a href="#" class="forgot-pass-text">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-20 login-signup-text">
            <div class="col-md-12 text-center">
                <span class="login-signup-text">Don't have an account? <a href="/register">Sign up</a></span>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {Form} from "../Form";

    export default {

        data() {
            return {
                service: new Role(),
                form: new Form({
                    email: '',
                    password: '',
                }),
                allRoles: []
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
            },

            async fetchRoles() {
                try {
                    this.allRoles = await this.service.getRoles()
                } catch(errors) {
                    console.error('cannot load roles')
                }
                
            }
        },

        created() {
            this.fetchRoles()
        }
    }
</script>
<style lang="scss" scoped>
.input-select {
    margin-top: 10px;
}
</style>
