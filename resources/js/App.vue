<script setup >
import { ref, computed } from 'vue'

import { NSpace, NLayout, NLayoutContent,NLayoutFooter } from 'naive-ui'
import Header from './layouts/Header.vue'
import Sider from './layouts/Sider.vue'


</script>

<template>
  <n-space vertical size="large">
    <n-layout>
      <n-layout>
        <!-- <Header v-if="$route.name!='login'"/> -->
        <n-layout has-sider>
          <Sider v-if="$route.name!='login'"/>
          <n-layout-content>
            <router-view></router-view>
          </n-layout-content>
        </n-layout>        
        <n-layout-footer id="footer">
          footer content
          <div><router-link to="/login">Login</router-link></div>
        </n-layout-footer>
      </n-layout>
    </n-layout>
  </n-space>
</template>

<style>

</style>