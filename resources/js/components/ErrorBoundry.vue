<template>
    <div>
        <div class="card card-height" v-if="applicationBreak">
            <span class="">Something went wrong, please try again</span>
        </div>
        <div class="card card-height" v-else-if="accessDenied">
            <span class="">{{error.message}}</span>
        </div>
        <slot v-else />
    </div>
</template>
<script type="text/babel">
    export default {
        name: 'ErrorBoundry',
        data() {
            return {
                error: {
                    message: '',
                    code: 200 // all ok
                }
            }
        },

        computed: {
            accessDenied() {
                return this.error.code === 422
            },

            applicationBreak() {
                return this.error.code === 500
            }
        },

        errorCaptured(error, vm, info) {
            this.error.code = error.status
            this.error.message = error.data.message
            return false
        }
    }
</script>

<style scoped>
.card-height {
    min-height: 200px;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #dc3545;
}

.card-height span {
    font-size: 20px;
    padding: 30px;
    text-align: center;
    color: #fff;
    font-weight: 600;
}
</style>