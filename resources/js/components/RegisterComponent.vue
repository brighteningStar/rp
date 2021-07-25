<template>
    <div class="col-md-4">
        <div class="card dt-pull-up">
            <loading v-if="isLoading"></loading>
            <div class="card-body">
                <h5 class="card-title dati-account-title text-center">Sign up to RP</h5>
                <p class="card-title text-center f14" style="width: 70%;margin: 0 auto;">and spending more time on your projects and lets <strong>RP</strong> managing your infrastructure</p>
                <form action="#" method="POST" class="text-center mt-30 login-form"  @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
                    <div class="alert alert-success dt-success-msg d-none f12"></div>
                    <div class="alert alert-danger dt-error-msg d-none f12"></div>
                    <div class="row form-field">
                        <div class="col-md-12">

                            <input type="text" class="form-control mt-2 f14" placeholder="Full Name" name="name" v-model="form.name"/>
                            <span class="error invalid-field" v-if="this.form.errors.has('name')" v-text="form.errors.get('name')"></span>

                            <input type="text" class="form-control mt-2 f14" v-model="form.email" placeholder="Email address" name="email" />
                            <span class="error invalid-field" v-if="this.form.errors.has('email')" v-text="form.errors.get('email')"></span>

                            <select type="role" class="form-control input-select" placeholder="Role" name="role_id" v-model="form.role_id">
                                <option value="">Select Role</option>
                                <option v-for="(role, index) in allRoles" :key="index" :value="role.id">{{role.label}}</option>
                            </select>
                            <span class="error invalid-field" v-if="this.form.errors.has('role_id')" v-text="form.errors.get('role_id')"></span>

                            <input type="text" class="form-control mt-2 f14" v-model="form.cnic" placeholder="CNIC 1234512345671" name="cnic" />
                            <span class="error invalid-field" v-if="this.form.errors.has('cnic')" v-text="form.errors.get('cnic')"></span>


                            <input type="text" class="form-control mt-2 f14" v-model="form.mobile_no" placeholder="923XX XXXXXXX" name="mobile_no" />
                            <span class="error invalid-field" v-if="this.form.errors.has('mobile_no')" v-text="form.errors.get('mobile_no')"></span>

                            <input type="password" class="form-control mt-2 f14" placeholder="Password" name="password" v-model="form.password"/>
                            <span class="error invalid-field" v-if="this.form.errors.has('password')" v-text="form.errors.get('password')"></span>

                            <input type="password" class="form-control mt-2 f14" placeholder="Confirm password" name="password" v-model="form.password_confirmation"/>
                            <span class="error invalid-field" v-if="this.form.errors.has('password_confirmation')" v-text="form.errors.get('password_confirmation')"></span>
                        </div>
                    </div>
                    <div class="row mt-20">
                        <div class="col-md-12 text-left">
                            <button class="btn btn-primary login-btn ">Sign up</button>
                        </div>
                    </div>
                </form>

                <div class="row login-form mt-30">
                    <div class="col-md-12 p-md-0 text-center">
                        <span class="forgot-pass-text">By signing up you agree to</span><br><a href="#" class="forgot-pass-text dt-underline">Terms of services</a> <span class="forgot-pass-text"> and </span> <a href="#" class="forgot-pass-text dt-underline">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-20 login-signup-text">
            <div class="col-md-12 text-center">
                <span class="login-signup-text">Already have an account? <a href="/login">Sign in</a></span>
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
            loading: false,
            service: new Role(),
            form: new Form({
                name: '',
                email: '',
                role_id: '',
                cnic: '',
                mobile_no: '',
                password: '',
                password_confirmation: '',
            }),
            allRoles: {},
        };
    },

    computed: {
        isLoading() {
            return !!(this.form.loading || this.loading)
        }
    },

    methods: {
        async onSubmit() {
            try {
                const registered = await this.form.post('/register')
                window.location.href = '/dashboard' // redirect to dashboard
            } catch (errors) {
                console.error(this.form.errors.has('email'))
            }
        },

        async fetchRoles() {
            try {
                this.allRoles = await this.service.getRoles()
            } catch(error) {
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
.no-border {
    border-right: 1px solid #ccc !important;
}
</style>
