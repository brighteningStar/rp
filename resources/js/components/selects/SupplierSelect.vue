<template>
    <loading  v-if="load" ></loading>
    <div v-else="">
        <v-select :value="supplier" :reduce="name => name.id" label="name" :options="items" @input="updateValue" :disabled="isDisabled"></v-select>
    </div>
</template>

<script>
    module.exports = {
        props: ['value', 'disabled'],
        data(){
            return{
                load: false,
                items:[],
                supplier:'',
            }
        },

        computed: {
            isDisabled(){
                return this.disabled?true:false;
            }
        },
        methods: {
            updateValue(value) {
                this.supplier = value;
                this.$emit('input', this.supplier);
            },

            transformData(data){
                let myarr = [];
                for(let i=0;i<data.length;i++){
                    let myobj = {};
                    myobj.name = data[i].name;
                    myobj.id = data[i].id;
                    myarr.push(myobj);
                }
                return myarr;
            },
        },
        mounted() {
            this.load = true;
            axios.get('/forms/suppliers/get')
                .then(function (response) {
                    this.load = false;
                    this.items = this.transformData(response.data.items.data);
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                })

        },
        watch: {
            value: function(val) {
                this.supplier = val;
            }
        }
    }
</script>