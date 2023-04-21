<template>
    <VSpacing>
        <VButton @click="router.push({name:'tickets-index'})" class="flex items-center gap-2 self-start">
            <FaArrowLeft/>
            Go back
        </VButton>

        <!--<editor-fold desc="ticket">-->
        <div class="relative flex flex-col gap-4 p-4 bg-primaryLight">
            <header class="flex items-baseline justify-between">
                <h1 class="title">{{ ticket?.user?.full_name }}: {{ ticket?.title }}</h1>
                <TicketStatus class="" :status="ticket?.status"/>
            </header>
            <main class="flex flex-col">

                <form class="my-4 flex flex-col gap-4"
                      v-if="editTicket && editTicket.id === ticket?.id"
                      @submit.prevent="updateTicket">
                        <textarea
                            v-focus
                            ref="updateResponseTextarea"
                            @keydown.ctrl.enter="updateTicket"
                            class="w-full rounded-lg border-2 placeholder:text-xl placeholder:font-bold text-white shadow-lg bg-primaryLight border-accent"
                            v-model="editTicket.content"
                            placeholder="What seems to be the issue?"
                            name="content"
                            id="content"
                            rows="5"/>
                    <VButton type="submit" class="self-start">Update</VButton>
                </form>


                <div v-else class="rounded-lg p-2" :class="{'border-2 border-accent': isOverflowing}">
                    <pre v-text="ticket?.content"
                         ref="ticketPreEl"
                         class="overflow-y-auto py-2 px-3 whitespace-pre-wrap font-sans text-xl leading-loose h-[40vh]"
                    />
                </div>

                <span class="font-medium" v-if="!user?.is_admin">Assigned to: {{ ticket?.assignee.full_name }}</span>
            </main>

            <footer class="flex flex-col gap-2">
                <div class="flex justify-between" v-if="user?.is_admin">
                    <div class="flex flex-col gap-1">
                        <label for="assignee" class="font-medium">Assignee</label>
                        <select class="rounded-lg border-2 font-medium text-white bg-primaryLight border-accent"
                                @change="handleAssigneeChange" name="assignee" id="assignee">
                            <option value="0"
                                    class="font-medium text-white bg-primaryLight">Assign Admin
                            </option>
                            <option v-for="admin in admins as UserModel[]"
                                    class="font-medium text-white bg-primaryLight"
                                    :selected="admin.id === ticket?.assignee.id"
                                    :value="admin.id"
                            >
                                {{ admin.full_name }}
                            </option>
                        </select>
                    </div>
                    <div class="flex items-center gap-4">
                        <VButton @click="resolveTicket"
                                 class="flex items-center gap-2 self-end enabled:hover:text-success enabled:hover:bg-transparent"
                                 v-if="ticket?.status?.title === 'In Progress'">
                            <IoSharpCheckmarkCircle/>
                            Mark as resolved
                        </VButton>

                        <VButton @click="editTicket = {};"
                                 v-if="editTicketForm?.id === ticket?.id && (ticket?.user?.id === user?.id || user?.is_admin)"
                                 class="self-end">
                            Cancel
                        </VButton>
                        <VButton @click="Object.assign(editTicket, ticket)"
                                 v-else
                                 class="self-end flex gap-2 items-center">
                            <FaPen/>
                            Edit
                        </VButton>
                    </div>
                </div>

                <div class="flex justify-between items-baseline">
                    <span>Created: {{
                            moment(ticket?.created_at).fromNow()
                        }} on {{ moment(ticket?.created_at).format('LLLL') }}</span>
                    <VChip>{{ ticket?.category.title }}</VChip>
                    <span v-if="!moment(ticket?.created_at).isSame(ticket?.updated_at, 'minute')">
                    Last update: {{
                            moment(ticket?.updated_at).fromNow()
                        }} on {{ moment(ticket?.updated_at).format('LLLL') }}</span>
                </div>
            </footer>
        </div>
        <!--</editor-fold>-->

        <!--<editor-fold desc="responses">-->
        <div class="flex flex-col gap-8 p-4 bg-primaryLight">
            <h1 class="title">Respond</h1>
            <form class="flex flex-col gap-4" @submit.prevent="submitResponse">
                <label for="content" class="sr-only">Content</label>
                <textarea
                    @keydown.ctrl.enter="submitResponse"
                    class="rounded-lg border-2 placeholder:text-xl placeholder:font-bold text-white shadow-lg bg-primary border-accent"
                    v-model="responseForm.content"
                    placeholder="Your response..."
                    name="content"
                    id="content"
                    rows="5"/>
                <VButton type="submit" class="self-start">Submit</VButton>
            </form>

            <header>
                <h1 class="title">Responses</h1>
            </header>

            <div class="rounded-lg border-2 p-4 shadow-2xl border-accent odd:bg-primary/50 even:bg-primary"
                 v-for="response in responses as ResponseModel[]"
                 :key="response.id">

                <main>
                    <div class="flex items-center justify-between">
                        <h2 class="w-min whitespace-nowrap border-b text-xl font-medium border-accent">
                            {{ response.user?.full_name }}
                        </h2>

                        <VButton @click="editResponse = {};"
                                 v-if="editResponseForm?.id === response.id && (response.user.id === user?.id || user?.is_admin)"
                                 class="flex gap-2 items-center !text-sm">
                            Cancel
                        </VButton>

                        <VButton v-else
                                 @click="Object.assign(editResponse, response)"
                                 class="flex gap-2 items-center !text-sm">
                            <FaPen/>
                            Edit
                        </VButton>
                    </div>
                    <form class="my-4 flex flex-col gap-4"
                          v-if="editResponse && editResponse.id === response.id"
                          @submit.prevent="updateResponse">
                        <textarea
                            v-focus
                            ref="updateResponseTextarea"
                            @keydown.ctrl.enter="updateResponse"
                            class="w-full rounded-lg border-2 placeholder:text-xl placeholder:font-bold text-white shadow-lg bg-primaryLight border-accent"
                            v-model="editResponseForm.content"
                            placeholder="Your response..."
                            name="content"
                            id="content"
                            rows="5"/>
                        <VButton type="submit" class="self-start">Update</VButton>
                    </form>
                    <pre v-else ref="target"
                         v-text="response.content"
                         class="whitespace-pre-wrap py-2 font-sans text-lg leading-relaxed"/>
                </main>

                <footer class="grid grid-cols-3 text-base font-light">
                    <span class="col-start-1">
                        Submitted: {{ moment(response.created_at).fromNow() }}
                        | {{ moment(response.created_at).format('LLLL') }}
                    </span>
                    <span class="col-start-3 place-self-end"
                          v-if="!moment(response.created_at).isSame(response.updated_at, 'minute')">
                        Last update: {{ moment(response.updated_at).fromNow() }}
                        | {{ moment(response.updated_at).format('LLLL') }}
                    </span>
                </footer>
            </div>
        </div>
        <!--</editor-fold>-->
    </VSpacing>
