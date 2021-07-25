<template>
    <div class="col-md-4">
        <div class="card dt-pull-up">
            <loading v-if="isLoading"></loading>
            <div class="card-body">
                <h5 class="card-title dati-account-title text-center">Sign in to your account</h5>
                <form action="#" method="POST" class="text-center mt-30 login-form" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
                    <div class="alert alert-success dt-success-msg d-none f12"></div>
                    <div class="alert alert-danger dt-error-msg d-none f12"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control f14" placeholder="Email" name="email" v-model="form.email" />
                            <span class="error invalid-field" v-if="this.form.errors.has('email')" v-text="form.errors.get('email')"></span>

<!--                            <select type="role" class="form-control input-select" placeholder="Role" name="role_id" v-model="form.role_id">-->
<!--                                <option value="">Select Role</option>-->
<!--                                <option v-for="(role, index) in allRoles" :key="index" :value="role.id">{{role.label}}</option>-->
<!--                            </select>-->
                            <span class="error invalid-field" v-if="this.form.errors.has('role_id')" v-text="form.errors.get('role_id')"></span>

                            <input type="password" class="form-control mt-2 f14" placeholder="Password" name="password" v-model="form.password"/>
                            <span class="error invalid-field" v-if="this.form.errors.has('password')" v-text="form.errors.get('password')"></span>
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
    import {Role} from "../services/Role"

    export default {

        data() {
            return {
                service: new Role(),
                form: new Form({
                    email: '',
                    password: '',
                    role_id:''
                }),
                allRoles: []
            };
        },

        computed: {
            disableForm() {
                return !!(this.form.errors.any())
            },

            isLoading() {
                return !!(this.form.loading || this.loading)
            }
        },

        methods: {
            async onSubmit() {
                try {
                    const loggedIn = await this.form.post('/login')
                    window.location = '/dashboard' // redirect to dashboard
                } catch(errors) {
                    console.error('cannot make login')
                }
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
