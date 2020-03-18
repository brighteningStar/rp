<template>
    <loading  v-if="load" ></loading>
    <div v-else="">
        <v-select :value="value" :reduce="name => name.id" label="name" :options="items" @input="updateValue" :disabled="isDisabled"></v-select>
    </div>
</template>

<script>
    module.exports = {
        props: ['value', 'disabled'],
        data(){
            return{
                load: false,
                items:[],
                makeSelected: '',
                grade:'',
            }
        },

        computed: {
            isDisabled(){
                return this.disabled?true:false;
            }
        },

        methods: {
            updateValue(value) {
                this.grade = value;
                this.$emit('input', this.grade);
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
            axios.get('/forms/grades/get')
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
                this.grade = val;
            }
        }
    }
</script>