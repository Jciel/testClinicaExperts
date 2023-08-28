<template>
  <section class="header-user-bar">
    <SearchBar
        @search="searchShortUrl"
        @createNew="createNewShortLink"
        class="search-bar" />

    <div class="avatar-profile">
      <figure class="profile-image">
        <img src="/profile.jpg" alt="Imagem perfil" />
      </figure>
    </div>
  </section>

  <Teleport to="body" :disabled="activeCreate">
    <ModalCreateShortUrl
        @closeModal="createNewShortLink"
        v-if="activeCreate"/>
  </Teleport>
</template>

<script setup lang="ts">
import SearchBar from "@/components/SearchBar.vue";
import { ref } from "vue";
import ModalCreateShortUrl from "@/components/ModalCreateShortUrl.vue";
import { useShortLinkStore } from "@/store/shortLinksStore.ts";

const shortLinkStore = useShortLinkStore()
const activeCreate = ref(false)
const createNewShortLink = () => activeCreate.value = !activeCreate.value

const searchShortUrl = (url: string) => shortLinkStore.searchUrl(url)
</script>

<style scoped>
.header-user-bar {
  display: flex;
  background-color: #fff;
  box-sizing: border-box;
  padding: 25px 15px;

  .search-bar {
    max-width: 780px;
    margin: auto;
    width: 100%;
  }

  .avatar-profile {
    margin-left: auto;

    .profile-image {
      height: 65px;
      width: 65px;
      box-sizing: border-box;
      border-radius: 100%;
      margin: unset;

      > img {
        border-radius: 100%;
        height: 65px;
        width: 65px;
        object-fit: cover;
        display: block;
        border: 2px solid var(--color-borders);
      }
    }
  }
}
</style>
