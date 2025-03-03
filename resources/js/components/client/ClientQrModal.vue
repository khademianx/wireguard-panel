<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/components/ui/dialog';
import { QrCode } from 'lucide-vue-next';
import vueQr from 'vue-qr/src/packages/vue-qr.vue';

defineProps({
    qrContent: {
        required: true
    }
});
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button size="icon" variant="outline">
                <QrCode class="w-5 h-5" />
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Wireguard QR Code</DialogTitle>
                <DialogDescription>
                    Scan this code with wireguard application.
                </DialogDescription>
            </DialogHeader>
            <div class="py-4 text-center">
                <vueQr :text="qrContent" />
            </div>
        </DialogContent>
    </Dialog>
</template>
