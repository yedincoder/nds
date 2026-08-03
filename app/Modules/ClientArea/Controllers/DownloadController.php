<?php

namespace App\Modules\ClientArea\Controllers;

use App\Controllers\BaseController;
use App\Modules\Customer\Services\CustomerService;

class DownloadController extends BaseController
{
    protected CustomerService $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $result = $this->customerService->getDownloads($userId);

        $data = [
            'title' => 'My Downloads',
            'downloads' => $result['data']['downloads'] ?? [],
        ];

        return view('ClientArea/downloads', $data);
    }

    public function download(string $token)
    {
        $userId = session()->get('user_id');
        $result = $this->customerService->downloadFile($userId, $token);

        if (!$result['success']) {
            return redirect()->back()
                ->with('error', $result['message']);
        }

        $file = $result['data']['file'];
        $filePath = $result['data']['file_path'];

        return $this->response->download($filePath, null)->setFileName($file->file_name);
    }
}
