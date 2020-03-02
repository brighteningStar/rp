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
                                                <div class="form-group">
                                                    <label>Search by IMEI</label>
                                                    <div  v-if="row.spinner" class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :value="row.imei" :options="row.imeis" v-on:input="setImeiDetails($event, row)">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events" @keyup="searchImei(row, $event.target.value)"/>
                                                        </template>
                                                    </v-select>
                                                    <span class="error invalid-feedback" v-if="form.errors.has('details.'+index+'.imei')" v-text="form.errors.get('details.'+index+'.imei')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Price AED</label>
                                                    <input type="text" disabled class="form-control" v-model="row.price_aed">
                                                    <span class="error invalid-feedback" v-if="form.errors.has('details.'+index+'.price_aed')" v-text="form.errors.get('details.'+index+'.price_aed')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Freight</label>
                                                    <input type="text" disabled class="form-control" v-model="row.freight">
                                                    <span class="error invalid-feedback" v-if="form.errors.has('details.'+index+'.freight')" v-text="form.errors.get('details.'+index+'.freight')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>unit price</label>
                                                    <input type="text" class="form-control" v-model="row.unit_price">
                                                    <span class="error invalid-feedback" v-if="form.errors.has('details.'+index+'.unit_price')" v-text="form.errors.get('details.'+index+'.unit_price')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>discount</label>
                                                    <input type="text" class="form-control" v-model="row.discount">
                                                    <span class="error invalid-feedback" v-if="form.errors.has('details.'+index+'.discount')" v-text="form.errors.get('details.'+index+'.discount')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>amount</label>
                                                    <input type="text" class="form-control" v-model="row.amount">
                                                    <span class="error invalid-feedback" v-if="form.errors.has('details.'+index+'.amount')" v-text="form.errors.get('details.'+index+'.amount')"></span>
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
        props: ['id'],
        data() {
            return {
                form: new Form({
                    customer_id: '',
                    sale_date: '',
                    invoice_no: '',
                    loading:false,
                    details:[{
                        detail_id:'',
                        imei:'',
                        price_aed:'',
                        freight:'',
                        unit_price:'',
                        discount:'',
                        amount:'',
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

            onSubmitForm(){
                if(this.id) {
                    this.form.put('/sales/'+this.id)
                        .then(function (response) {
                            window.location.replace("/sales");
                        })
                        .catch(errors => console.log(errors));
                } else {
                    this.form.post('/sales')
                        .then(function (response) {
                            window.location.replace("/sales");
                        })
                        .catch(errors => console.log(errors));
                }

            },

            addRow(){
                this.form.details.push({
                    imei:'',
                    detail_id:'',
                    price_aed:'',
                    freight:'',
                    unit_price:'',
                    discount:'',
                    amount:'',
                    imeis:[],
                    spinner:false,
                });
            },

            deleteRow(index){
                this.form.details.splice(index, 1);
            },

            searchImei(row, imei){

                row.spinner=true;
                axios.get('/sales/search/imei',{
                    params: {
                        imei: imei
                    },
                })
                    .then(function (response) {
                        row.imeis = response.data;

                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        row.spinner=false;
                    });

            },

            setImeiDetails(event, row){
                if(event==null){
                    row.imei = '';
                    row.detail_id ='';
                    row.price_aed = '';
                    row.freight = '';
                } else {
                    row.imei = event.value.imei_no;
                    row.detail_id = event.value.id;
                    row.price_aed = event.value.price_aed;
                    row.freight = event.value.freight;
                }

            },

            getData(){
                this.form.loading = true;
                axios.get('/sales/'+this.id,{
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
                this.form.customer_id = data.customer_id;
                this.form.invoice_no = data.invoice_no;
                this.form.sale_date = data.sale_date;
                this.form.details = [];
                data.stock_details.forEach(function(entry) {
                    let newobj = {
                        detail_id:entry.id,
                        price_aed:entry.price_aed,
                        freight:entry.freight,
                        unit_price:entry.pivot.unit_price,
                        discount:entry.pivot.discount,
                        amount:entry.pivot.amount,
                        imeis:[{label:entry.imei_no, value:{id:entry.id, imei_no:entry.imei_no, price_aed:entry.price_aed , freight:entry.freight}}],
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
