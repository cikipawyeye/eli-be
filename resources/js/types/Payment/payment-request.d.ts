type XenditPaymentRequest = {
    id: string;
    reference_id: string;
    business_id: string;
    customer_id: string | null;
    customer: any | null;
    amount: number;
    min_amount: number | null;
    max_amount: number | null;
    country: string;
    currency: 'IDR';
    payment_method: XenditPaymentMethod;
    description: string | null;
    failure_code: string | null;
    capture_method: 'AUTOMATIC' | 'MANUAL';
    initiator: any | null;
    card_verification_results: any | null;
    status:
        | 'REQUIRES_ACTION'
        | 'PENDING'
        | 'SUCCEEDED'
        | 'FAILED'
        | 'AWAITING_CAPTURE';
    metadata: any | null;
    shipping_information: null;
    items: null;
    created: string;
    updated: string;
    actions:
        | {
              method: 'GET' | 'POST';
              url_type: 'API' | 'WEB' | 'MOBILE' | 'DEEPLINK';
              action: 'AUTH' | 'RESEND_AUTH';
              url: string;
          }[]
        | null;
};
