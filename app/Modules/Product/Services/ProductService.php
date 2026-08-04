<?php

namespace App\Modules\Product\Services;

use CodeIgniter\Database\ResultInterface;

class ProductService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getActiveCategories(): array
    {
        return $this->db->table('product_categories')
            ->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResult();
    }

    public function getProducts(array $filters = [], int $perPage = 12, int $page = 1): array
    {
        $builder = $this->db->table('products p');
        $builder->select('p.*, pc.name as category_name, pp.price, pp.discount_price, pp.currency');
        $builder->join('product_categories pc', 'pc.id = p.category_id', 'left');
        $builder->join('product_prices pp', 'pp.product_id = p.id', 'left');
        $builder->where('p.status', 'active');

        if (!empty($filters['category_id'])) {
            $builder->where('p.category_id', $filters['category_id']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart();
            $builder->like('p.name', $filters['search']);
            $builder->orLike('p.short_description', $filters['search']);
            $builder->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $products = $builder->orderBy('p.created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();

        return [
            'products'   => $products,
            'total'      => $total,
            'perPage'    => $perPage,
            'page'       => $page,
            'totalPages' => (int) ceil($total / $perPage),
        ];
    }

    public function getProductBySlug(string $slug): ?object
    {
        return $this->db->table('products p')
            ->select('p.*, pc.name as category_name, pp.price, pp.discount_price, pp.currency')
            ->join('product_categories pc', 'pc.id = p.category_id', 'left')
            ->join('product_prices pp', 'pp.product_id = p.id', 'left')
            ->where('p.slug', $slug)
            ->where('p.status', 'active')
            ->get()
            ->getRow();
    }

    public function getProductImages(int $productId): array
    {
        return $this->db->table('product_images')
            ->where('product_id', $productId)
            ->orderBy('position', 'ASC')
            ->get()
            ->getResult();
    }

    public function getProductFiles(int $productId): array
    {
        return $this->db->table('product_files')
            ->where('product_id', $productId)
            ->where('status', 'active')
            ->get()
            ->getResult();
    }

    public function getProductsByCategory(int $categoryId, int $perPage = 12, int $page = 1): array
    {
        return $this->getProducts(['category_id' => $categoryId], $perPage, $page);
    }

    public function searchProducts(string $keyword, int $perPage = 12, int $page = 1): array
    {
        return $this->getProducts(['search' => $keyword], $perPage, $page);
    }

    public function getFeaturedProducts(int $limit = 6): array
    {
        return $this->db->table('products p')
            ->select('p.*, pp.price, pp.discount_price, pp.currency')
            ->join('product_prices pp', 'pp.product_id = p.id', 'left')
            ->where('p.status', 'active')
            ->orderBy('p.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();
    }

    // ── Admin methods ──────────────────────────────────────

    public function getAllProducts(array $filters = [], int $perPage = 20, int $page = 1): array
    {
        $builder = $this->db->table('products p');
        $builder->select('p.*, pc.name as category_name, pp.price, pp.discount_price, pp.currency');
        $builder->join('product_categories pc', 'pc.id = p.category_id', 'left');
        $builder->join('product_prices pp', 'pp.product_id = p.id', 'left');

        if (!empty($filters['status'])) {
            $builder->where('p.status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart();
            $builder->like('p.name', $filters['search']);
            $builder->orLike('p.slug', $filters['search']);
            $builder->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $products = $builder->orderBy('p.created_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResult();

        return [
            'products'   => $products,
            'total'      => $total,
            'perPage'    => $perPage,
            'page'       => $page,
            'totalPages' => (int) ceil($total / $perPage),
        ];
    }

    public function getProductById(int $id): ?object
    {
        return $this->db->table('products p')
            ->select('p.*, pc.name as category_name, pp.price, pp.discount_price, pp.currency')
            ->join('product_categories pc', 'pc.id = p.category_id', 'left')
            ->join('product_prices pp', 'pp.product_id = p.id', 'left')
            ->where('p.id', $id)
            ->get()
            ->getRow();
    }

    public function createProduct(array $data): ?int
    {
        $this->db->transBegin();

        $this->db->table('products')->insert($data['product']);
        $productId = $this->db->insertID();

        if ($productId && !empty($data['price'])) {
            $this->db->table('product_prices')->insert([
                'uuid'           => $this->generateUuid(),
                'product_id'     => $productId,
                'price'          => $data['price']['price'] ?? 0,
                'discount_price' => $data['price']['discount_price'] ?? null,
                'currency'       => $data['price']['currency'] ?? 'IDR',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
        }

        $this->db->transComplete();

        return $this->db->transStatus() ? $productId : null;
    }

    public function updateProduct(int $id, array $data): bool
    {
        $this->db->transBegin();

        $this->db->table('products')->where('id', $id)->update($data['product']);

        if (!empty($data['price'])) {
            $existing = $this->db->table('product_prices')->where('product_id', $id)->get()->getRow();
            if ($existing) {
                $this->db->table('product_prices')->where('product_id', $id)->update([
                    'price'          => $data['price']['price'] ?? $existing->price,
                    'discount_price' => $data['price']['discount_price'] ?? $existing->discount_price,
                    'currency'       => $data['price']['currency'] ?? $existing->currency,
                    'updated_at'     => date('Y-m-d H:i:s'),
                ]);
            }
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    public function deleteProduct(int $id): bool
    {
        return $this->db->table('products')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
    }

    public function getCategoryById(int $id): ?object
    {
        return $this->db->table('product_categories')->where('id', $id)->get()->getRow();
    }

    public function createCategory(array $data): ?int
    {
        $this->db->table('product_categories')->insert($data);
        return $this->db->transStatus() ? $this->db->insertID() : null;
    }

    public function updateCategory(int $id, array $data): bool
    {
        return $this->db->table('product_categories')->where('id', $id)->update($data);
    }

    public function deleteCategory(int $id): bool
    {
        return $this->db->table('product_categories')->where('id', $id)->delete();
    }

    public function countAll(): int
    {
        return $this->db->table('products')->countAllResults();
    }

    public function countByStatus(string $status): int
    {
        return $this->db->table('products')->where('status', $status)->countAllResults();
    }

    protected function generateUuid(): string
    {
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }
}
