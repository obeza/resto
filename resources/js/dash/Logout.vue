<script setup lang="ts">
import { useRouter,useRoute } from 'vue-router';
import useAuthStore from './../store/auth.js'

const authStore = useAuthStore()
const router = useRouter();

console.log('deconnecter')
authStore.resetUser()
router.push({name:'login' });


</script>
