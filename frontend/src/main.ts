import { createApp } from "vue";
import { createPinia } from "pinia";
import { Quasar, Notify, Dialog } from "quasar";
import { LoadingPlugin } from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
// import { QuasarTiptapPlugin, RecommendedExtensions } from 'quasar-tiptap'

// Import icon libraries
import "@quasar/extras/material-icons/material-icons.css";

// Import Quasar css
import "quasar/src/css/index.sass";

import App from "./App.vue";
import router from "./router";

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.use(LoadingPlugin);
// app.use(QuasarTiptapPlugin, {
//   language: 'zh-hans',
//   spellcheck: true
// })

app.use(Quasar, {
    plugins: { Notify, Dialog },
    // import Quasar plugins and add here
    /*
  config: {
    brand: {
      // primary: '#e46262',
      // ... or all other brand colors
    },
    notify: {...}, // default set of options for Notify Quasar plugin
    loading: {...}, // default set of options for Loading Quasar plugin
    loadingBar: { ... }, // settings for LoadingBar Quasar plugin
    // ..and many more (check Installation card on each Quasar component/directive/plugin)
  }
  */
});

app.mount("#app");
