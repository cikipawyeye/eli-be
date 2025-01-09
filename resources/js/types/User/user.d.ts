type User = {
    id?: number;
    name: string;
    email: string;
    email_verified_at?: string | null;
    is_premium?: boolean;
    birth_date?: string;
    job?: string;
    city_code?: string;
    city?: {
        name: string;
        code: string;
    };
    created_at?: string;
    updated_at?: string;
    permissions_by_roles?: string[];
};
