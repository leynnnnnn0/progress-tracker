<script setup>
import DivFlexCol from "@/Components/div/DivFlexCol.vue";
import Logo from "../../images/mainLogo.png";
import NavLink from "@/Components/NavLink.vue";
import ConfirmDialog from "primevue/confirmdialog";
import Toast from "primevue/toast";
import {
    Home,
    ListCheck,
    UsersRound,
    Warehouse,
    LogOut,
    ScrollText,
    Percent,
    Crosshair,
    Target,
    Shield,
    Users,
    Settings,
} from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import MainContainer from "@/Components/MainContainer.vue";
import { usePage } from "@inertiajs/vue3";
const { auth } = defineProps({
    isDashboard: {
        type: Boolean,
        default: false,
    },
});

const logout = () => {
    router.post("/logout");
};

const is_admin = usePage().props.auth.is_admin;
</script>

<template>
    <Toast />
    <ConfirmDialog></ConfirmDialog>
    <div
        class="grid min-h-screen w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr] overflow-hidden"
    >
        <!-- Sidebar -->
        <div class="hidden border-r bg-muted/40 md:block overflow-hidden">
            <div class="flex h-full max-h-screen flex-col gap-2">
                <div
                    class="flex h-14 items-center border-b px-4 lg:h-[60px] lg:px-6"
                >
                    <a href="/" class="flex items-center font-semibold">
                        <img :src="Logo" alt="logo" class="size-12" />
                        <span class="font-bold">DPCR Tracker</span>
                    </a>
                    <!-- <Button
                        variant="outline"
                        size="icon"
                        class="ml-auto h-8 w-8"
                    >
                        <Bell class="h-4 w-4" />
                        <span class="sr-only">Toggle notifications</span>
                    </Button> -->
                </div>
                <div
                    class="flex flex-col flex-1 overflow-y-auto scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
                >
                    <section class="flex-1">
                        <nav class="grid items-start pl-4 text-sm font-medium">
                            <NavLink :href="route('dashboard')" :icon="Home">
                                Dashboard
                            </NavLink>
                            <NavLink
                                href="/users"
                                :icon="UsersRound"
                                v-if="is_admin"
                            >
                                Users
                            </NavLink>
                            <NavLink
                                href="/offices"
                                :icon="Warehouse"
                                v-if="is_admin"
                            >
                                Offices
                            </NavLink>
                            <NavLink href="/tasks" :icon="ScrollText">
                                Tasks
                            </NavLink>
                            <NavLink
                                href="/offices-final-average"
                                :icon="Percent"
                                v-if="is_admin"
                            >
                                Offices Final Average
                            </NavLink>
                            <NavLink
                                href="/offices-target"
                                :icon="Crosshair"
                                v-if="is_admin"
                            >
                                Offices Target
                            </NavLink>
                            <NavLink href="/targets" :icon="Target">
                                Targets
                            </NavLink>
                            <NavLink
                                href="/audits"
                                :icon="Shield"
                                v-if="is_admin"
                            >
                                Audits
                            </NavLink>
                            <NavLink
                                href="/employees"
                                :icon="Users"
                                v-if="is_admin"
                            >
                                Employees
                            </NavLink>
                            <NavLink
                                href="/target-accomplished"
                                :icon="ListCheck"
                                v-if="is_admin"
                            >
                                Target Accomplished
                            </NavLink>
                            <NavLink href="/settings" :icon="Settings">
                                Settings
                            </NavLink>
                        </nav>
                    </section>
                    <button
                        @click="logout"
                        class="flex items-center gap-2 px-3 py-2 text-muted-foreground transition-all hover:text-primary"
                    >
                        <LogOut class="size-5" />
                        Logout
                    </button>
                </div>
            </div>
        </div>
        <!-- Main -->
        <DivFlexCol
            class="min-h-fit gap-5 overflow-y-scroll scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
            :class="isDashboard ? 'p-0' : 'p-10'"
        >
            <slot></slot>
        </DivFlexCol>
    </div>
</template>
