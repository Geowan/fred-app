import Vue from "vue";
import { ValidationObserver,ValidationProvider } from "vee-validate";
import VSelectValidated from "./veevalidate/VSelectValidated";
import VTextFieldValidated from "./veevalidate/VTextFieldValidated";
import VTextAreaValidated from "./veevalidate/VTextAreaValidated";
import VCheckboxValidated from "./veevalidate/VCheckboxValidated";

//form inputs
import SorColorPicker from "./forms/SorColorPicker";

//layouts
import AppLogo from "./layouts/AppLogo";
import AppHeader from "./layouts/AppHeader";
import AppFooter from "./layouts/AppFooter";
import NoData from "./veevalidate/NoData";
import VFileInputValidated from "./veevalidate/VFileInputValidated";



/**
 * Common components
 */
Vue.component("validation-observer", ValidationObserver);
Vue.component("validation-provider", ValidationProvider);


Vue.component("v-text-field-validated",VTextFieldValidated);
Vue.component("v-text-area-validated",VTextAreaValidated);
Vue.component("v-checkbox-validated",VCheckboxValidated);
Vue.component("v-select-validated",VSelectValidated);
Vue.component("v-file-input-validated",VFileInputValidated);

Vue.component("sor-color-picker",SorColorPicker);
Vue.component("no-data-selection",NoData);


Vue.component("app-logo", AppLogo);
Vue.component("app-header",AppHeader);
Vue.component("app-footer",AppFooter);
