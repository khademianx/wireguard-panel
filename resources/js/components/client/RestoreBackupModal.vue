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
import { History } from 'lucide-vue-next';
import InputError from '@/components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const isOpen = ref();

const form = useForm({ file: '' });

const submit = async () => {
    try {
        await form.post(route('backup.import'));
        isOpen.value = false;
    } catch (err: any) {
        alert(err.response.data.message);
    }
};
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogTrigger as-child>
            <Button variant="outline">
                <History class="w-4 h-4 hidden md:inline-block" />
                Restore
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Restore Backup</DialogTitle>
                <DialogDescription>
                    Select json backup file to import.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <Label for="file" class="text-right">
                        Backup file
                    </Label>
                    <Input type="file" @input="form.file = $event.target.files[0]" class="col-span-3" />
                    <InputError class="col-span-3 col-start-2" :message="form.errors.file" />
                </div>
            </div>
            <DialogFooter>
                <Button :disabled="form.processing" @click="submit" type="submit">
                    Restore backup
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
