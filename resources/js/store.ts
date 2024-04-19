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