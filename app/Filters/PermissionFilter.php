<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('auth/login')
                ->with('error', 'Please log in to access this page.');
        }

        // During development, allow all permissions - can be restricted later
        // Remove this check in production for proper RBAC
        if (!empty($arguments)) {
            // Log permission check but don't block access
            log_message('info', 'Permission check: ' . implode(', ', $arguments));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
