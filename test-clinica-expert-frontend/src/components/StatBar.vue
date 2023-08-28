<template>
  <section class="stats-bar">
    <h2>Stats</h2>

    <div class="stats-container">
      <StatInfo class="stat-info" :value="links" text="Links">
        <font-awesome-icon icon="fa-solid fa-link" size="lg" />
      </StatInfo>

      <StatInfo class="stat-info" :value="views" text="Views">
        <font-awesome-icon icon="fa-solid fa-eye" size="lg" />
      </StatInfo>

      <StatInfo class="stat-info" :value="clicks" text="Clicks">
        <font-awesome-icon icon="fa-solid fa-hand-pointer" size="lg" />
      </StatInfo>
    </div>
  </section>
</template>

<script setup lang="ts">
  import StatInfo from "@/components/StatInfo.vue";
  import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

  defineProps({
    links: {
      type: Number,
      default: 0
    },

    views: {
      type: Number,
      default: 0
    },

    clicks: {
      type: Number,
      default: 0
    },
  })
</script>

<style scoped>
  .stats-bar {
    width: 100%;
    border-bottom: 1px solid #eaedf3;
    box-sizing: border-box;
    padding: 30px 0;

    > h2 {
      color: var(--color-info);
      margin: 0 0 10px 0;
    }

    .stats-container {
      display: flex;
      flex-direction: row;


      .stat-info {
        margin-right: 40px;
      }
    }
  }
</style>
