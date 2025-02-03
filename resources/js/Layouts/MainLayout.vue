<script setup>
import DivFlexCol from "@/Components/div/DivFlexCol.vue";
import Logo from "../../images/mainLogo.png";
import NavLink from "@/Components/NavLink.vue";
import ConfirmDialog from "primevue/confirmdialog";
import Toast from "primevue/toast";
import { Home, ListCheck, UsersRound, Warehouse } from "lucide-vue-next";
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
                        <span class="font-bold">BSU</span>
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
                    class="flex-1 overflow-y-auto scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
                >
                    <nav class="grid items-start pl-4 text-sm font-medium">
                        <NavLink :href="route('dashboard')" :icon="Home">
                            Dashboard
                        </NavLink>
                        <NavLink href="/users" :icon="UsersRound">
                            Users
                        </NavLink>
                        <NavLink href="/offices" :icon="Warehouse">
                            Offices
                        </NavLink>
                        <NavLink href="/tasks" :icon="ListCheck">
                            Tasks
                        </NavLink>
                        <NavLink href="/targets" :icon="ListCheck">
                            Targets
                        </NavLink>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Main -->
        <DivFlexCol
            class="min-h-fit p-10 gap-5 overflow-y-scroll scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
        >
            <slot></slot>
        </DivFlexCol>
    </div>
</template>
