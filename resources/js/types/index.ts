import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
}

export interface User {
    id: number;
    username: string;
    avatar?: string;
    created_at: string;
    updated_at: string;
}

export interface Client {
    id: number;
    hash: string;
    address: string;
    username: string;
    status: string;
    created_at: string;
    last_handshake: string;
    expire_at: string;
    download_url: string;
    qr_url: string;
    qr_content: string;
    inbound: number;
    outbound: number;
    is_online: boolean;
}

export type BreadcrumbItemType = BreadcrumbItem;
