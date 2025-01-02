type Payment = {
    id?: number;
    user_id: number;
    payment_method_type:
        | 'VIRTUAL_ACCOUNT'
        | 'OVER_THE_COUNTER'
        | 'QR_CODE'
        | 'EWALLET'
        | null;
    amount: number;
    state: 'SUCCEEDED' | 'FAILED' | 'PENDING';
    created_at?: string;
    user?: {
        name: string;
    };
};
