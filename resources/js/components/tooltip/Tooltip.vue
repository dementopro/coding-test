<template>
<span :tooltip="tooltipText" :position="position"><slot /></span>
</template>

<script setup>
const props = defineProps({
    tooltipText: {
        type: String,
        default: "Tooltip text",
    },
    position: {
        default: "top",
        type: String,
    }
})
</script>