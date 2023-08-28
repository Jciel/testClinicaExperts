<template>
  <section class="menu-list">
      <nav class="menu">
        <router-link class="home" to="/">
          <font-awesome-icon icon="fa-solid fa-house" />
          Home
        </router-link>
      </nav>

      <div class="actions-container">
        <div class="icons-container">
          <font-awesome-icon class="stats" icon="fa-chart-simple" size="lg" />
          <font-awesome-icon class="icon-action" icon="fa-trash-can" size="lg" />
        </div>

        <div class="orders-filters">
          <OrderShortLinks @order="emits('order', $event)" />

          <div class="filters">
            <font-awesome-icon icon="fa-solid fa-sliders" rotation=90 size="lg" />
            Filters
          </div>
        </div>
      </div>
  </section>
</template>

<script setup lang="ts">
import OrderShortLinks from "@/components/OrderShortLinks.vue";

const emits = defineEmits(['order'])
</script>

<style scoped>
.menu-list {
  display: flex;
  flex-direction: row;
  width: 100%;
  align-items: center;
  padding: 45px 0;

  .menu {
    width: 100px;
    margin-right: 20px;

    .home {
      box-sizing: border-box;
      padding: 10px;
      background-color: var(--bg-button-primary);
      color: var(--color-info);
      border-radius: 5px;
    }
  }

  .actions-container {
    display: flex;
    flex-direction: row;
    color: var(--color-icon-action);
    justify-content: space-between;
    width: 100%;
    align-items: center;

    .icons-container {
      display: flex;
      flex-direction: row;

      .stats { margin-right: 20px }
    }

    .orders-filters {
      display: flex;
      align-items: center;

      .filters {
        display: flex;
        justify-content: space-between;
        background-color: var(--bg-button-primary);
        width: 90px;
        box-sizing: border-box;
        padding: 10px;
        border-radius: 5px;
      }

    }
  }
}
</style>
