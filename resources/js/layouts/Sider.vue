<template>
  
  <div class="sider">
    <h4 class="logo">RestoGestion</h4>
    <n-menu :options="menuOptions" />
  </div>
</template>

<script lang="ts">
import { defineComponent, h, Component } from 'vue'
import { NIcon } from 'naive-ui'
import type { MenuOption } from 'naive-ui'

import { routeLocationKey, RouterLink } from 'vue-router'
import {
  LaptopOutline as WorkIcon,
  LogOutOutline as HomeIcon
} from '@vicons/ionicons5'

function renderIcon (icon: Component) {
  return () => h(NIcon, null, { default: () => h(icon) })
}

const menuOptions: MenuOption[] = [
  {
    label: () =>
      h(
        RouterLink,
        {
          to: {
            name: 'restos'
          }
        },
        { default: () => 'Restaurants' }
      ),
    key: 'go-to-restaurants',
    icon: renderIcon(HomeIcon)
  },
  {
    label: () =>
      h(
        RouterLink,
        {
          to: {
            name: 'utilisateurs'
          }
        },
        { default: () => 'Utilisateurs' }
      ),
    key: 'go-to-utilisateurs',
    icon: renderIcon(HomeIcon)
  },
  {
    label: () =>
      h(
        RouterLink,
        {
          to: {
            name: 'login'
          }
        },
        { default: () => 'Login' }
      ),
    key: 'go-to-login',
    icon: renderIcon(HomeIcon)
  },
]

export default defineComponent({
  setup () {
    return {
      menuOptions
    }
  }
})
</script>

<style>
  .siderBlue{
    background: rgb(58,62,204);
    background: linear-gradient(173deg, rgba(58, 62, 204, 1) 0%, rgba(164,80,220,1) 100%);
  }
  .logo{
    text-align: center;
  }
</style>