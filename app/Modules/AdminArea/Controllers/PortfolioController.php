<?php

namespace App\Modules\AdminArea\Controllers;

use App\Modules\FrontArea\Models\PortfolioModel;
use App\Modules\FrontArea\Models\ClientModel;
use CodeIgniter\HTTP\RedirectResponse;

class PortfolioController extends \App\Controllers\AdminBaseController
{
    protected PortfolioModel $portfolioModel;
    protected ClientModel $clientModel;

    public function __construct()
    {
        $this->portfolioModel = new PortfolioModel();
        $this->clientModel = new ClientModel();
    }

    public function index(): string
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $portfolios = $this->portfolioModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Portfolio',
            'page'  => 'admin/portfolio',
            'portfolios' => $portfolios,
            'pager' => $this->portfolioModel->pager,
        ];

        return view('AdminArea/dashboard/portfolio', $data);
    }

    public function create(): string
    {
        $data = [
            'title' => 'Create Portfolio',
            'page'  => 'admin/portfolio',
            'clients' => $this->clientModel->findAll(),
        ];
        return view('AdminArea/dashboard/portfolio_form', $data);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'title' => 'required|min_length[2]|max_length[255]',
            'slug' => 'required|min_length[2]|max_length[255]|is_unique[portfolios.slug]',
            'status' => 'required|in_list[draft,published,featured,archived]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $this->portfolioModel->insert([
            'client_id' => $this->request->getPost('client_id') ?: null,
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'content' => $this->request->getPost('content'),
            'thumbnail' => $this->request->getPost('thumbnail'),
            'status' => $this->request->getPost('status'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
            'created_by' => session()->get('user_id'),
        ]);

        return redirect()->to('/admin/portfolio')
            ->with('success', 'Portfolio created successfully.');
    }

    public function edit(int $id): string|RedirectResponse
    {
        $portfolio = $this->portfolioModel->find($id);
        if (!$portfolio) {
            return redirect()->to('/admin/portfolio')
                ->with('error', 'Portfolio not found.');
        }

        $data = [
            'title' => 'Edit Portfolio',
            'page'  => 'admin/portfolio',
            'portfolio' => $portfolio,
            'clients' => $this->clientModel->findAll(),
        ];

        return view('AdminArea/dashboard/portfolio_form', $data);
    }

    public function update(int $id): RedirectResponse
    {
        $portfolio = $this->portfolioModel->find($id);
        if (!$portfolio) {
            return redirect()->to('/admin/portfolio')
                ->with('error', 'Portfolio not found.');
        }

        $rules = [
            'title' => 'required|min_length[2]|max_length[255]',
            'slug' => 'required|min_length[2]|max_length[255]|is_unique[portfolios.slug,id,{id}]',
            'status' => 'required|in_list[draft,published,featured,archived]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $this->portfolioModel->update($id, [
            'client_id' => $this->request->getPost('client_id') ?: null,
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'content' => $this->request->getPost('content'),
            'thumbnail' => $this->request->getPost('thumbnail'),
            'status' => $this->request->getPost('status'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
        ]);

        return redirect()->back()
            ->with('success', 'Portfolio updated successfully.');
    }

    public function delete(int $id): RedirectResponse
    {
        $portfolio = $this->portfolioModel->find($id);
        if (!$portfolio) {
            return redirect()->to('/admin/portfolio')
                ->with('error', 'Portfolio not found.');
        }

        $this->portfolioModel->delete($id, true);

        return redirect()->to('/admin/portfolio')
            ->with('success', 'Portfolio deleted successfully.');
    }
}