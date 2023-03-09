<script setup lang="ts">
import { ref } from 'vue'
import {  NInput, NFormItem, NSwitch } from 'naive-ui'

const props = defineProps({
  nom: {
    type: String,
    default:''
  },
  tel: {
    type: String,
    default:''
  },
  email: {
    type: String,
    default:''
  },
  adresse: {
    type: String,
    default:''
  },
  commentaire: {
    type: String,
    default:''
  },
  dt_abon: {
    type: Number,
    default: 0
  },
  actif: {
    type: Boolean,
    default:''
  }
})

const emit = defineEmits([
  'update:nom', 
  'update:tel', 
  'update:email',
  'update:adresse', 
  'update:commentaire', 
  'update:dt_abon',
  'update:actif'
])

function updateEvent( emitValue, res){
  console.log('res7 : ' + res)
  //nom.value = res
  emit( emitValue, res)
}

</script>

<template>
        <n-form-item label="Nom" path="nom">
          <n-input
            v-model:value="props.nom"
            @input="updateEvent('update:nom',nom)"
            type="text"
          />
        </n-form-item>
      
        <n-form-item label="Tel : (+123 456 123456)" path="tel">
          <n-input 
            v-model:value="props.tel" 
            @input="updateEvent('update:tel',tel)"
            type="text"
            placeholder="+123 456 123456" 
            pattern="[+]{1}[0-9]{3} [0-9]{3} [0-9]{6}"
          />
        </n-form-item>
         
        <n-form-item label="Email" path="email">
          <n-input 
            v-model:value="props.email" 
            type="text" 
            @input="updateEvent('update:email',email)"
          />
        </n-form-item>
        <n-form-item label="Adresse" path="adresse">
          <n-input 
            v-model:value="props.adresse" 
            type="text" 
            @input="updateEvent('update:adresse',adresse)"
          />
        </n-form-item>
        <n-form-item label="Commentaire" path="commentaire">
          <n-input 
            v-model:value="props.commentaire" 
            type="textarea" 
            @input="updateEvent('update:commentaire',commentaire)"
          />
        </n-form-item>
        <n-form-item label="Abonnement" path="dt_abon">
          <n-date-picker 
            v-model:value="props.dt_abon"
            type="date"
            @update:value="updateEvent('update:dt_abon',dt_abon)"
            value-format="dd/MM/yyyy"
            
          />
        </n-form-item>
        <n-form-item label="Actif" path="actif">
          <n-switch 
            v-model:value="props.actif"
            @update:value="updateEvent('update:actif',actif)"
          />
        </n-form-item>
        
</template>