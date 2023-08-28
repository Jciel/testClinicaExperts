<template>
  <div class="search-bar">
    <font-awesome-icon
        @click="emits('search', inputSearch)"
        class="icon-search"
        icon="fa-solid fa-magnifying-glass"
        size="lg" />

    <input
        @keydown.enter="emits('search', inputSearch)"
        @input="inputSearch = ($event.target as HTMLInputElement)?.value"
        :value="inputSearch"
        class="input-search"
        type="text"
        placeholder="Search URL" />

    <font-awesome-icon
        @click="emits('createNew')"
        class="icon-add"
        icon="fa-solid fa-plus"
        size="lg" />
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";

const emits = defineEmits(['createNew', 'search'])

const inputSearch = ref<string>('')
</script>

<style scoped>
.search-bar {
  display: flex;
  align-items: center;
  box-sizing: border-box;

  .icon-search {
    margin-right: 20px;
  }

  .input-search {
    background-color: white;
    outline: none;
    color: #000;
    width: 100%;
    height: 100%;
    box-sizing: border-box;
    border: 1px solid var(--color-borders);
    border-radius: 5px;
    padding: 10px 20px;
  }

  .icon-add {
    cursor: pointer;
    margin-left: 20px;
  }
}
</style>
