type Payment = {
    id?: number;
    user_id: number;
    payment_method_type: string;
    amount: number;
    state: 'SUCCEEDED' | 'FAILED';
    created_at?: string;
    user?: {
        name: string;
    };
};
