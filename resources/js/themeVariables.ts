import { ref } from 'vue';

export const light = 'light';
export const dark = 'dark';
export const activeTheme = ref(light);

if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    activeTheme.value = dark;
} else {
    activeTheme.value = light;
}