import { PageProps } from './types';

declare global {
    interface SharedProps extends PageProps {
        locale: string;
        flash: {
            success?: string;
            error?: string;
        };
    }
}
