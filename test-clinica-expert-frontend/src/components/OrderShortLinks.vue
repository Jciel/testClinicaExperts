<template>
  <div class="order-container">
    <div class="order-actions" :class="{'active': activeOrders}">
      <label
          v-for="(optionOrder, index) in optionsOrder"
          :key="index"
          :for="optionOrder" >
        <span>{{ optionOrder }}:</span>
        <select
            @input="emits('order', {[optionOrder.toLowerCase()]: ($event.target as HTMLInputElement)?.value})"
            :id="optionOrder"
            class="select-input">
          <option selected value="asc">Asc</option>
          <option value="desc">Desc</option>
        </select>
      </label>
    </div>
    <font-awesome-icon
        @click="activeOrders = !activeOrders"
        class="order"
        icon="fa-solid fa-right-left"
        rotation=90 size="lg" />
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";

const activeOrders = ref<Boolean>(false)
const optionsOrder = ['Created', 'Hits', 'Identifier', 'Url']

const emits = defineEmits(['order'])
</script>

<style scoped>
.order-container {
  display: flex;
  flex-direction: row;
  align-items: center;

  .order-actions {
    display: flex;
    flex-direction: row;
    transition: all 0.3s ease-in-out;
    max-width: 0;
    overflow: hidden;
    margin-right: 10px;

    &.active { max-width: var(--max-width-page) }

    > label {
      display: flex;
      align-items: center;

      > span { margin-right: 5px }

      > select {
        background-color: white;
        outline: none;
        color: #000;
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        border: 1px solid var(--color-borders);
        border-radius: 5px;
        padding: 5px 5px;
        margin-right: 15px;
      }
    }
  }

  .order {
    cursor: pointer;
    margin-right: 20px;
  }

}
</style>
