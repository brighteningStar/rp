<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <loading v-if="form.loading"></loading>
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
                                                <label>Select Customer</label>
                                                <customer-select v-model.sync="form.customer_id"></customer-select>
                                                <span class="error invalid-feedback" v-if="form.errors.has('customer_id')" v-text="form.errors.get('customer_id')"></span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Sales Date</label>
                                                <datepicker :format="dateFormatter" class="v-datepicker-custom" name="sales_date" v-model="form.sale_date"></datepicker>
                                                <span class="error invalid-feedback" v-if="form.errors.has('sale_date')" v-text="form.errors.get('sale_date')"></span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Invoice Number</label>
                                                <input type="text" v-model="form.invoice_no" class="form-control" placeholder="Invoice Number">
                                                <span class="error invalid-feedback" v-if="form.errors.has('invoice_no')" v-text="form.errors.get('invoice_no')"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-section mt-5">
                                    <h4>Detail Section</h4>
                                    <hr>
                                    <div class="detail-section-row mt-2" v-for="(row, index) in form.details">
                                        <div class="row">
                                            <a href="#" @click.prevent="deleteRow(index)" class="delete-detail-row"><i class="far fa-times-circle"></i></a>
                                            <div class="col-2">
<!--                                                <div class="form-group">-->
<!--                                                    <label>IMEI</label>-->
<!--                                                    <input type="text" class="form-control" v-model="row.imei">-->
<!--                                                </div>-->
                                                <div class="form-group">
                                                    <label>Region</label>
                                                    <div class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :options="[]" v-model="row.imei">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search"  v-bind="attributes" v-on="events" @keypress="searchImei('regions', $event.target.value)"/>
                                                        </template>
                                                    </v-select>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Price AED</label>
                                                    <input type="text" class="form-control" v-model="row.price_aed">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Frieght</label>
                                                    <input type="text" class="form-control" v-model="row.freight">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>unit price</label>
                                                    <input type="text" class="form-control" v-model="row.unit_price">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>discount</label>
                                                    <input type="text" class="form-control" v-model="row.discount">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>amount</label>
                                                    <input type="text" class="form-control" v-model="row.amount">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button style="float:right; margin-top:10px;" @click.prevent="addRow" class="btn btn-success">Add</button>
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
                    sale_date: '',
                    invoice_no: '',
                    loading:false,
                    details:[{
                        imei:'',
                        price_aed:'',
                        freight:'',
                        unit_price:'',
                        discount:'',
                        amount:'',
                    }],
                }),
            };
        },
        methods: {
            dateFormatter(date) {
                return moment(date).format('DD-MM-YYYY');
            },

            onSubmitForm(){
                console.log(this.form);
                // this.form.post('/sales')
                //     .then(function (response) {
                //         window.location.replace("/sales");
                //     })
                //     .catch(errors => console.log(errors));
            },

            addRow(){
                this.form.details.push({
                    imei:'',
                    price_aed:'',
                    freight:'',
                    unit_price:'',
                    discount:'',
                    amount:'',
                });
            },

            deleteRow(index){
                this.form.details.splice(index, 1);
            },

            searchImei(name, search){

            },
        },



    }
</script>