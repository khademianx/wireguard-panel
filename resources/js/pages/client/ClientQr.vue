<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import vueQr from 'vue-qr/src/packages/vue-qr.vue';
import type { Client } from '@/types';
import AuthLayout from '@/layouts/AuthLayout.vue';
import moment from 'moment';

defineProps<{
    client: Client,
    qr_content: string
}>();
</script>

<template>
    <Head title="User information" />

    <AuthLayout :title="client.username">
        <div>
            <p class="text-neutral-300 text-center mb-4" v-if="client.expire_at">
                Expire: <span class="text-primary font-bold">{{ moment(client.expire_at).fromNow() }}</span>
            </p>
            <p class="text-neutral-300 text-center">
                Scan QR Code with wireguard application or download from link below.
            </p>

            <div class="mt-5 text-center">
                <a :href="route('download', client.hash)"
                   class="bg-sky-500 text-white px-4 py-1.5 rounded-lg transition hover:bg-sky-600">
                    Download
                </a>
            </div>

            <div class="mt-12 text-center">
                <vueQr :text="qr_content" />
            </div>

            <div class="mt-12 text-center py-5 border-t border-neutral-700">
                Download application
            </div>

            <div class="mt-5 text-center grid grid-cols-2 md:grid-cols-2 gap-5">
                <a href="https://play.google.com/store/apps/details?id=com.wireguard.android"
                   class="bg-teal-500 text-white px-4 py-1.5 rounded-lg transition hover:bg-teal-600">
                    Android
                </a>

                <a href="https://itunes.apple.com/us/app/wireguard/id1441195209?ls=1&mt=8"
                   class="bg-teal-500 text-white px-4 py-1.5 rounded-lg transition hover:bg-teal-600">
                    iOS
                </a>

                <a href="https://itunes.apple.com/us/app/wireguard/id1451685025?ls=1&mt=12"
                   class="bg-teal-500 text-white px-4 py-1.5 rounded-lg transition hover:bg-teal-600">
                    macOS
                </a>

                <a href="https://download.wireguard.com/windows-client/wireguard-installer.exe"
                   class="bg-teal-500 text-white px-4 py-1.5 rounded-lg transition hover:bg-teal-600">
                    windows
                </a>
            </div>
        </div>
    </AuthLayout>
</template>
