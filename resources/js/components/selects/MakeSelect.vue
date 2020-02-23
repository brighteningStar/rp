<template>
        <loading  v-if="load" ></loading>
        <label style="width:100%;" v-else="">Select Make
            <select class="form-control" ref="make" @input="updateValue()">
                <option value="">Please Select</option>
                <option v-for="item in items" :value="item.id">{{item.name}}</option>
            </select>
        </label>
</template>

<script>
    module.exports = {
        props: ['value'],
        data(){
            return{
                load: false,
                items:[],
                makeSelected: ''
            }
        },
        methods: {
            updateValue() {
                this.$emit('input', this.$refs.make.value);
            }
        },
        mounted() {
            this.load = true;
            axios.get('/forms/makes/get')
                .then(function (response) {
                    this.load = false;
                    this.items = response.data.items.data;
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                })

        },
        watch: {
            value: function(val) {
                this.$refs.make.value = val;
            }
        }
    }
</script>