</template>

<script setup lang="ts">
import type {TicketModel, ResponseModel, UserModel, AdminUserModel} from '@/types/model-types';
import useSWRV from '@/composables/useSWRV';
import VSpacing from '@/components/VSpacing.vue';
import TicketStatus from '@/components/TicketStatus.vue';
import moment from 'moment';
import VButton from '@/components/VButton.vue';
import {FaArrowLeft, IoSharpCheckmarkCircle, FaPen} from '@kalimahapps/vue-icons';
import {useRouter} from 'vue-router';
import VChip from '@/components/VChip.vue';
import {reactive, toRaw, toRefs, ref, nextTick, watch} from 'vue';
import type {Ref} from 'vue';
import {useAxios} from '@/plugins/axios';
import {useUserStore} from '@/stores/UserStore';
import {toReactive, useScroll} from '@vueuse/core';
import useOverflow from '@/composables/useOverflow';

const props = defineProps<{ id: string }>();

const router = useRouter();
const axios = useAxios();

const { user } = toRefs(useUserStore());
const ticketPreEl = ref<HTMLElement>();
const isOverflowing = useOverflow(ticketPreEl);

const { data: ticket = ref(null) as Ref<TicketModel | null>, mutate: mutateTicket } =
    useSWRV(`/tickets/${props.id}`);

const { data: responses = ref([]) as Ref<ResponseModel[]>, mutate: mutateResponses } =
    useSWRV(`/tickets/${props.id}/responses`);

const { data: admins = ref([]) as Ref<AdminUserModel[]> } =
    useSWRV(() => user.value?.is_admin ? `/users/admins` : null);

const editResponse = ref<ResponseModel | {}>({});
const editResponseForm = toReactive(editResponse ?? {});
const editTicket = ref<TicketModel | {}>({});
const editTicketForm = toReactive(editTicket ?? {});

const responseForm = reactive({
    content: ''
});

const submitResponse = async () => {
    await axios.simplePost(`/tickets/${props.id}/responses`, toRaw(responseForm));
    responseForm.content = '';
    await mutateResponses();
};

const resolveTicket = async () => {
    if (confirm('Are you sure you want to mark this ticket as resolved?')) {
        await axios.simplePut(`/tickets/${props.id}/resolve`);
        await mutateTicket();
    }
};

const handleAssigneeChange = async (e: Event) => {
    const target = e.target as HTMLSelectElement;
    const selectedAdmin = admins.value.find(admin => admin.id == target.value);

    if (
        selectedAdmin
        && selectedAdmin.id !== ticket.value?.assignee_id
        && confirm(`Are you sure you want to assign this ticket to ${selectedAdmin.full_name}?`)
    ) {
        await axios.simplePut(`/tickets/${props.id}/assign`, { assignee_id: selectedAdmin.id });
        await mutateTicket();
    }
};

const updateResponse = async () => {
    await axios.simplePut(`/tickets/${props.id}/responses/${editResponse.value.id}`, toRaw(editResponseForm));
    editResponse.value = {};
    await mutateResponses();
};

const updateTicket = async () => {
    await axios.simplePut(`/tickets/${props.id}`, toRaw(editTicketForm));
    editTicket.value = {};
    await mutateTicket();
};

</script>

