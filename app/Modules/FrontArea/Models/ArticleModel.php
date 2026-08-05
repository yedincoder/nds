<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'uuid',
        'category_id',
        'author_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'thumbnail',
        'status',
        'seo_title',
        'seo_description',
        'published_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'id' => 'permit_empty',
        'title' => 'required|min_length[2]|max_length[255]',
        'slug' => 'required|min_length[2]|max_length[255]|is_unique[articles.slug,id,{id}]',
        'status' => 'in_list[draft,review,published,archived]',
    ];

    protected $beforeInsert = ['generateUuid'];
    protected $beforeUpdate = ['generateUuid'];

    protected function generateUuid(array $data): array
    {
        if (empty($data['data']['uuid'])) {
            $data['data']['uuid'] = $this->generateUuidString();
        }
        return $data;
    }

    protected function generateUuidString(): string
    {
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }

    public function findBySlug(string $slug): ?object
    {
        return $this->where('slug', $slug)->first();
    }

    public function getPublished(int $limit = 0, int $offset = 0): array
    {
        $query = $this->where('status', 'published')
            ->where('published_at <=', date('Y-m-d H:i:s'));

        if ($limit > 0) {
            $query->limit($limit, $offset);
        }

        return $query->orderBy('published_at', 'DESC')->findAll();
    }

    public function getByCategory(int $categoryId, int $limit = 0, int $offset = 0): array
    {
        $query = $this->where('category_id', $categoryId)
            ->where('status', 'published');

        if ($limit > 0) {
            $query->limit($limit, $offset);
        }

        return $query->orderBy('published_at', 'DESC')->findAll();
    }

    public function search(string $keyword, int $limit = 10): array
    {
        return $this->like('title', $keyword)
            ->orLike('content', $keyword)
            ->where('status', 'published')
            ->limit($limit)
            ->findAll();
    }

    public function getWithTags(int $id): ?object
    {
        $article = $this->find($id);
        if ($article) {
            $db = \Config\Database::connect();
            $article->tags = $db->table('tags')
                ->select('tags.*')
                ->join('article_tags', 'article_tags.tag_id = tags.id')
                ->where('article_tags.article_id', $id)
                ->get()
                ->getResult();
        }
        return $article;
    }
}
