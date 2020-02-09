<template>
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>

            <form action="#" method="post" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Full name" name="name" v-model="name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="errors.has('name')" v-text="errors.get('name')"></span>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" v-model="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="errors.has('email')" v-text="errors.get('email')"></span>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" v-model="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="errors.has('password')" v-text="errors.get('password')"></span>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation" v-model="password_confirmation">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="errors.has('password_confirmation')" v-text="errors.get('password_confirmation')"></span>
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
    import {Errors} from '../Errors';

    export default {

        data() {
            return {
                name:'',
                email:'',
                password:'',
                password_confirmation:'',
                errors: new Errors()
            };
        },

        methods: {
            onSubmit() {
                axios.post('/register', this.$data)
                .then()
                .catch(error => this.errors.record(error.response.data.errors))
            }
        },

        mounted() {
        }
    }
</script>
