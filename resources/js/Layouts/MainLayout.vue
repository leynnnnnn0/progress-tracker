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
    Menu,
    ChevronLeft,
    ChevronRight,
} from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import MainContainer from "@/Components/MainContainer.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

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

const isSidebarCollapsed = ref(false);
const isMobileSidebarOpen = ref(false);

const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

const toggleMobileSidebar = () => {
    isMobileSidebarOpen.value = !isMobileSidebarOpen.value;
};
</script>

<template>
    <Toast />
    <ConfirmDialog></ConfirmDialog>

    <!-- Main Layout Structure -->
    <div class="flex flex-col min-h-screen w-full overflow-hidden">
        <!-- Mobile Header - Only visible on small screens -->
        <div class="md:hidden flex h-16 items-center border-b px-4">
            <button @click="toggleMobileSidebar" class="p-2">
                <Menu class="h-6 w-6" />
            </button>
            <a href="/" class="flex items-center font-semibold ml-2">
                <img :src="Logo" alt="logo" class="size-8" />
                <span class="font-bold ml-2">DPCR Tracker</span>
            </a>
        </div>

        <!-- Content Area with Sidebar -->
        <div class="flex flex-1 overflow-hidden">
            <!-- Desktop Sidebar - Hidden on mobile, visible on md and up -->
            <div
                class="hidden md:flex border-r bg-muted/40 flex-col transition-all duration-300 overflow-hidden"
                :class="{
                    'w-[60px]': isSidebarCollapsed,
                    'w-[220px] lg:w-[280px]': !isSidebarCollapsed,
                }"
            >
                <div class="flex h-full max-h-screen flex-col gap-2">
                    <div
                        class="flex h-14 items-center border-b px-4 lg:h-[60px] lg:px-6 justify-between"
                    >
                        <a
                            href="/"
                            class="flex items-center font-semibold"
                            :class="{ 'justify-center': isSidebarCollapsed }"
                        >
                            <img :src="Logo" alt="logo" class="size-12" />
                            <span
                                class="font-bold ml-2"
                                v-if="!isSidebarCollapsed"
                                >DPCR Tracker</span
                            >
                        </a>
                        <button
                            @click="toggleSidebar"
                            class="p-1 rounded-md hover:bg-gray-200"
                        >
                            <ChevronLeft
                                v-if="!isSidebarCollapsed"
                                class="h-5 w-5"
                            />
                            <ChevronRight v-else class="h-5 w-5" />
                        </button>
                    </div>
                    <div
                        class="flex flex-col flex-1 overflow-y-auto scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
                    >
                        <section class="flex-1">
                            <nav
                                class="grid items-start pl-4 text-sm font-medium"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :icon="Home"
                                    :collapsed="isSidebarCollapsed"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Dashboard</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/users"
                                    :icon="UsersRound"
                                    :collapsed="isSidebarCollapsed"
                                    v-if="is_admin"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Users</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/offices"
                                    :icon="Warehouse"
                                    :collapsed="isSidebarCollapsed"
                                    v-if="is_admin"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Offices</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/tasks"
                                    :icon="ScrollText"
                                    :collapsed="isSidebarCollapsed"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Tasks</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/offices-final-average"
                                    :icon="Percent"
                                    :collapsed="isSidebarCollapsed"
                                    v-if="is_admin"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Offices Final Average</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/offices-target"
                                    :icon="Crosshair"
                                    :collapsed="isSidebarCollapsed"
                                    v-if="is_admin"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Offices Target</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/targets"
                                    :icon="Target"
                                    :collapsed="isSidebarCollapsed"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Targets</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/audits"
                                    :icon="Shield"
                                    :collapsed="isSidebarCollapsed"
                                    v-if="is_admin"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Audits</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/employees"
                                    :icon="Users"
                                    :collapsed="isSidebarCollapsed"
                                    v-if="is_admin"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Employees</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/target-accomplished"
                                    :icon="ListCheck"
                                    :collapsed="isSidebarCollapsed"
                                    v-if="is_admin"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Target Accomplished</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/goals"
                                    :icon="ListCheck"
                                    :collapsed="isSidebarCollapsed"
                                    v-if="is_admin"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Goals</span
                                    >
                                </NavLink>
                                <NavLink
                                    href="/settings"
                                    :icon="Settings"
                                    :collapsed="isSidebarCollapsed"
                                >
                                    <span v-if="!isSidebarCollapsed"
                                        >Settings</span
                                    >
                                </NavLink>
                                <button
                                    @click="logout"
                                    class="flex items-center gap-2 px-3 py-2 text-muted-foreground transition-all hover:text-primary"
                                    :class="{
                                        'justify-center': isSidebarCollapsed,
                                    }"
                                >
                                    <LogOut class="size-5" />
                                    <span v-if="!isSidebarCollapsed"
                                        >Logout</span
                                    >
                                </button>
                            </nav>
                        </section>
                    </div>
                </div>
            </div>

            <!-- Mobile Sidebar (overlay) -->
            <div
                v-if="isMobileSidebarOpen"
                class="fixed inset-0 z-50 bg-black bg-opacity-50 md:hidden"
                @click="toggleMobileSidebar"
            ></div>
            <div
                class="fixed top-0 left-0 z-50 h-full border-r bg-muted/40 md:hidden transition-all duration-300 overflow-hidden bg-white"
                :class="{
                    'w-[220px]': isMobileSidebarOpen,
                    'w-0': !isMobileSidebarOpen,
                }"
            >
                <div
                    class="flex h-full max-h-screen flex-col gap-2"
                    v-if="isMobileSidebarOpen"
                >
                    <div
                        class="flex h-14 items-center border-b px-4 justify-between"
                    >
                        <a href="/" class="flex items-center font-semibold">
                            <img :src="Logo" alt="logo" class="size-12" />
                            <span class="font-bold ml-2">DPCR Tracker</span>
                        </a>
                        <button
                            @click="toggleMobileSidebar"
                            class="p-1 rounded-md hover:bg-gray-200"
                        >
                            <ChevronLeft class="h-5 w-5" />
                        </button>
                    </div>
                    <div
                        class="flex flex-col flex-1 overflow-y-auto scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
                    >
                        <section class="flex-1">
                            <nav
                                class="grid items-start pl-4 text-sm font-medium"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :icon="Home"
                                >
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

            <!-- Main Content Area -->
            <div class="flex-1 overflow-y-auto">
                <DivFlexCol
                    class="min-h-fit gap-5 overflow-y-scroll scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
                    :class="isDashboard ? 'p-0' : 'p-10'"
                >
                    <slot></slot>
                </DivFlexCol>
            </div>
        </div>
    </div>
</template>
