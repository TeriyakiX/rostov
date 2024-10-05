<template>
    <span>{{ value | days }}</span>
</template>

<script>
export default {
    name: "day_component",
    props: {
        value: {
            required: true
        }
    }
}
</script>
