import Vue from "vue";
import Vuetify from "vuetify/lib";

// import currency
import VCurrencyField from "v-currency-field";
import { VTextField } from "vuetify/lib";  //Globally import VTextField

// import currency
import { TiptapVuetifyPlugin } from "tiptap-vuetify";
import "tiptap-vuetify/dist/main.css";

Vue.use(Vuetify);

// tiptap
const vuetify = new Vuetify();
Vue.use(TiptapVuetifyPlugin,  {
	vuetify,
	iconsGroup: "mdi",
});

// currency
Vue.component("v-text-field", VTextField);
Vue.use(VCurrencyField, { 
	decimalLength: 0,
	autoDecimalMode: true,
	min: null,
	max: null,
	valueAsInteger: true,
	defaultValue: 0
});

export default new Vuetify({

});
