<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, User } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Plus, Trash } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Card } from '@/components/ui/card';
import CreateAdminModal from '@/components/admin/CreateAdminModal.vue';

defineProps<{
    admins: User[]
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admins',
        href: '/admins'
    }
];

const destroy = async (admin: User) => {
    const result = confirm('Are you sure want to delete this admin?');

    if (!result) {
        return;
    }

    try {
        const form = useForm({});
        await form.delete(route('admins.destroy', admin.id));
    } catch (err: any) {
        alert(err?.response.data?.message || 'Something went wrong.');
    }
};
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div>
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold text-primary">Admins</div>
                    <CreateAdminModal />
                </div>
            </div>
            <Card class="mt-5">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>
                                Username
                            </TableHead>
                            <TableHead>Created at</TableHead>
                            <TableHead></TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="admin in admins" :key="admin.id">
                            <TableCell class="font-medium">
                                {{ admin.username }}
                            </TableCell>
                            <TableCell>{{ new Date(admin.created_at).toLocaleDateString() }}</TableCell>
                            <TableCell class="text-right">
                                <Button @click="destroy(admin)" size="icon" variant="destructive">
                                    <Trash class="w-4 h-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </Card>
        </div>
    </AppLayout>
</template>
