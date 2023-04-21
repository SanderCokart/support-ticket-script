//laravel pagination types
export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface PaginationResponse<MODEL> extends PaginationMeta {
    data: MODEL[];
    links: PaginationLink[];
}

export interface PaginationMeta {
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string | null;
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}
