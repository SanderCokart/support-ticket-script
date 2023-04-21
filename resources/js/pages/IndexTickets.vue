<template>
    <IndexLayout>
        <template #header-actions>
            <VButton @click="router.push({ name: 'tickets-create' })">New Ticket</VButton>
        </template>

        <!--TODO add a search bar-->
        <!--        <template #search>-->
        <!--            <div class="relative">-->
        <!--                <FaMagnifyingGlass class="absolute top-1/2 left-4 z-10 -translate-y-1/2 transform text-gray-300"/>-->
        <!--                <input type="text"-->
        <!--                       v-model="search"-->
        <!--                       placeholder="Search tickets..."-->
        <!--                       class="w-full rounded-lg pl-10 text-white placeholder:text-gray-300 bg-primaryLight">-->
        <!--            </div>-->
        <!--        </template>-->

        <template #list>
            <RouterLink v-for="ticket in tickets as TicketModel[]"
                        class="no-underline"
                        v-if="ticketsPresent"
                        :key="ticket.id"
                        :to="{name:'tickets-show',params:{id:ticket.id} }">

                <li class="rounded border-2 p-4 transition-colors border-accent bg-primaryLight hover:bg-secondary">
                    <div class="flex justify-between">
                        <h1>{{ ticket.title }}</h1>
                        <TicketStatus :status="ticket.status"/>
                    </div>
                    <p class="text-base line-clamp-4">{{ ticket.content }}</p>
                    <div class="flex items-baseline justify-between">
                        <span>Created: {{ moment.utc(ticket.created_at).fromNow() }}</span>
                        <VChip>
                            {{ ticket.category.title }}
                        </VChip>
                        <span>Last update: {{ moment.utc(ticket.updated_at).fromNow() }}</span>
                    </div>
                </li>
            </RouterLink>

            <li v-else
                class="rounded border-2 p-4 transition-colors border-accent bg-primaryLight hover:bg-secondary">
                <h1>No tickets found.</h1>
            </li>
        </template>

        <template #grid>
            <RouterLink v-for="ticket in tickets as TicketModel[]"
                        class="no-underline"
                        v-if="ticketsPresent"
                        :key="ticket.id"
                        :to="{name:'tickets-show',params:{id:ticket.id} }">

                <li class="flex h-full flex-col justify-between rounded border-2 p-4 transition-colors border-accent bg-primaryLight hover:bg-secondary">
                    <h1>{{ ticket.title }}</h1>
                    <VChip class="self-start">{{ ticket?.category.title }}</VChip>
                    <p class="line-clamp-4">{{ ticket.content }}</p>
                    <div class="flex justify-between">
                        <span>Created: {{ moment.utc(ticket.created_at).fromNow() }}</span>
                        <TicketStatus :status="ticket.status"/>
                        <span>Last update: {{ moment.utc(ticket.updated_at).fromNow() }}</span>
                    </div>
                </li>

            </RouterLink>
            <li v-else
                class="h-full rounded border-2 p-4 transition-colors border-accent bg-primaryLight hover:bg-secondary">
                <h1>No tickets found.</h1>
            </li>
        </template>

        <template #table>
            <div
                class="rounded-lg border-2 text-left border-accent h-[70vh] w-[min(90vw,1536px)] mx-auto overflow-x-auto">
                <table class="w-full relative">
                    <thead class="sticky top-0 bg-primary table-bottom-border">
                    <tr>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Created On</th>
                        <th class="px-6 py-4">Last Update</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Assigned To</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="ticket in tickets as TicketModel[]"
                        v-if="ticketsPresent"
                        :key="ticket.id"
                        @click="router.push({ name: 'tickets-show', params: { id: ticket.id } })"
                        class="cursor-pointer border-b border-accent hover:bg-accent">
                        <td class="whitespace-nowrap px-6 py-3 text-left">
                            {{ ticket.title }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-3 text-left">
                            {{ moment.utc(ticket.created_at).format('LLL') }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-3 text-left">
                            {{ moment.utc(ticket.updated_at).format('LLL') }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-3 text-left">
                            {{ ticket.category.title }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-3 text-left">
                            {{ ticket.assignee?.full_name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-3 text-left">
                            <TicketStatus :status="ticket.status"/>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="3" class="whitespace-nowrap px-6 py-3 text-left">
                            No tickets found.
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </template>
        <div v-if="!showPagination" class="flex flex-wrap items-baseline gap-4">
            <VButton transparent :disabled="page === 1" @click="prevPage">Previous</VButton>
            <template v-for="link in links">
                <div class="grow">
                    <VButton @click="changePage(link)"
                             class="rounded-full !py-1 text-sm enabled:bg-primaryLight border-accent border-2">
                        {{ link.label }}
                    </VButton>
                </div>
            </template>
            <VButton transparent :disabled="reachedEnd" @click="nextPage">Next</VButton>
        </div>
    </IndexLayout>
</template>


<script setup lang="ts">
import useSWRV from '@/composables/useSWRV';
import type {TicketModel} from '@/types/model-types';
import {useRoute, useRouter} from 'vue-router';
import VButton from '@/components/VButton.vue';
import IndexLayout from '@/layouts/IndexLayout.vue';
import {computed, ref, watch, ComputedRef, toRaw} from 'vue';
import moment from 'moment';
import TicketStatus from '@/components/TicketStatus.vue';
import VChip from '@/components/VChip.vue';
import type {PaginationResponse, PaginationLink, PaginationMeta} from '@/types/pagination-types';

const router = useRouter();
const route = useRoute();

const page = computed(() => Number(route.query.page ?? 1));

const { data: paginatedTickets } = useSWRV<PaginationResponse<TicketModel>>(() => `/tickets?page=${page.value}`);

const tickets = computed<TicketModel[]>(() => paginatedTickets.value?.data ?? []);
const links = computed<PaginationLink[]>(() => paginatedTickets.value?.links.slice(1, -1) ?? []);
const meta = computed(() => {
    const { data = undefined, links = undefined, ...rest } = toRaw(paginatedTickets);
    return rest;
}) as ComputedRef<PaginationMeta>;

const ticketsPresent = computed(() => tickets.value.length > 0);
const reachedEnd = computed(() => meta.value?.next_page_url === null);
const showPagination = computed(() => meta.value?.last_page === 1);

const nextPage = () => {
    if (!reachedEnd.value) {
        router.push({ name: 'tickets-index', query: { page: page.value + 1 } });
    }
};

const prevPage = () => {
    if (page.value > 1) {
        router.push({ name: 'tickets-index', query: { page: page.value - 1 } });
    }
};

const changePage = (link: PaginationLink) => {
    if (link.url !== null) {
        router.push({ name: 'tickets-index', query: { page: link.label } });
    }
};

</script>
