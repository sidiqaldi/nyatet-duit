import dayjs from 'dayjs';
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useCategoriesStore = defineStore('categories', () => {
  const list = ref({}) as any

  function add(type: any, value: any) {
    list.value[type].push(value);
  }

  function init(categories: any) {
    list.value = categories
  }

  return { list, add, init }
})

export const usePeriodStore = defineStore('period', () => {
  const active = ref(dayjs().format('YYYY-MM-DD') as string);

  function set(year: number, month: number) {
    active.value = dayjs().year(year).month(month).format('YYYY-MM-DD');
  }

  return { active, set };
})