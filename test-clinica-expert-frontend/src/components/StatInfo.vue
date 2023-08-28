<template>
  <div class="stat-info">
    <slot></slot>

    <div class="info">
      <span class="value">{{ value }}</span>
      <span class="text">{{ text }}</span>
    </div>
  </div>
</template>

<script setup lang="ts">
  defineProps({
    value: {
      type: Number,
      required: true
    },

    text: {
      type: String,
      required: false
    }
  })
</script>

<style scoped>
.stat-info {
  display: flex;
  flex-direction: row;
  width: 76px;
  height: 50px;

  :slotted(.icon) {
    margin-right: 20px;
  }

  .info {
    display: flex;
    flex-direction: column;

    > span {

      &:first-child {
        font-size: 28px;
        font-weight: bold;
      }
      &:nth-child(2) {
        font-size: 12px;
        color: var(--color-info);
        font-weight: bold;
      }
    }
  }
}
</style>
