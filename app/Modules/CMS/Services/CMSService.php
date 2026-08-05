<?php

namespace App\Modules\CMS\Services;

use App\Modules\CMS\Models\PageModel;
use App\Modules\CMS\Models\ArticleModel;
use App\Modules\CMS\Models\CategoryModel;
use App\Modules\CMS\Models\TagModel;
use App\Modules\CMS\Models\ClientModel;
use App\Modules\CMS\Models\PortfolioModel;

class CMSService
{
    protected $pageModel;
    protected $articleModel;
    protected $categoryModel;
    protected $tagModel;
    protected $clientModel;
    protected $portfolioModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
        $this->articleModel = new ArticleModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();
        $this->clientModel = new ClientModel();
        $this->portfolioModel = new PortfolioModel();
    }

    public function createPage(array $data): array
    {
        try {
            $data['uuid'] = $this->generateUuidString();

            $pageId = $this->pageModel->insert($data);
            if (!$pageId) {
                return ['success' => false, 'message' => 'Failed to create page.'];
            }

            return [
                'success' => true,
                'message' => 'Page created successfully.',
                'data' => $this->pageModel->find($pageId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error creating page: ' . $e->getMessage()
            ];
        }
    }

    public function updatePage(int $id, array $data): array
    {
        try {
            $page = $this->pageModel->find($id);
            if (!$page) {
                return ['success' => false, 'message' => 'Page not found.'];
            }

            $data['uuid'] = $this->generateUuidString();
            $this->pageModel->update($id, $data);

            return [
                'success' => true,
                'message' => 'Page updated successfully.',
                'data' => $this->pageModel->find($id)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error updating page: ' . $e->getMessage()
            ];
        }
    }

    public function deletePage(int $id): array
    {
        try {
            $this->pageModel->delete($id);
            return [
                'success' => true,
                'message' => 'Page deleted successfully.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error deleting page: ' . $e->getMessage()
            ];
        }
    }

    public function createArticle(array $data): array
    {
        try {
            $category = null;
            if (!empty($data['category_slug'])) {
                $category = $this->categoryModel->findBySlugAndType($data['category_slug'], 'article');
            }

            $data['uuid'] = $this->generateUuidString();
            $data['category_id'] = $category ? $category->id : null;

            if ($data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = date('Y-m-d H:i:s');
            }

            $articleId = $this->articleModel->insert($data);
            if (!$articleId) {
                return ['success' => false, 'message' => 'Failed to create article.'];
            }

            return [
                'success' => true,
                'message' => 'Article created successfully.',
                'data' => $this->articleModel->find($articleId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error creating article: ' . $e->getMessage()
            ];
        }
    }

    public function updateArticle(int $id, array $data): array
    {
        try {
            $article = $this->articleModel->find($id);
            if (!$article) {
                return ['success' => false, 'message' => 'Article not found.'];
            }

            $category = null;
            if (!empty($data['category_slug'])) {
                $category = $this->categoryModel->findBySlugAndType($data['category_slug'], 'article');
            }

            $data['category_id'] = $category ? $category->id : null;

            if ($data['status'] === 'published' && empty($data['published_at']) && empty($article->published_at)) {
                $data['published_at'] = date('Y-m-d H:i:s');
            }

            $this->articleModel->update($id, $data);

            return [
                'success' => true,
                'message' => 'Article updated successfully.',
                'data' => $this->articleModel->find($id)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error updating article: ' . $e->getMessage()
            ];
        }
    }

    public function deleteArticle(int $id): array
    {
        try {
            $db = \Config\Database::connect();
            $db->transBegin();

            // Delete article tags
            $db->table('article_tags')->where('article_id', $id)->delete();
            // Delete article
            $this->articleModel->delete($id);

            $db->transCommit();

            return [
                'success' => true,
                'message' => 'Article deleted successfully.'
            ];
        } catch (\Throwable $e) {
            $db->transRollback();
            return [
                'success' => false,
                'message' => 'Error deleting article: ' . $e->getMessage()
            ];
        }
    }

    public function createPortfolio(array $data): array
    {
        try {
            $data['uuid'] = $this->generateUuidString();

            $portfolioId = $this->portfolioModel->insert($data);
            if (!$portfolioId) {
                return ['success' => false, 'message' => 'Failed to create portfolio.'];
            }

            return [
                'success' => true,
                'message' => 'Portfolio created successfully.',
                'data' => $this->portfolioModel->find($portfolioId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error creating portfolio: ' . $e->getMessage()
            ];
        }
    }

    public function updatePortfolio(int $id, array $data): array
    {
        try {
            $portfolio = $this->portfolioModel->find($id);
            if (!$portfolio) {
                return ['success' => false, 'message' => 'Portfolio not found.'];
            }

            $data['uuid'] = $this->generateUuidString();
            $this->portfolioModel->update($id, $data);

            return [
                'success' => true,
                'message' => 'Portfolio updated successfully.',
                'data' => $this->portfolioModel->find($id)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error updating portfolio: ' . $e->getMessage()
            ];
        }
    }

    public function deletePortfolio(int $id): array
    {
        try {
            $this->portfolioModel->delete($id);
            return [
                'success' => true,
                'message' => 'Portfolio deleted successfully.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error deleting portfolio: ' . $e->getMessage()
            ];
        }
    }

    public function searchArticles(string $keyword, int $limit = 10): array
    {
        try {
            $articles = $this->articleModel->search($keyword, $limit);
            return [
                'success' => true,
                'message' => 'Search completed successfully.',
                'data' => $articles
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error searching articles: ' . $e->getMessage()
            ];
        }
    }

    public function getArticleBySlug(string $slug): array
    {
        try {
            $article = $this->articleModel->where('slug', $slug)
                ->where('status', 'published')
                ->first();

            if (!$article) {
                return [
                    'success' => false,
                    'message' => 'Article not found.'
                ];
            }

            // Get category name
            $category = null;
            if ($article->category_id) {
                $category = $this->categoryModel->find($article->category_id);
            }

            // Get tags
            $tags = [];
            $db = \Config\Database::connect();
            $tags = $db->table('article_tags')
                ->select('tags.name, tags.slug')
                ->join('tags', 'tags.id = article_tags.tag_id')
                ->where('article_tags.article_id', $article->id)
                ->get()
                ->getResult();

            return [
                'success' => true,
                'message' => 'Article retrieved successfully.',
                'data' => (object) array_merge(
                    (array) $article,
                    [
                        'category_name' => $category ? $category->name : null,
                        'category_slug' => $category ? $category->slug : null,
                        'tags' => $tags,
                    ]
                )
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving article: ' . $e->getMessage()
            ];
        }
    }

    public function getPublishedArticles(int $limit = 10, int $offset = 0): array
    {
        try {
            $articles = $this->articleModel->getPublished($limit, $offset);
            return [
                'success' => true,
                'message' => 'Articles retrieved successfully.',
                'data' => $articles
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving articles: ' . $e->getMessage()
            ];
        }
    }

    public function getPublishedPortfolios(int $limit = 10, int $offset = 0): array
    {
        try {
            $portfolios = $this->portfolioModel->getPublished($limit, $offset);
            return [
                'success' => true,
                'message' => 'Portfolios retrieved successfully.',
                'data' => $portfolios
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving portfolios: ' . $e->getMessage()
            ];
        }
    }

    protected function generateUuidString(): string
    {
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }
}