type ReminderNotification = {
    id?: number;
    title: string;
    message: string;
    is_active: boolean;
    image_url?: string | null;
    image_url_optimized?: string | null;
    created_at?: string;
    updated_at?: string;
};
