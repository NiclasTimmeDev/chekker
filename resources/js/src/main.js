import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";

require("./bootstrap");

Vue.config.productionTip = false;

console.log("okay");

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");
