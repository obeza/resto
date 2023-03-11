<script setup lang="ts">
import { ref } from 'vue';
import { NCard, NButton, NSpace, NInput, NFormItem, NForm, FormInst, NAlert, NGrid, NGridItem } from 'naive-ui'
import axiosClient from './../axios/index';
import { useRouter } from 'vue-router';
//import store from './../store/index.js'
import useAuthStore from './../store/auth'

//const baseurl = `${import.meta.env.VITE_URL_API}`;
//console.log( import.meta.env )
const router = useRouter();
const formRef = ref<FormInst | null>(null);

const authStore = useAuthStore()

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
  console.log ( 'hendleLogin ' + JSON.stringify(formValue.value))
  formRef.value?.validate(async (errors) => {
    if (!errors){
      //await getToken();
      console.log('tentative login')
      try {
          const { data } = await axiosClient.post( '/login' , {
            email: formValue.value.email,
            password: formValue.value.password
          });

        console.log( 'login OK ' + JSON.stringify( data ) );
        //store.state.user.token = data.token
        authStore.setUser(data)

      router.push({name:'restos'});
      } catch (err){
        console.log('error login '+err.reponse)
        errorCatch.value = true
      }

    } else {
      console.log('errors formRef ...')
    }
  })
  
}

</script>
<template>
  <div class="login-back">
  <n-space justify="center"  class="login-space">

  <n-card class="login">
    
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
        <n-button 
          type="info" 
          attr-type="submit"
          size="large"
          class="login-button"
        >Se connecter</n-button>
        <n-alert title="Erreur de connexion" type="error" v-show="errorCatch">
        Email ou mot de passe incorrect !
      </n-alert>
      </n-form>
      

  </n-card>

</n-space>
</div>
</template>

<style scoped>
.login-back{
  position: fixed;
  width:100%;
  height:100%;
  background-color: #c0cccc;
}
.login-space{
  
}
.login{
  min-width: 400px;
  margin-top: 70px;

}
.login-button{
  width:100%;
}
</style>