<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <loading v-if="form.loading"></loading>
                        <div class="card-header">
                            <h3 class="card-title">Supplier Credit Form</h3>
                        </div>
                        <div>
                            <div class="card-body">
                                <div class="head-section">
                                    <h4>Head Section</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Supplier Credit Date</label>
                                                <datepicker :format="dateFormatter" disabled class="v-datepicker-custom" name="supplier_credit_date" v-model="form.credit_date"></datepicker>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Invoice Number</label>
                                                <input type="text" v-model="form.credit_invoice_no" class="form-control" disabled placeholder="Invoice Number">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Select Supplier</label>
                                                <supplier-select v-model.sync="form.supplier_id" disabled="1"></supplier-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-section mt-5">
                                    <h4>Detail Section</h4>
                                    <hr>
                                    <div class="detail-section-row mt-2" v-for="(row, index) in form.details">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Search by IMEI</label>
                                                    <div  v-if="row.spinner" class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :value="row.imei" :options="row.imeis" v-on:input="setImeiDetails($event, row)" :disabled="true">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                    <span class="error invalid-feedback" v-if="form.errors.has('details.'+index+'.imei')" v-text="form.errors.get('details.'+index+'.imei')"></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>USD Price</label>
                                                    <input type="text" disabled class="form-control" v-model="row.usd_price">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import {Form} from "../../Form"
    export default {
        props: ['id'],
        data() {
            return {
                form: new Form({
                    supplier_id: null,
                    credit_invoice_no: '',
                    credit_date: '',
                    loading:false,
                    details:[{
                        detail_id:'',
                        imei:'',
                        usd_price:'',
                        imeis:[],
                        spinner:false,
                    }],
                }),
            };
        },

        methods: {
            dateFormatter(date) {
                return moment(date).format('DD-MM-YYYY');
            },

            getData(){

                this.form.loading = true;
                axios.get('/supplier-credit/'+this.id,{
                })
                    .then(function (response) {
                        this.loadData(response.data);

                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        this.form.loading = false;
                    }.bind(this));
            },

            loadData(data){
                let self = this;
                this.form.supplier_id = data.supplier_id;
                this.form.credit_invoice_no = data.supplier_credit_invoice_no;
                this.form.credit_date = data.supplier_credit_date;
                this.form.details = [];
                data.stock_details.forEach(function(entry) {
                    let newobj = {
                        detail_id:entry.id,
                        usd_price:entry.pivot.usd_price,
                        imeis:[{label:entry.imei_no, value:{id:entry.id, imei_no:entry.imei_no}}],
                        imei:entry.imei_no,
                        spinner:false,
                    }
                    self.form.details.push(newobj);
                });
            },

        },

        mounted() {
            if(this.id){
                this.getData();
            }
        }



    }
</script>