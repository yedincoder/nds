<?php

namespace App\Modules\Service\Controllers;

use App\Controllers\BaseController;
use App\Modules\Service\Services\ServiceService;
use CodeIgniter\HTTP\ResponseInterface;

class ServiceController extends BaseController
{
    protected ServiceService $serviceService;

    public function __construct()
    {
        $this->serviceService = new ServiceService();
    }

    public function index()
    {
        $result = $this->serviceService->getServices(['status' => 'active']);

        $data = [
            'title' => 'Our Services',
            'services' => $result['data'] ?? [],
        ];

        return view('service/index', $data);
    }

    public function detail(string $slug)
    {
        $result = $this->serviceService->getServiceBySlug($slug);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $result['data']['name'],
            'service' => $result['data'],
        ];

        return view('service/detail', $data);
    }

    public function requestQuote(string $slug)
    {
        $result = $this->serviceService->getServiceBySlug($slug);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'post') {
            $validation = $this->validate([
                'name' => 'required|min_length[3]',
                'email' => 'required|valid_email',
                'phone' => 'required',
                'message' => 'required|min_length[10]',
            ]);

            if (!$validation) {
                return redirect()->back()
                    ->with('errors', $this->validator->getErrors())
                    ->withInput();
            }

            return redirect()->back()
                ->with('success', 'Quote request sent successfully. We will contact you soon.');
        }

        $data = [
            'title' => 'Request Quote - ' . $result['data']['name'],
            'service' => $result['data'],
        ];

        return view('service/index', $data);
    }
}
