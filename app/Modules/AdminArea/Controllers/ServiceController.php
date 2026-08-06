<?php

namespace App\Modules\AdminArea\Controllers;

use App\Modules\FrontArea\Models\ServiceModel;
use App\Modules\FrontArea\Models\ServiceCategoryModel;
use CodeIgniter\HTTP\RedirectResponse;

class ServiceController extends \App\Controllers\AdminBaseController
{
    protected ServiceModel $serviceModel;
    protected ServiceCategoryModel $categoryModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
        $this->categoryModel = new ServiceCategoryModel();
    }

    public function index(): string
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $services = $this->serviceModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Services',
            'page'  => 'admin/services',
            'services' => $services,
            'pager' => $this->serviceModel->pager,
        ];

        return view('AdminArea/dashboard/services', $data);
    }

    public function create(): string
    {
        $data = [
            'title' => 'Create Service',
            'page'  => 'admin/services',
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('AdminArea/dashboard/service_form', $data);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'slug' => 'required|min_length[2]|max_length[255]|is_unique[services.slug]',
            'status' => 'required|in_list[draft,active,inactive,archived]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $this->serviceModel->insert([
            'category_id' => $this->request->getPost('category_id') ?: null,
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'thumbnail' => $this->request->getPost('thumbnail'),
            'price_type' => $this->request->getPost('price_type') ?: 'starting',
            'price' => $this->request->getPost('price') ?: null,
            'status' => $this->request->getPost('status'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
            'created_by' => session()->get('user_id'),
        ]);

        return redirect()->to('/admin/services')
            ->with('success', 'Service created successfully.');
    }

    public function edit(int $id): string|RedirectResponse
    {
        $service = $this->serviceModel->find($id);
        if (!$service) {
            return redirect()->to('/admin/services')
                ->with('error', 'Service not found.');
        }

        $db = \Config\Database::connect();
        $packages = $db->table('service_packages')
            ->where('service_id', $id)
            ->orderBy('id', 'ASC')
            ->get()
            ->getResult();

        $data = [
            'title' => 'Edit Service',
            'page'  => 'admin/services',
            'service' => $service,
            'packages' => $packages,
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('AdminArea/dashboard/service_form', $data);
    }

    public function update(int $id): RedirectResponse
    {
        $service = $this->serviceModel->find($id);
        if (!$service) {
            return redirect()->to('/admin/services')
                ->with('error', 'Service not found.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'slug' => 'required|min_length[2]|max_length[255]|is_unique[services.slug,id,{id}]',
            'status' => 'required|in_list[draft,active,inactive,archived]',
        ];

        $validationData = $this->request->getPost();
        $validationData['id'] = $id;

        if (!$this->validateData($validationData, $rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $this->serviceModel->update($id, [
            'category_id' => $this->request->getPost('category_id') ?: null,
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'thumbnail' => $this->request->getPost('thumbnail'),
            'price_type' => $this->request->getPost('price_type') ?: 'starting',
            'price' => $this->request->getPost('price') ?: null,
            'status' => $this->request->getPost('status'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
        ]);

        return redirect()->back()
            ->with('success', 'Service updated successfully.');
    }

    public function delete(int $id): RedirectResponse
    {
        $service = $this->serviceModel->find($id);
        if (!$service) {
            return redirect()->to('/admin/services')
                ->with('error', 'Service not found.');
        }

        $this->serviceModel->delete($id, true);

        return redirect()->to('/admin/services')
            ->with('success', 'Service deleted successfully.');
    }
}