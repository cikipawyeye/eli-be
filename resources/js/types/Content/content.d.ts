type Content = {
    id?: number;
    subcategory_id: number;
    title: string;
    created_at?: string;
    updated_at?: string;
    subcategory?: Subcategory;
    image_urls?: {
        original: string;
        optimized: string | null;
        responsives: {
            width: number;
            height: number;
            url: string;
        }[];
    };
};
