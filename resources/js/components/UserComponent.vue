<template>
    <section class="content">
        <div class="container-fluid">
            <div class="modal fade" id="modal-xl">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <loading v-if="loading"></loading>
                        <div class="modal-header">
                            <h4 class="modal-title">Extra Large Modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="#" method="post" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
                            <div class="modal-body">
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
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <table-vue uri="/users"></table-vue>
        </div>
    </section>
</template>

<script>
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
                loading: true
            };
        },

        methods: {

            assignResponseToForm(data) {
                for (let [key] of Object.entries(data)) {
                    this.form[key] = data[key];
                }
            }
        },

        created() {
            Event.$on('openModal', (data) => {
                let userID = data.itemId;
                axios.get('/user/' + userID)
                    .then(function (response) {
                        this.loading = false;
                        this.assignResponseToForm(response.data);
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                    })
            });
        },

        mounted() {

        }
    }
</script>
