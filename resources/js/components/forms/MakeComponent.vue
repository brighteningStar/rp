<template>
    <section class="content">
        <div class="container-fluid">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl">
                Create Make
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
            <table-vue uri="/forms/makes/get" title="Make" delete-url="/forms/makes/id"></table-vue>
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
                    loading:false
                }),
                title:'Create New Make',
                method:'create',
                editID:null,
            };
        },
        methods: {
            onSubmit() {
                if(this.method=='create'){
                    this.createMake();
                } else {
                    this.updateMake();
                }

            },

            createMake(){
                this.form.post('/forms/makes')
                    .then(function (response) {
                        Event.$emit('reloadTable');
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                    })
                    .catch(errors => console.log(errors));
            },

            updateMake(){
                this.form.put('/forms/makes/'+this.editID)
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
                self.title = "Create New Make";
                self.method = "create";
                this.editID = null;
            });
        },

        created() {
            Event.$on('editModal', (data) => {
                let colorID = data.itemId;
                this.title = "Update Make";
                this.method = "update";
                this.editID = colorID;
                this.form.loading = true;
                axios.get('/forms/makes/'+colorID)
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