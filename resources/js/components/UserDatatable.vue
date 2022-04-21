<template>
    <data-table
        :filters="filters"
        :columns="columns"
        :url="url">
        <div slot="filters" slot-scope="{ tableFilters, perPage }">
            <div class="row mb-2">
                <div class="col-md-4">
                    <input type="number" v-model="tableFilters.filters.salaryGt">
                    <input type="number" v-model="tableFilters.filters.salaryLt">
                </div>
            </div>
        </div>
    </data-table>
</template>

<script>
export default {
    data() {
        return {
            url: "http://127.0.0.1:8000/api/workers",
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'Name',
                    name: 'name',
                    orderable: true,
                },
                {
                    label: 'Salary',
                    name: 'salary',
                    orderable: true,
                },
                {
                    label: 'Departments',
                    name: 'departments',
                    transform: ({date, name}) => `${data[name].map((dep) => {return dep.name}).join(',')}`,
                    orderable: false,
                },
            ],
            filters: {
                salaryGt: null,
                salaryLt: null,
            },
        }
    },
}
</script>
