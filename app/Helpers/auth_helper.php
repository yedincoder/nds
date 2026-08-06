<?php

if (!function_exists('is_logged_in')) {
    /**
     * Check if user is logged in
     */
    function is_logged_in(): bool
    {
        return (bool) session()->get('isLoggedIn');
    }
}

if (!function_exists('current_user')) {
    /**
     * Get current logged in user
     */
    function current_user(): ?array
    {
        if (!session()->get('isLoggedIn')) {
            return null;
        }

        return [
            'id' => session()->get('user_id'),
            'username' => session()->get('username'),
            'email' => session()->get('email'),
            'role' => session()->get('role'),
        ];
    }
}

if (!function_exists('has_role')) {
    /**
     * Check if current user has given role
     */
    function has_role(string $role): bool
    {
        return session()->get('role') === $role;
    }
}
