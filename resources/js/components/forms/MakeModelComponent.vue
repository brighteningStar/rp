<template>
    <section class="content">
        <div class="container-fluid">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                Create Model
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
                                    <make-select v-model.sync="form.make_id"></make-select>
                                    <span class="error invalid-feedback" v-if="form.errors.has('make_id')" v-text="form.errors.get('make_id')"></span>
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
            <table-vue uri="/forms/make-models/get" title="Models" delete-url="/forms/make-models/id" cant-view="1"></table-vue>
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
                    make_id: '',
                    loading:false,
                }),
                title:'Create New Model',
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
                this.form.post('/forms/make-models')
                    .then(function (response) {
                        Event.$emit('reloadTable');
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                    })
                    .catch(errors => console.log(errors));
            },

            updateItem(){
                this.form.put('/forms/make-models/'+this.editID)
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
                self.title = "Create New Model";
                self.method = "create";
                this.editID = null;
            });
        },

        created() {
            Event.$on('editModal', (data) => {
                let colorID = data.itemId;
                this.title = "Update Color";
                this.method = "update";
                this.editID = colorID;
                this.form.loading = true;
                axios.get('/forms/make-models/'+colorID)
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