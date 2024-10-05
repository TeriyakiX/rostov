<template>
    <span>{{ date }}</span>
</template>

<script>
export default {
    name: "date_component",
    props: {
        value: {
            required: true
        },
        format: {
            default: 'date' // date | dateWithTime | dateWithSeconds
        },
    },
    computed: {
        date() {
            switch(this.format) {
                case 'dateWithSeconds':
                    return this.$options.filters.dateWithSeconds(this.value);
                case 'dateWithTime':
                    return this.$options.filters.dateWithTime(this.value);
                default:
                    return this.$options.filters.date(this.value);
            }

        }
    }
}
</script>
