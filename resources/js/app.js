import "../css/app.css";
import "./bootstrap";
import "primeicons/primeicons.css";

import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import MainLayout from "./Layouts/MainLayout.vue";
import DivFlexCenter from "./Components/div/DivFlexCenter.vue";
import DivFlexCol from "./Components/div/DivFlexCol.vue";
import TableContainer from "./Components/table/TableContainer.vue";
import Table from "./Components/table/Table.vue";
import TD from "./Components/table/TD.vue";
import TH from "./Components/table/TH.vue";
import TableHead from "./Components/table/TableHead.vue";
import TableBody from "./Components/table/TableBody.vue";
import Pagination from "./Components/table/Pagination.vue";
import Label from "./Components/ui/label/Label.vue";
import { Button } from "./Components/ui/button";
import {
    Filter,
    Eye,
    Pencil,
    Trash2,
    EllipsisVertical,
    Minus,
    Plus,
    MonitorCog,
    Download,
} from "lucide-vue-next";
import { Textarea } from "./Components/ui/textarea";
import ShowButton from "./Components/button/ShowButton.vue";
import EditButton from "./Components/button/EditButton.vue";
import DeleteButton from "./Components/button/DeleteButton.vue";
import Heading from "./Components/text/Heading.vue";
import { Input } from "@/components/ui/input";
import { Link } from "@inertiajs/vue3";
import InputContainer from "./Components/form/InputContainer.vue";
import InputLabel from "./Components/form/InputLabel.vue";
import PrimeVue from "primevue/config";
import Aura from "@primevue/themes/aura";
import ToastService from "primevue/toastservice";
import ConfirmationService from "primevue/confirmationservice";
import FormError from "./Components/form/FormError.vue";
import SpanXS from "./Components/text/SpanXS.vue";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component("MainLayout", MainLayout)
            .component("DivFlexCenter", DivFlexCenter)
            .component("DivFlexCol", DivFlexCol)
            .component("TableContainer", TableContainer)
            .component("Table", Table)
            .component("TD", TD)
            .component("TH", TH)
            .component("TableHead", TableHead)
            .component("TableBody", TableBody)
            .component("Pagination", Pagination)
            .component("Pencil", Pencil)
            .component("Trash2", Trash2)
            .component("Eye", Eye)
            .component("ShowButton", ShowButton)
            .component("DeleteButton", DeleteButton)
            .component("EditButton", EditButton)
            .component("Heading", Heading)
            .component("Button", Button)
            .component("Input", Input)
            .component("Link", Link)
            .component("InputContainer", InputContainer)
            .component("InputLabel", InputLabel)
            .component("Label", Label)
            .component("Textarea", Textarea)
            .component("FormError", FormError)
            .component("SpanXS", SpanXS)
            .use(ToastService)
            .use(ConfirmationService)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        prefix: "p",
                        darkModeSelector: false || "none",
                        cssLayer: false,
                    },
                },
            })
            .use(plugin)
            .use(ZiggyVue)

            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
