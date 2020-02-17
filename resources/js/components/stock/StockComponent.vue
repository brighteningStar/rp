<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" v-if="uploadPercentage">
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" :value.prop="uploadPercentage" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                 :style="{width:uploadPercentage+'%'}"></div>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <loading v-if="loading"></loading>
                        <div class="card-header">
                            <h3 class="card-title">Upload Excel</h3>
                        </div>
                        <form role="form" method="post" @submit.prevent="uploadExcel()">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="file">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" ref="file" v-on:change="fileHandle()">
                                            <label class="custom-file-label" for="file" v-text="fileName"></label>
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
    export default {

        data() {
            return {
                fileName: 'Choose file',
                file: '',
                uploadPercentage: 0,
                loading:false
            }
        },

        methods: {

            fileHandle() {
                this.file = this.$refs.file.files[0];
                this.fileName = this.file.name;
            },

            uploadExcel() {
                this.loading = true;
                let formData = new FormData();
                formData.append('file', this.file);
                axios.post('/process-excel', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function (progressEvent) {
                        this.uploadPercentage = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100));
                    }.bind(this)
                })
                    .then(function (response) {
                        this.loading = false;
                        this.fileName = 'Choose File';
                        console.log(response);
                    }.bind(this))
                    .catch(function (errors) {
                        console.log(errors);
                    });
            },
        },

        mounted() {
        }
    }
</script>
