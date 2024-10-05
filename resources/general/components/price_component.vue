<template>
    <span>{{ value | price(currency) }}</span>
</template>

<script>
export default {
    name: "price_component",
    props: {
        value: {
            required: true
        },
        currency: {
            default: 'usd'
        }
    }
}
</script>
