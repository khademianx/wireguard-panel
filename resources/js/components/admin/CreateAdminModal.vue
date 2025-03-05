<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { ref } from 'vue';

const isOpen = ref();

const form = useForm({
    username: '',
    password: ''
});

const submit = async () => {
    try {
        await form.post(route('admins.store'));
        isOpen.value = false;
    } catch (err: any) {
        throw err;
    }
};
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogTrigger as-child>
            <Button>
                New admin
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>New admin</DialogTitle>
            </DialogHeader>
            <form @submit.prevent="submit" id="form">
                <input type="submit" class="hidden" />
                <div class="grid gap-4 py-4">
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="username" class="text-right">
                            Name
                        </Label>
                        <Input id="username" v-model="form.username" placeholder="username" class="col-span-3" />
                        <InputError class="col-start-2 col-span-3" :message="form.errors.username" />
                    </div>
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="password" class="text-right">
                            Password
                        </Label>
                        <Input v-model="form.password" id="password" type="password" class="col-span-3" />
                        <InputError class="col-start-2 col-span-3" :message="form.errors.password" />
                    </div>
                </div>
            </form>
            <DialogFooter>
                <Button :disabled="form.processing" @click="submit" for="form" type="submit">
                    Add
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
