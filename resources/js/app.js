import "../css/app.css";
import "./bootstrap";

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
import ShowButton from "./Components/button/ShowButton.vue";
import EditButton from "./Components/button/EditButton.vue";
import DeleteButton from "./Components/button/DeleteButton.vue";
import Heading from "./Components/text/Heading.vue";

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
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
