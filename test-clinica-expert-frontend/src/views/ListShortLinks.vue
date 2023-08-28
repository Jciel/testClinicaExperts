<template>
  <section class="list-link-page">
    <StatBar :links="stats.links" :clicks="stats.hits" />
    <MenuList
        @order="orderShortLinks"
    />

    <div class="list-links-container">
      <ListItem
          @delete="deleteShortItem"
          @access="accessLink"
          class="links"
          v-for="(shortLink, index) in shortLinks"
          :key="index"
          :short-link="shortLink" />

    </div>
  </section>
</template>

<script setup lang="ts">
import ListItem from "@/components/ListItem.vue";
import MenuList from "@/components/MenuList.vue";
import { useShortLinkStore } from "@/store/shortLinksStore.ts";
import { computed, onMounted, reactive } from "vue";
import StatBar from "@/components/StatBar.vue";
import { OrderShortLinks } from "@/utils/types.ts";

const shortLinkStore = useShortLinkStore()
const shortLinks = computed(() => shortLinkStore.getShortLinks )
const stats = computed(() => shortLinkStore.getStats )

onMounted(() => shortLinkStore.fetchShortLinks(1, orders))
onMounted(() => shortLinkStore.fetchStats())

const deleteShortItem = (id: string) => shortLinkStore.deleteShortLink(id)
const accessLink = (id: string) => shortLinkStore.accessLink(id)

const orders = reactive<OrderShortLinks>({
  created: 'asc',
  hits: 'asc',
  identifier: 'asc',
  url: 'asc'
})

const orderShortLinks = (value: OrderShortLinks) => {
  orders.created = value.created ?? orders.created
  orders.hits = value.hits ?? orders.hits
  orders.identifier = value.identifier ?? orders.identifier
  orders.url = value.url ?? orders.url

  shortLinkStore.fetchShortLinks(1, orders)
}
</script>

<style scoped>
.list-link-page {
  .list-links-container {
    .links {
      margin-top: 20px;

      &:first-child {
        margin-top: 0;
      }
    }
  }
}
</style>
