<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMenuGroups(): array
    {
        $user = auth()->user();
        $isSuperAdmin = $user && $user->isSuperAdmin();

        // Build the Management group items dynamically based on role/permissions
        $managementItems = [];

        // User Management submenu — shown to superadmin OR anyone with user-related permissions
        if ($isSuperAdmin || ($user && $user->hasAnyPermission([
            'consult_user_list', 'create_user', 'edit_user', 'delete_user',
            'activate_user', 'deactivate_user',
        ]))) {
            $userSubItems = [];

            if ($isSuperAdmin || $user->hasPermissionTo('consult_user_list')) {
                $userSubItems[] = ['name' => 'All Users', 'path' => '/users'];
            }
            if ($isSuperAdmin || $user->hasPermissionTo('create_user')) {
                $userSubItems[] = ['name' => 'Add User', 'path' => '/users/create'];
            }
            // Admin Management is superadmin-only
            if ($isSuperAdmin) {
                $userSubItems[] = ['name' => 'Admin Management', 'path' => '/admin-management'];
            }

            if (!empty($userSubItems)) {
                $managementItems[] = [
                    'icon'     => 'users-manage',
                    'name'     => 'User Management',
                    'subItems' => $userSubItems,
                ];
            }
        }

        // Role Management — superadmin OR consult_roles_list permission
        if ($isSuperAdmin || ($user && $user->hasAnyPermission([
            'consult_roles_list', 'create_role', 'edit_role', 'delete_role',
        ]))) {
            $roleSubItems = [['name' => 'All Roles', 'path' => '/roles']];
            if ($isSuperAdmin || $user->hasPermissionTo('create_role')) {
                $roleSubItems[] = ['name' => 'Create Role', 'path' => '/roles/create'];
            }
            $managementItems[] = [
                'icon'     => 'shield',
                'name'     => 'Role Management',
                'subItems' => $roleSubItems,
            ];
        }

        // Audit Logs — superadmin OR consult_logs permission
        if ($isSuperAdmin || ($user && $user->hasPermissionTo('consult_logs'))) {
            $managementItems[] = [
                'icon' => 'audit-log',
                'name' => 'Audit Logs',
                'path' => '/audit-logs',
            ];
        }

        $groups = [
            // ── MAIN ──────────────────────────────────────────────────────────
            [
                'title' => 'Main',
                'items' => [
                    [
                        'icon' => 'grid',
                        'name' => 'Dashboard',
                        'path' => '/',
                    ],
                    [
                        'icon' => 'user-circle',
                        'name' => 'My Profile',
                        'path' => '/profile',
                    ],
                ],
            ],
        ];

        // Only add Management group if there's anything to show
        if (!empty($managementItems)) {
            $groups[] = [
                'title' => 'Management',
                'items' => $managementItems,
            ];
        }

        return $groups;
    }

    public static function getIconSvg(string $icon): string
    {
        $icons = [
            'grid' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.5 3.75C2.5 3.05964 3.05964 2.5 3.75 2.5H7.91667C8.60702 2.5 9.16667 3.05964 9.16667 3.75V7.91667C9.16667 8.60702 8.60702 9.16667 7.91667 9.16667H3.75C3.05964 9.16667 2.5 8.60702 2.5 7.91667V3.75ZM10.8333 3.75C10.8333 3.05964 11.393 2.5 12.0833 2.5H16.25C16.9404 2.5 17.5 3.05964 17.5 3.75V7.91667C17.5 8.60702 16.9404 9.16667 16.25 9.16667H12.0833C11.393 9.16667 10.8333 8.60702 10.8333 7.91667V3.75ZM2.5 12.0833C2.5 11.393 3.05964 10.8333 3.75 10.8333H7.91667C8.60702 10.8333 9.16667 11.393 9.16667 12.0833V16.25C9.16667 16.9404 8.60702 17.5 7.91667 17.5H3.75C3.05964 17.5 2.5 16.9404 2.5 16.25V12.0833ZM10.8333 12.0833C10.8333 11.393 11.393 10.8333 12.0833 10.8333H16.25C16.9404 10.8333 17.5 11.393 17.5 12.0833V16.25C17.5 16.9404 16.9404 17.5 16.25 17.5H12.0833C11.393 17.5 10.8333 16.9404 10.8333 16.25V12.0833Z"/></svg>',
            'user-circle' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 1.66667C5.39763 1.66667 1.66667 5.39763 1.66667 10C1.66667 14.6024 5.39763 18.3333 10 18.3333C14.6024 18.3333 18.3333 14.6024 18.3333 10C18.3333 5.39763 14.6024 1.66667 10 1.66667ZM7.5 8.33333C7.5 6.9526 8.61929 5.83333 10 5.83333C11.3807 5.83333 12.5 6.9526 12.5 8.33333C12.5 9.71405 11.3807 10.8333 10 10.8333C8.61929 10.8333 7.5 9.71405 7.5 8.33333ZM5.27259 14.2226C5.92452 12.9359 7.35341 12.0833 10 12.0833C12.6466 12.0833 14.0755 12.9359 14.7274 14.2226C13.4088 15.6156 11.8051 16.25 10 16.25C8.19493 16.25 6.59117 15.6156 5.27259 14.2226Z"/></svg>',
            'users-manage' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>',
            'shield' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 1.66667L3.33333 4.16667V9.16667C3.33333 13.0833 6.16667 16.75 10 17.5C13.8333 16.75 16.6667 13.0833 16.6667 9.16667V4.16667L10 1.66667ZM13.0893 8.08926C13.4147 7.76382 13.4147 7.23618 13.0893 6.91074C12.7638 6.58531 12.2362 6.58531 11.9107 6.91074L9.16667 9.65482L8.08926 8.57741C7.76382 8.25198 7.23618 8.25198 6.91074 8.57741C6.58531 8.90285 6.58531 9.43049 6.91074 9.75592L8.57741 11.4226C8.90285 11.748 9.43049 11.748 9.75592 11.4226L13.0893 8.08926Z"/></svg>',
            'audit-log' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 1.66667C7.5 1.20643 7.8731 0.833333 8.33333 0.833333H11.6667C12.1269 0.833333 12.5 1.20643 12.5 1.66667C12.5 2.1269 12.1269 2.5 11.6667 2.5H8.33333C7.8731 2.5 7.5 2.1269 7.5 1.66667ZM4.16667 2.5C3.24619 2.5 2.5 3.24619 2.5 4.16667V16.6667C2.5 17.5871 3.24619 18.3333 4.16667 18.3333H15.8333C16.7538 18.3333 17.5 17.5871 17.5 16.6667V4.16667C17.5 3.24619 16.7538 2.5 15.8333 2.5H14.1667C14.1667 3.42048 13.4205 4.16667 12.5 4.16667H7.5C6.57952 4.16667 5.83333 3.42048 5.83333 2.5H4.16667ZM13.0893 8.42259C13.4147 8.09715 13.4147 7.56951 13.0893 7.24408C12.7638 6.91864 12.2362 6.91864 11.9107 7.24408L9.16667 9.98816L8.08926 8.91074C7.76382 8.58531 7.23618 8.58531 6.91074 8.91074C6.58531 9.23618 6.58531 9.76382 6.91074 10.0893L8.57741 11.7559C8.90285 12.0814 9.43049 12.0814 9.75592 11.7559L13.0893 8.42259Z"/></svg>',
            'chat' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 1.66667C5.39763 1.66667 1.66667 5.11896 1.66667 9.37499C1.66667 11.2637 2.44305 12.9845 3.71718 14.2833L2.74408 17.2022C2.61524 17.5974 2.99097 17.9731 3.38614 17.8443L6.82701 16.7119C7.82286 17.0785 8.89184 17.2739 10 17.2739C14.6024 17.2739 18.3333 13.831 18.3333 9.37499C18.3333 5.11896 14.6024 1.66667 10 1.66667ZM6.66667 9.16667C6.20643 9.16667 5.83333 9.53976 5.83333 10C5.83333 10.4602 6.20643 10.8333 6.66667 10.8333C7.1269 10.8333 7.5 10.4602 7.5 10C7.5 9.53976 7.1269 9.16667 6.66667 9.16667ZM9.16667 10C9.16667 9.53976 9.53976 9.16667 10 9.16667C10.4602 9.16667 10.8333 9.53976 10.8333 10C10.8333 10.4602 10.4602 10.8333 10 10.8333C9.53976 10.8333 9.16667 10.4602 9.16667 10ZM13.3333 9.16667C12.8731 9.16667 12.5 9.53976 12.5 10C12.5 10.4602 12.8731 10.8333 13.3333 10.8333C13.7936 10.8333 14.1667 10.4602 14.1667 10C14.1667 9.53976 13.7936 9.16667 13.3333 9.16667Z"/></svg>',
            'ticket' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.66667 5.83333C1.66667 4.91286 2.41286 4.16667 3.33333 4.16667H16.6667C17.5871 4.16667 18.3333 4.91286 18.3333 5.83333V8.33333C17.4129 8.33333 16.6667 9.07952 16.6667 10C16.6667 10.9205 17.4129 11.6667 18.3333 11.6667V14.1667C18.3333 15.0871 17.5871 15.8333 16.6667 15.8333H3.33333C2.41286 15.8333 1.66667 15.0871 1.66667 14.1667V11.6667C2.58714 11.6667 3.33333 10.9205 3.33333 10C3.33333 9.07952 2.58714 8.33333 1.66667 8.33333V5.83333Z"/></svg>',
            'mail' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 4.16667C1.57952 4.16667 0.833332 4.91286 0.833332 5.83333V14.1667C0.833332 15.0871 1.57952 15.8333 2.5 15.8333H17.5C18.4205 15.8333 19.1667 15.0871 19.1667 14.1667V5.83333C19.1667 4.91286 18.4205 4.16667 17.5 4.16667H2.5ZM4.02369 5.83333H15.9763L10 9.61806L4.02369 5.83333ZM2.5 7.21528L9.54167 11.6181C9.82 11.7917 10.18 11.7917 10.4583 11.6181L17.5 7.21528V14.1667H2.5V7.21528Z"/></svg>',
            'chart-bar' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.66667 15.8333C1.66667 16.2936 2.03976 16.6667 2.5 16.6667H17.5C17.9602 16.6667 18.3333 16.2936 18.3333 15.8333C18.3333 15.3731 17.9602 15 17.5 15H16.6667V8.33333C16.6667 7.8731 16.2936 7.5 15.8333 7.5H13.3333C12.8731 7.5 12.5 7.8731 12.5 8.33333V15H10.8333V5C10.8333 4.53976 10.4602 4.16667 10 4.16667H7.5C7.03976 4.16667 6.66667 4.53976 6.66667 5V15H5V10C5 9.53976 4.6269 9.16667 4.16667 9.16667H2.5C2.03976 9.16667 1.66667 9.53976 1.66667 10V15H1.66667V15.8333Z"/></svg>',
            'component' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 1.66667L13.3333 7.5H6.66667L10 1.66667ZM2.91667 10.4167C2.91667 8.57578 4.40905 7.08333 6.25 7.08333C8.09095 7.08333 9.58333 8.57578 9.58333 10.4167C9.58333 12.2576 8.09095 13.75 6.25 13.75C4.40905 13.75 2.91667 12.2576 2.91667 10.4167ZM11.25 9.16667H18.3333V17.0833H11.25V9.16667Z"/></svg>',
            'user' => '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 2.5C8.15905 2.5 6.66667 3.99238 6.66667 5.83333C6.66667 7.67428 8.15905 9.16667 10 9.16667C11.8409 9.16667 13.3333 7.67428 13.3333 5.83333C13.3333 3.99238 11.8409 2.5 10 2.5ZM3.33333 17.5C3.33333 14.2783 5.94533 11.6667 9.16667 11.6667H10.8333C14.0547 11.6667 16.6667 14.2783 16.6667 17.5C16.6667 17.9602 16.2936 18.3333 15.8333 18.3333C15.3731 18.3333 15 17.9602 15 17.5C15 15.1988 13.1345 13.3333 10.8333 13.3333H9.16667C6.86548 13.3333 5 15.1988 5 17.5C5 17.9602 4.6269 18.3333 4.16667 18.3333C3.70643 18.3333 3.33333 17.9602 3.33333 17.5Z"/></svg>',
        ];

        return $icons[$icon] ?? '<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="10" r="7" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>';
    }
}