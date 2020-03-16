<template>
    <section class="content">
        <div class="container-fluid">
            <a href="/supplier-credit/create">
                <button type="button" class="btn btn-primary">
                    Create Supplier Credit
                </button>
            </a>
            <div class="mt-4 col-md-12"></div>
            <table-vue uri="/supplier-credit/get" title="Supplier Credit" cant-delete="1" cant-edit="1" view-url="/supplier-credit/id/view"></table-vue>
        </div>
    </section>
</template>

<script>
    export default {
    }
</script>