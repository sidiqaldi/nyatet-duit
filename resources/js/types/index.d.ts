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

export interface ListCategory {
    [Type.Expense] : Category[];
    [Type.Income] : Category[];
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        categories: ListCategory;
    };
};

export interface TransactionCollection {
    data: Array;
    meta?: Object;
    links?: Object;
}
