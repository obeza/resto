<script setup lang="ts">
import { ref } from 'vue';
import axiosClient from '../axios'
import { NButton, NSpace, NForm, FormInst, NCard, NInput, NFormItem, NSwitch, NBreadcrumb, NBreadcrumbItem, frFR, dateFrFR } from 'naive-ui'
//import RestoForm from './RestoForm.vue'
import { useRouter,useRoute } from 'vue-router';
import LayoutAdmin from '../layouts/LayoutAdmin.vue';
import type { NLocale, NDateLocale } from 'naive-ui'


//const baseurl = `${import.meta.env.VITE_URL_API}`;

const currentDate = new Date()
const timestamp = currentDate.getTime()

const formValue= ref({
  nom: '',
  tel: '',
  email: '',
  adresse: '',
  commentaire: '',
  dt_abon: ref(0),
  actif: ref(true)
})

const locale = ref<NLocale | null>(frFR)
const dateLocale = ref<NDateLocale | null>(dateFrFR)

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

const router = useRouter();
const route = useRoute()
const rubriqueId = ref(route.params.rubriqueId)
const restoId = ref(route.params.restoId)
const loading = ref(true)
// get data du resto

const baseUrl = `/restos/${restoId.value}`
console.log( baseUrl )
axiosClient.get( baseUrl + '/edit' )
    .then(res => {
      console.log( "data resto loaded : " + JSON.stringify(res.data ))
      //state.articles = res.data.articles
      loading.value = false
      let resto = res.data
      formValue.value.nom = resto.nom
      formValue.value.tel = resto.tel
      formValue.value.email = resto.email
      formValue.value.adresse = resto.adresse
      formValue.value.commentaire = resto.commentaire
      formValue.value.dt_abon = formatDate( resto.dt_abon )
      formValue.value.actif = resto.actif
    })

function formatDate(date){
  let dt = date.split("-")
  dt = new Date(dt[0], dt[1]-1,dt[2])
  return ref(dt.getTime(dt))
}
    
const handleAdd = async() => {
  console.log ( 'formValue :' + JSON.stringify(formValue.value))
  formRef.value?.validate(async (errors) => {
    if (!errors){
      try {
        const { data } = await axiosClient.put( baseUrl , formValue.value );
        console.log( 'data get ' + JSON.stringify( data ) );
        router.push({name:'restos' });
      } catch(error) {
        console.log( 'error .... ' + JSON.stringify(error.response.data))
      }

    } else {
      console.log('errors formRef ...')
    }
  })
  
}

</script>

<template>
  <LayoutAdmin>
  <n-card class="HeaderRubrique">
    <n-breadcrumb>
      <n-breadcrumb-item>
        <router-link :to="{ name:'restos' }">
          Restaurants
        </router-link>
      </n-breadcrumb-item>
      <n-breadcrumb-item>
          Modifier un restaurant
      </n-breadcrumb-item>
    </n-breadcrumb>
  </n-card>
  <n-card>

      <n-form 
        ref="formRef"
        @submit.prevent="handleAdd"
        :model="formValue"
        :rules="rules"
      >
        <!-- <RestoForm
          v-model:nom="formValue.nom"
          v-model:tel="formValue.tel"
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
        <n-button type="info" attr-type="submit">Modifier</n-button>
        
      </n-form>

  </n-card>
  
  <!-- <pre>{{  JSON.stringify(formValue) }}</pre> -->
  </LayoutAdmin>
</template>