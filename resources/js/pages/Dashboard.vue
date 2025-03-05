<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Client } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { onUnmounted, ref, Ref } from 'vue';
import { ArrowLeft, ArrowRight, Loader2, Plus, Copy } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import ClientListItem from '@/components/client/ClientListItem.vue';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import RestoreBackupModal from '@/components/client/RestoreBackupModal.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard'
    }
];

const clients: Ref<Client[] | undefined> = ref();
const loading = ref(false);
const searching = ref(false);
const q = ref();
const links = ref();
const meta = ref();

let timeout = null;

const getClients = async (url = '/api/clients', spinner = true) => {
    try {
        if (spinner) {
            loading.value = true;
        }

        if (timeout) {
            clearTimeout(timeout);
        }

        const { data } = await axios.get(url);
        clients.value = data.data;
        links.value = data.links;
        meta.value = data.meta;
        loading.value = false;

        timeout = setTimeout(() => getClients(url, false), 1000);
    } catch (err: any) {
        if (timeout) {
            clearTimeout(timeout);
        }
        loading.value = false;
        throw err;
    }
};

const search = async () => {
    if (!q.value) {
        return getClients();
    }

    const url = '/api/clients?q=' + q.value;

    try {
        if (timeout) {
            clearTimeout(timeout);
        }
        searching.value = true;
        await getClients(url);
        searching.value = false;
    } catch (e: any) {
        searching.value = false;
        alert(e?.response?.data?.message ?? 'Unknown Error!');
    }
};

getClients();

onUnmounted(() => {
    if (timeout) {
        clearTimeout(timeout);
    }
});
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="loading" class="flex h-full flex-1 flex-col gap-4 justify-center items-center rounded-xl p-4">
            <Loader2 class="w-8 h-8 animate-spin" />
        </div>
        <div v-else class="p-4">
            <div>
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-2xl font-bold text-primary">Users</div>
                    <div class="flex items-center space-x-2 mt-3 md:mt-0">
                        <Button as-child>
                            <Link :href="route('clients.create')">
                                <Plus class="w-4 h-4 hidden md:inline-block" />
                                New user
                            </Link>
                        </Button>
                        <Button variant="outline" as-child>
                            <a title="create backup" :href="route('backup.create')">
                                <Copy class="w-4 h-4 hidden md:inline-block" />
                                Backup
                            </a>
                        </Button>
                        <RestoreBackupModal />
                    </div>
                </div>
            </div>
            <div class="my-4">
                <form @submit.prevent="search">
                    <input type="submit" class="hidden" />
                    <Input v-model="q" class="max-w-sm" placeholder="Search users..." />
                </form>
            </div>
            <Card>
                <div>
                    <div class="divide-y">
                        <ClientListItem @refresh="getClients" :client="client" v-for="client in clients"
                                        :key="client?.id" />
                    </div>
                </div>
            </Card>
            <div class="my-2 text-sm text-muted-foreground" v-if="clients?.length > 0">
                show {{ clients?.length }} of {{ meta.total }} users
            </div>
            <div class="flex items-center mt-5">
                <Button
                    variant="outline"
                    @click="getClients(links?.prev)"
                    v-if="links && links.prev"
                    class="mr-2"
                >
                    <ArrowLeft class="w-4 h-4 mr-1" />
                    <span>Prev</span>
                </Button>
                <Button
                    variant="outline"
                    @click="getClients(links?.next)"
                    v-if="links && links.next"
                >
                    <span>Next</span>
                    <ArrowRight class="w-4 h-4 mr-1" />
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
