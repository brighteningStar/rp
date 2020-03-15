<template>
    <section class="content">
        <div class="container-fluid">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                Create Customer
            </button>
            <div class="modal fade" id="modal-xl">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <loading v-if="form.loading"></loading>
                            <h4 class="modal-title">{{title}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="#" method="post" @submit.prevent="onSubmit">
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
                                    <input type="text" class="form-control" placeholder="Phone" name="phone" v-model="form.phone">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-phone"></span>
                                        </div>
                                    </div>
                                    <span class="error invalid-feedback" v-if="form.errors.has('phone')" v-text="form.errors.get('phone')"></span>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Address" name="address" v-model="form.address">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                    <span class="error invalid-feedback" v-if="form.errors.has('address')" v-text="form.errors.get('address')"></span>
                                </div>

                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="mt-4 col-md-12"></div>
            <table-vue uri="/forms/customers/get" title="Customers" delete-url="/forms/customers/id"></table-vue>
        </div>
    </section>
</template>

<script>
    import {Form} from "../../Form"
    export default {
        data() {
            return {
                form: new Form({
                    name: '',
                    email: '',
                    phone: '',
                    address: '',
                    loading:false,
                }),
                title:'Create New Customer',
                method:'create',
                editID:null,
            };
        },
        methods: {
            onSubmit() {
                if(this.method=='create'){
                    this.createItem();
                } else {
                    this.updateItem();
                }

            },

            createItem(){
                this.form.post('/forms/customers')
                    .then(function (response) {
                        Event.$emit('reloadTable');
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                    })
                    .catch(errors => console.log(errors));
            },

            updateItem(){
                this.form.put('/forms/customers/'+this.editID)
                    .then(function (response) {
                        Event.$emit('reloadTable');
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                    })
                    .catch(errors => console.log(errors));
            },
        },
        mounted() {
            let self = this;
            $('#modal-xl').on('hidden.bs.modal', function () {
                self.form.reset();
                self.title = "Create New Customer";
                self.method = "create";
                this.editID = null;
            });
        },

        created() {
            Event.$on('editModal', (data) => {
                let colorID = data.itemId;
                this.title = "Update Customer";
                this.method = "update";
                this.editID = colorID;
                this.form.loading = true;
                axios.get('/forms/customers/'+colorID)
                    .then(function (response) {
                        this.form.loading = false;
                        this.form.copyDataToForm(response.data);
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                    })
            });
        },
    }
</script>