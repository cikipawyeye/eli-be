type User = {
    id?: number;
    name: string;
    email: string;
    email_verified_at?: string | null;
    is_premium?: boolean;
    birth_date?: string;
    job_type?: '0' | '1' | '2' | '3' | '4' | '5' | '6' | '7' | '8';
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
