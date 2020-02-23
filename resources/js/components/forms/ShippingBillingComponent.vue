<template>
    <section class="content">
        <div class="container-fluid">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                Create Shipping Billing
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
                                    <input type="text" class="form-control" placeholder="Name" name="name" v-model="form.name">
                                    <span class="error invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Address" name="address" v-model="form.address">
                                    <span class="error invalid-feedback" v-if="form.errors.has('address')" v-text="form.errors.get('address')"></span>
                                </div>

                                <div class="input-group mb-3">
                                    <label style="width:100%;">Select Address Type
                                        <select class="form-control" v-model="form.address_type">
                                            <option value="">Please Select</option>
                                            <option value="bill_to">Bill To</option>
                                            <option value="ship_to">Ship To</option>
                                        </select>
                                    </label>
                                    <span class="error invalid-feedback" v-if="form.errors.has('address_type')" v-text="form.errors.get('address_type')"></span>
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
            <table-vue uri="/forms/shipping-billings/get" title="Shipping Billing"></table-vue>
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
                    address: '',
                    address_type: '',
                    loading:false
                }),
                title:'Create New Shipping Billing',
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
                this.form.post('/forms/shipping-billings')
                    .then(function (response) {
                        Event.$emit('reloadTable');
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                    })
                    .catch(errors => console.log(errors));
            },

            updateItem(){
                this.form.put('/forms/shipping-billings/'+this.editID)
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
                self.title = "Create New Shipping Billing";
                self.method = "create";
                this.editID = null;
            });
        },

        created() {
            Event.$on('editModal', (data) => {
                let colorID = data.itemId;
                this.title = "Update Region";
                this.method = "update";
                this.editID = colorID;
                this.form.loading = true;
                axios.get('/forms/shipping-billings/'+colorID)
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