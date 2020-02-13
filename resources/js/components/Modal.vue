<template>
    <div :id="name" class="modal-overlay text-left">
        <a href="#" class="cancel"></a>

        <div class="modal-stock">
            <slot></slot>

            <footer class="flex mt-8">
                <slot name="footer"></slot>
            </footer>

            <a href="#" class="close">&times;</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['name'],

        created() {
            Event.$on('openModal', (data) => {
                let userID = data.itemId;
                axios.get('/user/'+userID)
                    .then(function (response) {
                        console.log(response);
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                    })
            });
        },

        mounted() {
            console.log('already mounted');
        }
    }
</script>

<style>
    .modal-overlay {
        visibility: hidden;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, .4);
        transition: opacity .3s;
        opacity: 0;
        z-index: 9999;
    }
    .modal-overlay:target {
        visibility: visible;
        opacity: 1;
    }
    .modal-stock {
        position: relative;
        width: 500px;
        max-width: 80%;
        background: white;
        border-radius: 4px;
        padding: 2.5em;
        box-shadow: 0 5px 11px rgba(36, 37, 38, 0.08);
    }
    .modal-stock .close {
        position: absolute;
        top: 15px;
        right: 15px;
        color: grey;
        text-decoration: none;
    }
    .modal-overlay .cancel {
        position: absolute;
        width: 100%;
        height: 100%;
    }
</style>
