<template>
    <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="#" method="post" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" v-model="email" name="email">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <span class="error invalid-feedback" v-if="errors.has('email')" v-text="errors.get('email')"></span>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" v-model="password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <span class="error invalid-feedback" v-if="errors.has('password')" v-text="errors.get('password')"></span>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" :disabled="errors.any()">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
</template>

<script type="text/babel">
    import {Errors} from '../Errors';

    export default {

        data() {
            return {
                email:'',
                password:'',
                errors: new Errors()
            };
        },

        methods: {
            onSubmit() {
                axios.post('/login', this.$data)
                .then()
                .catch(error => this.errors.record(error.response.data.errors))
            }
        },

        mounted() {
        }
    }
</script>
