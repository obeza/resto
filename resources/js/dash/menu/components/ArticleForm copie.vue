<script setup lang="ts">
import { ref, PropType } from 'vue'
import {  NInput, NFormItem, NForm, FormInst } from 'naive-ui'

interface Tag {
  id: number
  titre: string
}

// const props = defineProps({
//   actionNom: {
//     type: String,
//     default: 'Ajouter'
//   },
//   titre: {
//     type: String,
//     default:'',
//     required: true
//   },
//   resume: {
//     type: String,
//     default:''
//   },
//   contenu: {
//     type: String,
//     default:''
//   },
//   prix: {
//     type: Number,
//     default:0
//   },
//   tags: {
//     type: [] as PropType<Tag[]>
//   }
// })

const props = defineProps({
  actionNom: String,
  titre: String,
  resume: String,
  contenu: String,
  prix: Number,
  tags: []
})

 



//

const emits = defineEmits([
  'update:titre',
  'update:resume',
  'update:contenu',
  'update:prix',
  'update:tags',
  'handleForm'
])

const updateEvent = ( emitValue, res)=>{
  emits( emitValue, res)
}

const handleForm = ()=>{
  console.log ('handleForm ' + JSON.stringify( props) )
  // formRef.value?.validate(async (errors) => {
  //   if (!errors){
  //     // emits('handleForm', {
  //     //   titre: props.titre,
  //     //   resume: props.resume,
  //     //   contenu: props.contenu,
  //     //   prix: props.prix,
  //     //   tags: props.tags
  //     // } )
  //   } else {
  //     console.log('errors formRef ...')
  //   }
  // })
}


// ref="formRef"
//         @submit.prevent="handleForm"
//         :model="props"
//         :rules="rules"

</script>

<template>
  
        <n-form-item label="Titre" path="titre">
          <input
            :value="props.titre"
            @input="emits('update:titre',$event.target.value)"
            type="text"
          />
        </n-form-item>
      
        <n-form-item label="Resume" path="resume">
          <input 
            :value="props.resume" 
            @input="emits('update:resume',$event.target.value)"
            type="text"
            maxlength="255"
          />
        </n-form-item>
         
        <n-form-item label="Contenu" path="contenu">
          <textarea 
            :value="props.contenu" 
            
            @input="emits('update:contenu', $event.target.value)"
            maxlength="500"
          >
          </textarea>
        </n-form-item>
        <n-form-item label="Prix" path="prix">
          <n-input-number 
            :value="props.prix" 
            type="text" 
            @input="emits('update:prix',$event.target.value)"
          />
        </n-form-item>
        
        
        

</template>