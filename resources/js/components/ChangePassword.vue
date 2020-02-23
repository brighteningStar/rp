<template>
    <loading v-if="form.loading"></loading>
    <section v-else="" class="content">
        <div class="container-fluid">
            <form action="#" method="post" @submit.prevent="onSubmit">
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Type Current Password" name="curr_password" v-model="form.curr_password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('curr_password')" v-text="form.errors.get('curr_password')"></span>
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Type New Password" name="new_password" v-model="form.new_password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('new_password')" v-text="form.errors.get('new_password')"></span>
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Retype password" name="new_password_confirmation" v-model="form.new_password_confirmation">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <span class="error invalid-feedback" v-if="form.errors.has('new_password_confirmation')" v-text="form.errors.get('new_password_confirmation')"></span>
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
            </form>
        </div>
    </section>
</template>

<script>
    import {Form} from "../Form"
    export default {
        props: ['id'],
        data() {
            return {
                form: new Form({
                    curr_password: '',
                    new_password: '',
                    new_password_confirmation: '',
                    loading:true,
                }),
            };
        },
        methods: {
            onSubmit() {
                this.form.post('/update-password/'+this.id)
                    .then(function (response) {

                    }.bind(this))
                    .catch(errors => console.log(errors));
            },

        },
        mounted() {

        },

    }
</script>