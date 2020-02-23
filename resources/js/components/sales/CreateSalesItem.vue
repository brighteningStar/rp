<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Sales Form</h3>
                        </div>
                        <form role="form" @submit.prevent="onSubmitForm">
                            <div class="card-body">
                                <div class="head-section">
                                    <h4>Head Section</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Customer</label>
                                                <input type="text" class="form-control" placeholder="Invoice Number">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Sales Date</label>
                                                <datepicker class="v-datepicker-custom" name="so_date" v-model="form.sales_date"></datepicker>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Invoice Number</label>
                                                <input type="text" class="form-control" placeholder="Invoice Number">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-section mt-5">
                                    <h4>Detail Section</h4>
                                    <hr>
                                    <div class="detail-section-row">
                                        <div class="row">
                                            <a href="#" class="delete-detail-row"><i class="far fa-times-circle"></i></a>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Sys ID</label>
                                                    <input type="email" class="form-control" id="invoice-no" placeholder="Sys ID">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import {Form} from "../../Form"
    export default {
        data() {
            return {
                form: new Form({
                    customer_id: '',
                    sales_date: '',
                    invoice_number: '',
                    loading:false,
                }),
            };
        },
        methods: {
            onSubmitForm(){
                console.log(this.form);
            }
        },



    }
</script>