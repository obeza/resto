<script setup lang="ts">
import { ref } from 'vue';
import axiosClient from './../axios'
import { NButton, NSpace, NForm, FormInst, NCard, frFR, dateFrFR } from 'naive-ui'
import RestoForm from './RestoForm.vue'
import LayoutAdmin from '../layouts/LayoutAdmin.vue';

//const baseurl = `${import.meta.env.VITE_URL_API}`;

const currentDate = new Date()
const timestamp = currentDate.getTime()

const formValue= ref({
  nom: '',
  tel: '',
  email: '',
  adresse: '',
  commentaire: '',
  dt_abon: ref(1183135260000),
  actif: ref(true)
})

const locale = ref(frFR)
const dateLocale = ref(dateFrFR)

const formRef = ref<FormInst | null>(null);
// const getToken = async() => {
//   await axios.get( baseurl + "/sanctum/csrf-cookie");
// };

const rules = ref({
  nom: {
    required: true,
    message: "Entrez le nom",
    trigger: ['input']
  },
  tel: {
    required: true,
    message: "Entrez le tel",
    trigger: ['input']
  },
  email: {
    required: false
  },
  adresse: {
    required: false
  },
  commentaire: {
    required: false
  },
  dt_abon: {
    required: false
  },
  actif: {
    required: false
  },

})

const handleAdd = async() => {
  console.log('formValue')
  console.log ( 'formValue :' + JSON.stringify(formValue.value))
  formRef.value?.validate(async (errors) => {
    if (!errors){
      //await getToken();

      try {
        const { data } = await axiosClient.post( '/restos' , formValue.value );
        console.log('data get')
        console.log( JSON.stringify( data ) );

      } catch(error) {
        console.log('error ....')
        console.log( JSON.stringify(error.response.data))
      }

    } else {
      console.log('errors formRef ...')
    }
  })
  
}

</script>

<template>
  <LayoutAdmin>
  <n-card title="Ajouter un restaurant" class="HeaderRubrique">
    <div>
      <router-link to="/restos">Restaurants</router-link>
      / Ajouter un restaurant
    </div>
  </n-card>
  <n-card>

      <n-form 
        ref="formRef"
        @submit.prevent="handleAdd"
        :model="formValue"
        :rules="rules"
      >
        <!-- <RestoForm
          :nom="formValue.nom"
          :tel="formValue.tel"
          v-model:email="formValue.email"
          v-model:adresse="formValue.adresse"
          v-model:commentaire="formValue.commentaire"
          v-model:dt_abon="formValue.dt_abon"
          v-model:actif="formValue.actif"
        /> -->
        <n-form-item label="Nom" path="nom">
          <n-input
            v-model:value="formValue.nom"

            type="text"
          />
        </n-form-item>
      
        <n-form-item label="Tel : (+123 456 123456)" path="tel">
          <n-input 
            v-model:value="formValue.tel" 

            type="text"
            placeholder="+123 456 123456" 
            pattern="[+]{1}[0-9]{3} [0-9]{3} [0-9]{6}"
          />
        </n-form-item>
         
        <n-form-item label="Email" path="email">
          <n-input 
            v-model:value="formValue.email" 
            type="text" 

          />
        </n-form-item>
        <n-form-item label="Adresse" path="adresse">
          <n-input 
            v-model:value="formValue.adresse" 
            type="text" 

          />
        </n-form-item>
        <n-form-item label="Commentaire" path="commentaire">
          <n-input 
            v-model:value="formValue.commentaire" 
            type="textarea" 

          />
        </n-form-item>
        <n-form-item label="Abonnement" path="dt_abon">
          <n-config-provider :locale="locale" :date-locale="dateLocale">
          <n-date-picker 
            v-model:value="formValue.dt_abon"
            type="date"

            value-format="dd/MM/yyyy"
            
          />
        </n-config-provider>
        </n-form-item>
        <n-form-item label="Actif" path="actif">
          <n-switch 
            v-model:value="formValue.actif"

          />
        </n-form-item>
        <n-button type="info" attr-type="submit">Ajouter</n-button>
        
      </n-form>

  </n-card>
  
  <!-- <pre>{{  JSON.stringify(formValue) }}</pre> -->
</LayoutAdmin>
</template>