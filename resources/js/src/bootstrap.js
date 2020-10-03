// Axios config.
window.axios = require("axios");
axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8000";

try {
  window.Popper = require("popper.js").default;
  window.$ = window.jQuery = require("jquery");
  require("bootstrap");
} catch (e) {}
