<template>
  <div class="list-item">
    <font-awesome-icon class="dot" icon="fa-solid fa-ellipsis-vertical" size="lg" />

    <div class="text-link">
      <span class="link-name">{{ shortLink.identifier }}</span>
      <span @click="emits('access', shortLink.identifier)" class="short-link" href="">{{ shortLink.urlShort }}</span>
    </div>

    <div class="info-actions-group">
      <div class="hits-stats">
        {{ shortLink.hits }}
        <font-awesome-icon class="stats" icon="fa-chart-simple" size="lg" />
      </div>

      <div class="actions-container">
        <font-awesome-icon class="icon-action" icon="fa-clone" rotation=90 size="lg" />
        <font-awesome-icon class="icon-action" icon="fa-pen-to-square" size="lg" />
        <font-awesome-icon @click="emits('delete', shortLink.id)" class="icon-action delete" icon="fa-trash-can" size="lg" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { PropType } from "vue";
  import { ShortLink } from "../utils/types";

  const emits = defineEmits(['delete', 'access'])

  defineProps({
    shortLink: {
      type: Object as PropType<ShortLink>,
      required: true
    }
  })
</script>

<style scoped>
.list-item {
  border: 1px solid var(--color-borders);
  display: flex;
  border-radius: 5px;
  padding: 25px 30px;
  align-items: center;
  width: 100%;
  background-color: #fff;
  box-sizing: border-box;

  .dot {
    margin-right: 20px;
    color: var(--color-icon-info)
  }

  .text-link {
    display: flex;
    flex-direction: column;

    .short-link {
      cursor: pointer;
    }
  }

  .info-actions-group {
    display: flex;
    flex-direction: row;
    margin-left: auto;

    .hits-stats {
      margin-right: 30px;

      .stats {
        color: var(--color-icon-info)
      }
    }

    .actions-container {
      .icon-action {
        cursor: pointer;
        margin-right: 10px;
        color: var(--color-icon-action);

        &:last-child {
          margin-right: 0;
        }
      }
    }
  }
}
</style>
