<template>
    <div class="mx-auto grid max-w-screen-md place-items-center min-h-desktop">
        <form @submit.prevent="createTicket" class="flex w-full flex-col gap-8">
            <h1 class="title">Create Ticket</h1>
            <div class="grid grid-cols-2 gap-8">
                <label for="title" class="sr-only">Title</label>
                <input v-model="ticketForm.title" placeholder="Title" class="input-base" name="title" id="title"/>
                <div class="flex gap-2">
                    <select v-model="ticketForm.category_id" class="input-base">
                        <option value="0">Select Category</option>
                        <option v-for="category in categories" :value="category.id">{{ category.title }}</option>
                    </select>
                    <VButton @click="dialog?.show()" no-padding class="self-center rounded-full p-4">
                        <FaPlus/>
                    </VButton>
                </div>
                <textarea rows="10" class="col-span-2 input-base"
                          placeholder="What seems to be the issue?"
                          v-model="ticketForm.content"></textarea>
            </div>
            <VButton class="col-span-2 self-start" type="submit">Create Ticket</VButton>
        </form>
        <dialog ref="dialog">
            <div ref="innerDialog" class="max-w-screen-md transition-all lg:min-w-screen-md">
                <form @submit.prevent="createCategory" class="grid gap-4">
                    <h1 class="title">Create New Category</h1>
                    <input v-model="categoryForm.title" type="text" placeholder="Title"
                           class="transition-transform input-base focus:scale-105">
                    <VButton type="submit">Create Category</VButton>
                </form>
            </div>
        </dialog>
    </div>
</template>

<script setup lang="ts">
import {reactive, toRaw, ref} from 'vue';
import {useAxios} from '@/plugins/axios';
import {TicketForm} from '@/types/form-types';
import VButton from '@/components/VButton.vue';
import useSWRV from '@/composables/useSWRV';
import {FaPlus} from '@kalimahapps/vue-icons';
import {onClickOutside} from '@vueuse/core';

const axios = useAxios();
const { data: categories, mutate } = useSWRV('/categories');
const dialog = ref<HTMLDialogElement>();
const innerDialog = ref<HTMLDivElement>();
const ticketForm = reactive<TicketForm>({
    title: '',
    content: '',
    category_id: 0
});

const categoryForm = reactive({
    title: ''
});

const target = onClickOutside(innerDialog, () => {
    dialog.value?.close();
});

const createTicket = () => {
    axios.simplePost('/tickets', toRaw(ticketForm), {
        handleSuccess: (data) => {
            alert('Ticket created successfully');
        }
    });
};

const createCategory = () => {
    axios.simplePost('/categories', toRaw(categoryForm), {
        handleSuccess: (data) => {
            mutate(args => ({ ...args, data }), { forceRevalidate: false });
        }
    });
    dialog.value?.close();
};
</script>
