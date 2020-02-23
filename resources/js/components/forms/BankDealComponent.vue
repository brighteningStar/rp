<template>
    <section class="content">
        <div class="container-fluid">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                Create Bank Deal
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
                                    <input type="text" class="form-control" placeholder="Deal Number" name="deal_number" v-model="form.deal_number">
                                    <span class="error invalid-feedback" v-if="form.errors.has('deal_number')" v-text="form.errors.get('deal_number')"></span>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Exchange Rate" name="exchange_rate" v-model="form.exchange_rate">
                                    <span class="error invalid-feedback" v-if="form.errors.has('exchange_rate')" v-text="form.errors.get('exchange_rate')"></span>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Deal Amount" name="deal_amount" v-model="form.deal_amount">
                                    <span class="error invalid-feedback" v-if="form.errors.has('deal_amount')" v-text="form.errors.get('deal_amount')"></span>
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
            <table-vue uri="/forms/bank-deals/get" title="Bank Deals"></table-vue>
        </div>
    </section>
</template>

<script>
    import {Form} from "../../Form"
    export default {
        data() {
            return {
                form: new Form({
                    deal_number: '',
                    exchange_rate: '',
                    deal_amount: '',
                    loading:false
                }),
                title:'Create New Bank Deal',
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
                this.form.post('/forms/bank-deals')
                    .then(function (response) {
                        Event.$emit('reloadTable');
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                    })
                    .catch(errors => console.log(errors));
            },

            updateItem(){
                this.form.put('/forms/bank-deals/'+this.editID)
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
                self.title = "Create New Bank Deal";
                self.method = "create";
                this.editID = null;
            });
        },

        created() {
            Event.$on('editModal', (data) => {
                let colorID = data.itemId;
                this.title = "Update Bank Deal";
                this.method = "update";
                this.editID = colorID;
                this.form.loading = true;
                axios.get('/forms/bank-deals/'+colorID)
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