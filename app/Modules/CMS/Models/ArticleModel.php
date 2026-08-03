<?php

namespace App\Modules\CMS\Models;

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
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return sprintf('%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $data[0], $data[1], $data[2], $data[3],
            $data[4], $data[5], $data[6], $data[7],
            $data[8], $data[9], $data[10], $data[11],
            $data[12], $data[13], $data[14], $data[15]
        );
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
