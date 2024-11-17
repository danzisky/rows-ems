<template>
  <div class="z-[9999999] fixed bottom-8 right-4">
    <TransitionGroup name="list">
      <template v-for="(alert, index) in alerts" :key="index">
        <div
          v-if="alert.open"
          class="relative max-w-6xl px-6 py-4 m-2 text-white border-0 rounded text-xl_ animate-bounce_"
          :class="alertColor(alert.type)"
        >
          <span class="inline-block mr-5 text-xl align-middle">
            <i class="fas fa-bell"></i>
            <v-icon size="small">
              {{ alertIcon(alert.type) }}
            </v-icon>
          </span>
          <span class="inline-block mr-8 align-middle">
            {{ alert?.message ?? "nothing" }}
          </span>
          <button
            class="absolute top-0 right-0 mt-4 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none"
            v-on:click="closeAlert($event)"
          >
            <span>×</span>
          </button>
        </div>
      </template>
    </TransitionGroup>
  </div>
</template>
<style scoped>
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>
<script>
import AlertProps from "../Hooks/AlertProps";

export default {
  props: {
    alerts: Array,
  },
  data() {
    return {
      AlertProps: AlertProps,
      Icon: "mdi-check",
    };
  },
  methods: {
    alertColor(type) {
      let color;
      switch (type) {
        case "error":
          color = "bg-red-700";
          break;
        case "warning":
          color = "bg-amber-600";
          break;
        case "info":
          color = "bg-blue-600";
          break;
        default:
          color = "bg-green-600";
      }
      return color;
    },
    alertIcon(type) {
      let icon;
      switch (type) {
        case "error":
          icon = "mdi-alert-circle-outline";
          break;
        case "warning":
          icon = "mdi-alert-outline";
          break;
        case "info":
          icon = "mdi-information-outline";
          break;
        default:
          icon = "mdi-check";
      }
      return icon;
    },
    closeAlert(e) {
      e.target?.parentNode?.parentNode?.remove();
    },
  },
};
</script>
