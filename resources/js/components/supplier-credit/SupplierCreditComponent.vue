<template>
    <section class="content">
        <div class="container-fluid">
            <a href="/supplier-credit/create">
                <button type="button" class="btn btn-primary">
                    Create Supplier Credit
                </button>
            </a>
            <div class="mt-4 col-md-12"></div>
            <table-vue uri="/supplier-credit/get" title="Supplier Credit" edit-url="/supplier-credit/id/edit" cant-delete="1"></table-vue>
        </div>
    </section>
</template>

<script>
    export default {
    }
</script>