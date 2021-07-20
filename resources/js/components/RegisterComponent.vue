<template>
    <div class="card">
        <loading v-if="isLoading"></loading>
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new member</p>
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
                    <select type="role" class="form-control no-border" placeholder="Role" name="role_id" v-model="form.role_id">
                        <option value="">Select Role</option>
                        <option v-for="(role, index) in allRoles" :key="index" :value="role.id">{{role.label}}</option>
                    </select>
                    <span class="error invalid-feedback" v-if="form.errors.has('role_id')" v-text="form.errors.get('role_id')"></span>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="CNIC" name="cnic" v-model="form.cnic">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-id-card"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('cnic')" v-text="form.errors.get('cnic')"></span>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Mobile Number" name="mobile_no" v-model="form.mobile_no">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-mobile"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('mobile_no')" v-text="form.errors.get('mobile_no')"></span>
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
                <div class="row mb-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span>Already has an account? Please <a href="/login">Login here</a></span>
                    </div>
                </div>
            </form>
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
            await this.form.post('/register')
        },

        async fetchRoles() {
            this.allRoles = await this.service.getRoles()
        }
    },

    async created() {
        this.loading = true
        await this.fetchRoles()
        this.loading = false
    }
}
</script>

<style scoped>
.no-border {
    border-right: 1px solid #ccc !important;
}
</style>