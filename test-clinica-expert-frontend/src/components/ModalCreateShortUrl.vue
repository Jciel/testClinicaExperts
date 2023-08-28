<template>
  <section class="modal-create">
    <div @click="emits('closeModal')" class="overlay"></div>

    <div class="modal-body">
      <span class="error invalid-url">{{ msgError.url }}</span>
      <input
          @input="urlInput = ($event.target as HTMLInputElement)?.value"
          :value="urlInput"
          class="url-input"
          type="url"
          placeholder="URL" />

      <span class="error invalid-identifier">{{ msgError.identifier }}</span>
      <input
          @input="identifier = ($event.target as HTMLInputElement)?.value"
          :value="identifier"
          class="identifier-input"
          type="text"
          placeholder="Identifier (optional)" />

      <button
          @click="createShortLink"
          class="btn-create"
          role="button">
        Create
      </button>

      <div
          v-if="newShortUrl"
          class="new-url">
        <span>Sua nova URL:</span>
        <p>{{ newShortUrl }}</p>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import { useShortLinkStore } from "@/store/shortLinksStore.ts";
import {Errors, ShortLink} from "@/utils/types.ts";

const shortLinkStore = useShortLinkStore()
const urlInput = ref<string>("")
const identifier = ref<string>("")
const newShortUrl = ref<string>("")
const msgError = reactive({url: '', identifier: ''})

const emits = defineEmits(['closeModal'])

const createShortLink = () => {
  resetErrors()
  shortLinkStore.createShortLink(urlInput.value, identifier.value)
      .then((data: ShortLink | Errors) => {
        if ('urlShort' in data) {
          newShortUrl.value = (data as ShortLink).urlShort;
        } else if ('errors' in data) {
          msgError.url = (data as Errors).errors.url[0] || '';
          msgError.identifier = (data as Errors).errors.identifier || '';
        }
      })
}

const resetErrors = () => {
  msgError.url = ''
  msgError.identifier = ''
}
</script>

<style scoped>
.modal-create {
  position: absolute;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;

  .overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: #000;
    opacity: .4;
    z-index: 1;
  }

  .modal-body {
    width: 100%;
    height: 100%;
    max-width: 600px;
    max-height: 400px;
    background-color: #fff;
    border-radius: 10px;
    border: 1px solid var(--color-borders);
    z-index: 2;
    box-sizing: border-box;
    padding: 60px 20px 20px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;

    .error {
      font-size: 10px;
      color: var(--color-errors);
    }

    .identifier-input,
    .url-input {
      background-color: white;
      outline: none;
      color: #000;
      width: 100%;
      box-sizing: border-box;
      border: 1px solid var(--color-borders);
      border-radius: 5px;
      padding: 10px 20px;
      margin-bottom: 20px
    }

    .btn-create {
      background-color: var(--bg-button-primary);
      border: 0;
      border-radius: .5rem;
      box-sizing: border-box;
      font-weight: 600;
      line-height: 1.25rem;
      padding: .75rem 1rem;
      text-align: center;
      text-decoration: none #D1D5DB solid;
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
      cursor: pointer;
      touch-action: manipulation;

      &:hover { background-color: rgb(249,250,251); }

      &:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
      }

      &:focus-visible { box-shadow: none; }
    }

    .new-url {
      box-sizing: border-box;
      padding: 20px;

      > p {
        margin: 0;
      }
    }
  }
}
</style>
