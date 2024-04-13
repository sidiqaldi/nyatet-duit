import Type from "@/Enums/TransactionType";
export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface Category{
    id: number;
    type: number;
    name: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        categories: Record<number, Category[]>;
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
