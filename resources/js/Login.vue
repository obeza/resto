<script setup lang="ts">
import { ref } from 'vue';
import { NCard, NButton, NSpace, NInput, NFormItem, NForm, FormInst, NAlert } from 'naive-ui'
import axiosClient from './axios';
import { useRouter } from 'vue-router';
import store from './store'

//const baseurl = `${import.meta.env.VITE_URL_API}`;
//console.log( import.meta.env )
const router = useRouter();
const formRef = ref<FormInst | null>(null);

const formValue= ref({
  email: '',
  password: ''
})

const errorCatch = ref(false)

const rules = ref({
  email: {
    required: true,
    message: "S'il vous plait, entrer votre email",
    trigger: ['input']
  },
  password: {
    required: true,
    message: "S'il vous plait, entrer votre mot de passe",
    trigger: ['input']
  }
})

// const getToken = async() => {
//   await axiosClient.get( "/sanctum/csrf-cookie");
// };

const handleLogin = async() => {
  console.log ( JSON.stringify(formValue.value))
  formRef.value?.validate(async (errors) => {
    if (!errors){
      //await getToken();

      try {
        const { data } = await axiosClient.post( '/login' , {
        email: formValue.value.email,
        password: formValue.value.password
      });

      console.log( 'login OK ' + JSON.stringify( data ) );
      store.state.user.token = data.token

      router.push({name:'restos'});
      } catch (err){
        console.log('error '+err)
        errorCatch.value = true
      }

    } else {
      console.log('errors formRef ...')
    }
  })
  
}

</script>
<template>
  <n-card>
    
      <h1>login</h1>
      <n-form 
        ref="formRef"
        @submit.prevent="handleLogin"
        :model="formValue"
        :rules="rules"
      >
        <n-form-item label="Email" path="email">
          <n-input 
            v-model:value="formValue.email" 
            type="text" 
            placeholder="Email"
          />
        </n-form-item>
        <n-form-item label="Password" path="password">
          <n-input
            type="password"
            show-password-on="click"
            v-model:value="formValue.password"
            placeholder="Mot de passe"
          />
        </n-form-item>
        <n-button type="info" attr-type="submit">Se connecter</n-button>
        <n-alert title="Erreur de connexion" type="error" v-show="errorCatch">
        Email ou mot de passe incorrect !
      </n-alert>
      </n-form>
      

  </n-card>
  
  
</template>