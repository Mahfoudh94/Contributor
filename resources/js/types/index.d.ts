import { Config } from 'ziggy-js';
import type { User } from '@/types/model'

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
    flash: {
        message?: string;
        warning?: string;
        success?: string;
        error?: string;
    };
};
