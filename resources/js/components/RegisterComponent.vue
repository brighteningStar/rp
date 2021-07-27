<template>
    <div class="login-wrapper login-page-wrapper">
        <div class="parent-flex">
            <div class="logo">
                <a href="#"><img class="logo-img img-responsive" src="/images/logo3.png"></a>
                <span class="logo-text">Pakistan's First Ever Financial System For Assets to Grow, Skills To Show and Sustainable Cash Flow - RIZQPAK - Your Growth Partner</span>
            </div>
            <div class="card rp-card">
                <loading v-if="isLoading"></loading>
                <div class="card-body">
                    <h5 class="card-title dati-account-title text-center">Sign up to RP</h5>
                    <form action="#" method="POST" class="text-center mt-30 login-form" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
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
                            <a href="#" class="forgot-pass-text">Terms of services?</a>
                        </div>
                    </div>
                    <div class="row login-form">
                        <div class="col-md-12 p-md-0 text-center">
                            <hr>
                        </div>
                    </div>
                    <div class="row login-form mt-20">
                        <div class="col-md-12 text-left">
                            <button class="btn btn-primary login-btn btn-signup" type="submit"><a href="/login">Login</a></button>
                        </div>
                    </div>
                </div>
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

.login-wrapper {
    height: 100vh;
    font-size: 16px;

    & .parent-flex {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        align-items: center;
        justify-content: space-around;

        & .logo {
            display: flex;
            flex-direction: column;
            width: 45%;

            & .logo-img {
                width: 200px;
            }

            & .logo-text {
                margin-top: 10px;
                font-size: 20px;
                color: #fff;
            }
        }

        & .rp-card {
            width: 30%;

            & .btn-signup {
                background-color: #4dc0b5;
                border: 1px solid #4dc0b5;

                & a {
                    color: #fff;
                }

                &:focus {
                    border: 1px solid #4dc0b5;
                }
            }
        }
    }
}
</style>
