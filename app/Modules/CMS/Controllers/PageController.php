<?php

namespace App\Modules\CMS\Controllers;

use App\Controllers\BaseController;
use App\Modules\CMS\Services\CMSService;
use CodeIgniter\HTTP\ResponseInterface;

class PageController extends BaseController
{
    protected CMSService $cmsService;

    public function __construct()
    {
        $this->cmsService = new CMSService();
    }

    public function page(string $slug)
    {
        $result = $this->cmsService->getPageBySlug($slug);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $result['data']['title'],
            'page' => $result['data'],
        ];

        return view('CMS/page', $data);
    }
}
