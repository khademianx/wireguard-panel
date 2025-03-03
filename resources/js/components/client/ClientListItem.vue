<script setup lang="ts">
import axios from 'axios';
import { filesize } from 'filesize';
import { ArrowDown, ArrowUp, Download, Link, Trash, Check } from 'lucide-vue-next';
import { ref } from 'vue';
import { useClipboard } from '@vueuse/core';
import { Badge } from '@/components/ui/badge/index.js';
import { Button } from '@/components/ui/button/index.js';
import { type Client } from '@/types';
import ClientQrModal from '@/components/client/ClientQrModal.vue';

const props = defineProps<{
    client: Client
}>();

const { copy, copied } = useClipboard({ legacy: true });

const loading = ref(false);

const deleteUser = async () => {
    const result = confirm('Are you sure want to delete this user?');

    if (!result) return;

    try {
        loading.value = true;
        await axios.delete(`/api/clients/${props.client.id}`);
        loading.value = false;
        emit('refresh');
    } catch (e: any) {
        alert(e.response.data.message);
    }
};

const copyLink = () => {
    copy(props.client.download_url ?? 'no link');
};

const emit = defineEmits(['refresh']);
</script>

<template>
    <div
        class="grid grid-cols-3 md:grid-cols-6 items-center gap-1 md:gap-5 px-3 md:px-5 py-2 transition hover:bg-muted"
    >
        <div>
            <div class="flex items-center">
                <div
                    :class="{ '!bg-green-500': client.is_online }"
                    class="inline-block w-2 h-2 rounded-full bg-neutral-500 mr-2"
                ></div>
                <div class="font-bold">{{ client.username }}</div>
            </div>
            <div class="text-sm text-muted-foreground hidden md:block" v-if="client.expire_at">
                expire {{ client.expire_at }}
            </div>
        </div>
        <div class="text-sm text-muted-foreground col-span-full md:hidden py-1" v-if="client.expire_at">
            expire {{ client.expire_at }}
        </div>
        <div v-else class="col-span-full md:hidden"></div>
        <div class="flex items-center ltr">
            <ArrowDown class="w-4 h-4 text-teal-500" />
            <span class="ml-1 font-mono text-xs md:text-sm">
                {{ filesize(client.inbound) }}
            </span>
        </div>
        <div class="flex items-center ltr">
            <ArrowUp class="w-4 h-4 text-sky-500" />
            <span class="ml-1 font-mono text-xs md:text-sm">
                {{ filesize(client.outbound) }}
            </span>
        </div>
        <div class="text-center">
            <Badge variant="success" v-if="client.status === 'enable'">Active</Badge>
            <Badge variant="destructive" v-else>Inactive</Badge>
        </div>
        <div class="hidden md:block text-neutral-400 text-sm">
            <div class="truncate">
                {{ client.last_handshake ? 'connected ' + client.last_handshake : '...' }}
            </div>
        </div>
        <div class="col-span-full md:col-span-1 flex items-center ltr space-x-2">
            <Button :disabled="loading" @click="deleteUser" title="Delete user" variant="destructive" size="icon">
                <Trash class="w-5 h-5" />
            </Button>
            <Button as-child :disabled="loading" title="Download Config" variant="secondary" size="icon">
                <a :href="client.download_url">
                    <Download class="w-5 h-5" />
                </a>
            </Button>
            <Button :disabled="loading" @click="copyLink" title="Copy user link" variant="secondary"
                    size="icon">
                <Check v-if="copied" class="w-5 h-5 text-green-500" />
                <Link v-else class="w-5 h-5" />
            </Button>
            <ClientQrModal :qr-content="client.qr_content" />
        </div>
    </div>
</template>
