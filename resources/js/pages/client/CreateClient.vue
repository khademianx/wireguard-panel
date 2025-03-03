<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { cn } from '@/lib/utils';
import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { DateFormatter, DateValue, getLocalTimeZone } from '@internationalized/date';
import { Calendar as CalendarIcon } from 'lucide-vue-next';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import type { BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create client',
        href: '/client/create'
    }
];

const df = new DateFormatter('en-US', {
    dateStyle: 'long'
});

const hasExpire = ref(false);
const date = ref<DateValue>();

const form = useForm({
    username: '',
    expire_at: null
});

const submit = () => {
    form.expire_at = date.value?.toString();

    form.post(route('clients.store'), {
        preserveScroll: true
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-screen-md mx-auto my-5 md:my-12">
            <Card>
                <CardHeader>
                    <CardTitle>Add new user</CardTitle>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit">
                        <input type="submit" class="hidden" />
                        <div class="grid gap-4 py-4 space-y-5">
                            <div class="grid grid-cols-4 items-center gap-4">
                                <Label for="username" class="text-right">
                                    Username
                                </Label>
                                <Input id="username" class="col-span-3" v-model="form.username"
                                       placeholder="test-user" />
                                <InputError class="col-span-3 col-start-2" :message="form.errors.username" />
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <div class="flex items-center space-x-2 col-start-2">
                                    <Switch id="has-expire" v-model="hasExpire" />
                                    <Label for="has-expire">Expire date?</Label>
                                </div>
                            </div>
                            <div v-if="hasExpire" class="grid grid-cols-4 items-center gap-4">
                                <Label for="expire_at" class="text-right">
                                    Expire at
                                </Label>
                                <div class="col-span-3">
                                    <Popover class="z-50">
                                        <PopoverTrigger as-child>
                                            <Button
                                                variant="outline"
                                                :class="cn(
                                          'w-[280px] justify-start text-left font-normal',
                                          !date && 'text-muted-foreground',
                                        )"
                                            >
                                                <CalendarIcon class="mr-2 h-4 w-4" />
                                                {{
                                                    date ? df.format(date.toDate(getLocalTimeZone())) : 'Pick a date'
                                                }}
                                            </Button>
                                        </PopoverTrigger>
                                        <PopoverContent class="w-auto p-0">
                                            <Calendar v-model="date" />
                                        </PopoverContent>
                                    </Popover>
                                    <InputError class="col-span-3 col-start-2" :message="form.errors.expire_at" />
                                </div>
                            </div>
                        </div>
                    </form>
                </CardContent>
                <CardFooter>
                    <Button :disabled="form.processing" @click="submit">Add user</Button>
                    <Button class="ml-2" as-child variant="secondary">
                        <Link :href="route('dashboard')">Cancel</Link>
                    </Button>
                </CardFooter>
            </Card>
        </div>
    </AppLayout>
</template>
