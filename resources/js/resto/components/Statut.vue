<template>
  <n-tag v-if="actif" type="success">actif</n-tag>
  <n-tag v-else type="warning">inactif</n-tag>
</template>
<script setup lang="ts">
const props = defineProps({
  actif: Number,
})
console.log(props.actif)
</script>