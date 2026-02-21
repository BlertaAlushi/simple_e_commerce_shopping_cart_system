import { InertiaLinkProps } from '@inertiajs/vue3';
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
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
    badge?: string | number;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    admin:boolean;
}

export interface Product {
    id: number;
    name: string;
    slug:string;
    description:string;
    price: number;
    currency: string;
    stock_quantity: number;
    mark:string;
}

export interface CartProduct {
    id: number;
    cart_id: number;
    product_id: number;
    quantity: number;
    created_at: string;
    updated_at: string;
    product: Product;
}

export interface UserCart {
    id: number;
    user_id: number;
    is_ordered: number;
    ordered_at: string;
    created_at: string;
    updated_at: string;
    total_price: number | string;
    products: CartProduct[];
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface Filters {
    skin_types: number[];
    skin_concerns: number[];
    product_types: number[];
    extras: number[];
}

export interface MenuItem {
    id:number
    slug: string;
    name: string;
}

export interface Language {
    id:number
    code: string;
    language: string;
}

export interface MenuType {
    bodyParts: MenuData;
    productTypes: MenuData;
    skinTypes: MenuData;
    skinConcerns: MenuData;
    extras: MenuData;
    marks: MenuData;
}

interface MenuData{
    data:MenuItem[]
}

export interface PageType extends AppPageProps{
    menu: MenuType;
    languages: Language[];
}

export interface Item{
    id:number;
    slug:string
    name:string;
    translations:Translation[];
}

export interface Translation{
    language_id:number,
    name:string,
}
export interface Mark {
    id: number;
    slug: string;
    name: string;
}

export type ProductType{

}
