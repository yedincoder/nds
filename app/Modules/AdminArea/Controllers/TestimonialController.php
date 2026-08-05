<?php

namespace App\Modules\AdminArea\Controllers;

use App\Controllers\BaseController;
use App\Modules\AdminArea\Models\TestimonialModel;
use CodeIgniter\HTTP\RedirectResponse;

class TestimonialController extends BaseController
{
    protected TestimonialModel $testimonialModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
    }

    public function index(): string
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;
        $status = $this->request->getGet('status');

        $builder = $this->testimonialModel->orderBy('created_at', 'DESC');
        if (!empty($status) && in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $builder->where('status', $status);
        }

        $testimonials = $builder->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Testimonials',
            'testimonials' => $testimonials,
            'pager' => $this->testimonialModel->pager,
            'current_status' => $status ?? 'all',
            'stats' => [
                'pending' => $this->testimonialModel->countByStatus('pending'),
                'approved' => $this->testimonialModel->countByStatus('approved'),
                'rejected' => $this->testimonialModel->countByStatus('rejected'),
            ],
        ];

        return view('Testimonial/index', $data);
    }

    public function create(): string
    {
        $data = [
            'title' => 'Add Testimonial',
        ];
        return view('Testimonial/form', $data);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'customer_name' => 'required|min_length[2]|max_length[150]',
            'message' => 'required|min_length[10]',
            'rating' => 'required|in_list[1,2,3,4,5]',
            'status' => 'required|in_list[pending,approved,rejected]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'user_id' => $this->request->getPost('user_id') ?: null,
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_email' => $this->request->getPost('customer_email'),
            'company' => $this->request->getPost('company'),
            'position' => $this->request->getPost('position'),
            'title' => $this->request->getPost('title'),
            'message' => $this->request->getPost('message'),
            'rating' => $this->request->getPost('rating'),
            'status' => $this->request->getPost('status'),
            'featured' => $this->request->getPost('featured') ? 1 : 0,
        ];

        $this->testimonialModel->save($data);

        return redirect()->to('/admin/testimonials')
            ->with('success', 'Testimonial created successfully.');
    }

    public function edit($id = null): string|RedirectResponse
    {
        $testimonial = $this->testimonialModel->find($id);
        if (!$testimonial) {
            return redirect()->to('/admin/testimonials')
                ->with('error', 'Testimonial not found.');
        }

        $data = [
            'title' => 'Edit Testimonial',
            'testimonial' => $testimonial,
        ];
        return view('Testimonial/form', $data);
    }

    public function update($id = null): RedirectResponse
    {
        $testimonial = $this->testimonialModel->find($id);
        if (!$testimonial) {
            return redirect()->to('/admin/testimonials')
                ->with('error', 'Testimonial not found.');
        }

        $rules = [
            'customer_name' => 'required|min_length[2]|max_length[150]',
            'message' => 'required|min_length[10]',
            'rating' => 'required|in_list[1,2,3,4,5]',
            'status' => 'required|in_list[pending,approved,rejected]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'user_id' => $this->request->getPost('user_id') ?: null,
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_email' => $this->request->getPost('customer_email'),
            'company' => $this->request->getPost('company'),
            'position' => $this->request->getPost('position'),
            'title' => $this->request->getPost('title'),
            'message' => $this->request->getPost('message'),
            'rating' => $this->request->getPost('rating'),
            'status' => $this->request->getPost('status'),
            'featured' => $this->request->getPost('featured') ? 1 : 0,
        ];

        $this->testimonialModel->update($id, $data);

        return redirect()->to('/admin/testimonials')
            ->with('success', 'Testimonial updated successfully.');
    }

    public function toggleStatus($id = null): RedirectResponse
    {
        $testimonial = $this->testimonialModel->find($id);
        if (!$testimonial) {
            return redirect()->to('/admin/testimonials')
                ->with('error', 'Testimonial not found.');
        }

        $newStatus = $testimonial->status === 'approved' ? 'rejected' : 'approved';
        $this->testimonialModel->update($id, ['status' => $newStatus]);

        return redirect()->back()
            ->with('success', 'Testimonial ' . $newStatus . '.');
    }

    public function delete($id = null): RedirectResponse
    {
        $testimonial = $this->testimonialModel->find($id);
        if (!$testimonial) {
            return redirect()->to('/admin/testimonials')
                ->with('error', 'Testimonial not found.');
        }

        $this->testimonialModel->delete($id);

        return redirect()->to('/admin/testimonials')
            ->with('success', 'Testimonial deleted successfully.');
    }
}
