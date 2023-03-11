<template>
  <n-input v-model:value="titre" type="text"/>
</template>

<script setup lang="ts">
import {NInput} from 'naive-ui'

defineProps({
  titre: {
    type: String,
    default:''
  },
})
</script>