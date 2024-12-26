import { defineStore } from 'pinia';
import { ref } from 'vue';

export type SidebarColor =
    | 'bg-gradient-primary'
    | 'bg-gradient-dark'
    | 'bg-gradient-info'
    | 'bg-gradient-success'
    | 'bg-gradient-warning'
    | 'bg-gradient-danger';

export type SidebarType = 'bg-gradient-dark' | 'bg-transparent' | 'bg-white';

export const useThemeStore = defineStore('theme', () => {
    const showFixedPlugin = ref<boolean>(false);
    const sidebarColor = ref<SidebarColor>('bg-gradient-primary');
    const sidebarType = ref<SidebarType>('bg-white');

    return {
        showFixedPlugin,
        sidebarColor,
        sidebarType,
    };
});
