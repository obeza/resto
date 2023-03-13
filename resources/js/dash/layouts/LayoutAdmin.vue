<template>
  <n-space vertical size="large">
    <n-layout>
      <n-layout>
        <!-- <Header v-if="$route.name!='login'"/> -->
        <n-layout has-sider>
          <Sider/>
          <n-layout-content>

            <slot></slot>

          </n-layout-content>
        </n-layout>        
        <n-layout-footer id="footer">
          footer content
          
        </n-layout-footer>
      </n-layout>
    </n-layout>
  </n-space>
</template>

<script setup lang="ts">

import { NSpace, NLayout, NLayoutContent,NLayoutFooter } from 'naive-ui'
import Header from './Header.vue'
import Sider from './Sider.vue'

console.log('bighead')
</script>
<style>
#footer{
  height: 80px;
  background-color: #F8FFDB;
}
</style>