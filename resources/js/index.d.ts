type ResponseData<T = any> = {
    data?: T;
    message?: string;
};

type Link = {
    url: string | null;
    label: string;
    active: boolean;
};

interface PaginatedResponseData<T = any> extends ResponseData {
    data: T[];
    links: Link[];
    meta: {
        current_page: number;
        first_page_url: string;
        from: number | null;
        last_page: number;
        last_page_url: string;
        next_page_url: string | null;
        path: string;
        per_page: number;
        prev_page_url: string | null;
        to: number | null;
        total: number;
    };
}

interface CursorPaginatedResponseData<T = any> extends ResponseData {
    data: T[];
    meta: {
        path: string;
        per_page: number;
        next_cursor: string | null;
        prev_cursor: string | null;
        next_page_url: string | null;
        prev_page_url: string | null;
    };
}
