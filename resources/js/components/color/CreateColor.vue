<template>
    <div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-color-modal">
            Create Color
        </button>
        <div class="modal fade" id="create-color-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <loading v-if="form.loading"></loading>
                        <h4 class="modal-title">Create New Color</h4>
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
    </div>
</template>

<script>
    import {Form} from "../../Form"
    export default {
        data() {
            return {
                form: new Form({
                    name: '',
                }),
            };
        },
        methods: {
            onSubmit() {
                this.form.post('/colors')
                    .then(function (response) {
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                    })
                    .catch(errors => console.log(errors));
            }
        },
        mounted() {
            let self = this;
            $('#create-color-modal').on('hidden.bs.modal', function () {
                self.form.reset();
            });
        }
    }
</script>