<template>
    <section class="content">
        <div class="container-fluid">
            <a href="/rma/create">
                <button type="button" class="btn btn-primary">
                    Create RMA Item
                </button>
            </a>
            <div class="mt-4 col-md-12"></div>
            <table-vue uri="/rma/get" title="RMA Heads" edit-url="/rma/id/edit" cant-delete="1" cant-edit="1" view-url="/rma/id/view"></table-vue>
        </div>
    </section>
</template>

<script>
    export default {
    }
</script>