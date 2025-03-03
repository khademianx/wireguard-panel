<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Client } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, Ref } from 'vue';
import { Loader2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import ClientListItem from '@/components/client/ClientListItem.vue';
import { Card, CardHeader, CardTitle } from '@/components/ui/card';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard'
    }
];

const clients: Ref<Client[] | undefined> = ref();
const loading = ref(false);

const getClients = async () => {
    try {
        loading.value = true;
        const { data } = await axios.get('api/clients');
        clients.value = data.data;
        loading.value = false;
    } catch (err: any) {
        loading.value = false;
        throw err;
    }
};

getClients();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="loading" class="flex h-full flex-1 flex-col gap-4 justify-center items-center rounded-xl p-4">
            <Loader2 class="w-8 h-8 animate-spin" />
        </div>
        <div v-else class="p-4">
            <Card>
                <CardHeader class="border-b">
                    <div class="flex items-center justify-between">
                        <CardTitle>Users</CardTitle>
                        <Button as-child>
                            <Link :href="route('client.create')">New User</Link>
                        </Button>
                    </div>
                </CardHeader>
                <div>
                    <div class="divide-y">
                        <ClientListItem :client="client" v-for="client in clients" :key="client?.id" />
                    </div>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>
