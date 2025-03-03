<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from '@/components/ui/dropdown-menu';
import { EllipsisVertical, Pencil, Trash } from 'lucide-vue-next';
import type { Client } from '@/types';
import axios from 'axios';
import { ref } from 'vue';

const props = defineProps<{
    client: Client
}>();

const deleting = ref(false);

const deleteUser = async () => {
    const result = confirm('Are you sure want to delete this user?');

    if (!result) return;

    try {
        deleting.value = true;
        await axios.delete(`/api/clients/${props.client.id}`);
        deleting.value = false;
        emit('refresh');
    } catch (e: any) {
        alert(e.response.data.message);
    }
};

const emit = defineEmits(['refresh']);
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="secondary" size="icon">
                <EllipsisVertical xml:lang="w-4 h-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent class="w-56">
            <DropdownMenuItem as-child>
                <Link :href="route('clients.edit', client.id)">
                    <Pencil class="mr-2 h-4 w-4" />
                    <span>Edit user</span>
                </Link>
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem :disabled="deleting" @click.prevent="deleteUser">
                <Trash class="mr-2 h-4 w-4" />
                <span>Delete user</span>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
