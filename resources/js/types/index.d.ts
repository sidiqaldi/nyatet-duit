import Type from "@/Enums/TransactionType";
export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    currency: string;
    locale: string;
    timezone: string;
}

export interface Category {
    id: number;
    user_id: number;
    name: string;
    type: number;
    created_at: string;
    updated_at: string;
}
export interface TransactionModel {
    id: number;
    user_id: number;
    category_id: [null, number];
    category: string;
    type: string;
    type_id: number;
    amount: number;
    date: string;
    description: string;
    created_at: string;
    updated_at: string;
}

export interface CategoryData {
    [type: number]: Category[];
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        categories: CategoryData;
    };
};

export interface Meta{
    current_page: number;
    from?: number;
    last_page: number;
    links: Array;
    path: string;
    per_page: number;
    to?: number;
    total: number;
}

export interface TransactionCollection {
    data: Array;
    meta: Meta;
    links: Object;
}
