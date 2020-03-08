<template>
    <section class="content">
        <div class="container-fluid">
            <a href="/sales/create">
                <button type="button" class="btn btn-primary">
                    Create Sales Item
                </button>
            </a>
            <div class="mt-4 col-md-12"></div>
            <table-vue uri="/sales/get" title="Sales Heads" edit-url="/sales/id/edit" delete-url="/sales/id"></table-vue>
        </div>
    </section>
</template>

<script>
    export default {
    }
</script>