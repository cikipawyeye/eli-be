type XenditPaymentMethodBase = {
    id: string;
    business_id: string;
    customer_id?: string;
    customer?: Record<string, any> | null;
    reference_id: string;
    reusability: 'ONE_TIME_USE' | 'MULTIPLE_USE';
    status:
        | 'ACTIVE'
        | 'REQUIRES_ACTION'
        | 'INACTIVE'
        | 'EXPIRED'
        | 'PENDING'
        | 'FAILED';
    description: string | null;
    metadata: null | Record<string, any>;
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

type XenditPaymentMethod =
    | (XenditPaymentMethodBase & {
          type: 'VIRTUAL_ACCOUNT';
          virtual_account: VirtualAccount;
      })
    | (XenditPaymentMethodBase & {
          type: 'OVER_THE_COUNTER';
          over_the_counter: OverTheCounter;
      })
    | (XenditPaymentMethodBase & {
          type: 'EWALLET';
          ewallet: Ewallet;
      })
    | (XenditPaymentMethodBase & {
          type: 'QR_CODE';
          qr_code: QRCode;
      });

type Ewallet = {
    account: {
        name: string;
        balance: number | null;
        point_balance: number | null;
        account_details: string;
    };
    channel_code: 'OVO' | 'DANA' | 'LINKAJA';
    channel_properties: {
        failure_return_url?: string;
        success_return_url?: string;
        mobile_number?: string;
    };
};

type OverTheCounter = {
    amount: number;
    currency: 'IDR';
    channel_code: 'ALFAMART' | 'INDOMARET';
    channel_properties: {
        payment_code: string;
        customer_name: string;
        expires_at: string;
    };
};

type QRCode = {
    amount: number;
    channel_code: 'DANA' | 'LINKAJA';
    channel_properties: {
        expires_at: string;
        qr_string: string;
    };
    currency: 'IDR';
};

type VirtualAccount = {
    amount: number;
    channel_code: string;
    channel_properties: {
        customer_name: string;
        expires_at: string;
        virtual_account_number: string;
    };
    currency: 'IDR';
};
