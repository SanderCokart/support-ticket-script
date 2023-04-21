export interface UserModel {
    created_at: string;
    email: string;
    first_name: string;
    id: number;
    is_admin?: boolean;
    last_name: string;
    full_name: string;
    telephonenumber: string;
    updated_at: string;
}

export type AdminUserModel = Pick<UserModel, 'full_name' | 'first_name' | 'id' | 'last_name'>

export interface CategoryModel {
    id: number;
    title: string;
}

export type StatusModel = PendingStatus | InProgressStatus | ResolvedStatus;

export interface PendingStatus {
    id: 1;
    title: 'Pending';
}

export interface InProgressStatus {
    id: 2;
    title: 'In Progress';
}

export interface ResolvedStatus {
    id: 3;
    title: 'Resolved';
}

export interface ResponseModel {
    id: number;
    content: string;
    created_at: string;
    updated_at: string;
    user_id: number;
    user: UserModel;
    ticket_id: number;
}

export interface TicketModel {
    category_id: number;
    category: CategoryModel;
    content: string;
    created_at: string;
    id: number;
    status_id: number;
    status: StatusModel;
    title: string;
    updated_at: string;
    user_id: number;
    user?: UserModel;
    assignee_id: number;
    assignee: AdminUserModel;
}
