<?php

namespace App\Modules\Settings\Controllers;

use App\Controllers\BaseController;
use App\Modules\Settings\Services\SettingsService;

class SettingsController extends BaseController
{
    protected SettingsService $settingsService;

    public function __construct()
    {
        $this->settingsService = new SettingsService();
    }

    public function index()
    {
        $result = $this->settingsService->getSettings();

        $data = [
            'title' => 'Settings',
            'settings' => $result['data'] ?? [],
        ];

        return view('Settings/index', $data);
    }

    public function update(): \CodeIgniter\HTTP\ResponseInterface
    {
        $validation = $this->validate([
            'app_name' => 'required|max_length[255]',
            'app_description' => 'permit_empty|max_length[500]',
            'app_url' => 'required|valid_url',
            'from_email' => 'required|valid_email',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $result = $this->settingsService->updateSettings([
            'app_name' => $this->request->getPost('app_name'),
            'app_description' => $this->request->getPost('app_description'),
            'app_url' => $this->request->getPost('app_url'),
            'from_email' => $this->request->getPost('from_email'),
        ]);

        if ($result['success']) {
            return redirect()->back()
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message'])
            ->withInput();
    }
}