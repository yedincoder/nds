<?php

namespace App\Modules\Service\Services;

use App\Modules\Service\Models\ServiceModel;
use App\Modules\Service\Models\ServiceCategoryModel;
use App\Modules\Service\Models\ServicePackageModel;

class ServiceService
{
    protected $serviceModel;
    protected $categoryModel;
    protected $packageModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
        $this->categoryModel = new ServiceCategoryModel();
        $this->packageModel = new ServicePackageModel();
    }

    public function createService(array $data): array
    {
        try {
            // Validate category exists
            $category = $this->categoryModel->findBySlug($data['category_slug'] ?? '');
            if (!$category) {
                return ['success' => false, 'message' => 'Category not found.'];
            }

            // Generate UUID for service
            $data['uuid'] = $this->generateUuidString();
            $data['category_id'] = $category->id;

            // Insert service
            $serviceId = $this->serviceModel->insert($data);
            if (!$serviceId) {
                return ['success' => false, 'message' => 'Failed to create service.'];
            }

            return [
                'success' => true,
                'message' => 'Service created successfully.',
                'data' => $this->serviceModel->find($serviceId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error creating service: ' . $e->getMessage()
            ];
        }
    }

    public function updateService(int $id, array $data): array
    {
        try {
            // Check if service exists
            $service = $this->serviceModel->find($id);
            if (!$service) {
                return ['success' => false, 'message' => 'Service not found.'];
            }

            // Validate category if changed
            if (!empty($data['category_slug'])) {
                $category = $this->categoryModel->findBySlug($data['category_slug']);
                if (!$category) {
                    return ['success' => false, 'message' => 'Category not found.'];
                }
                $data['category_id'] = $category->id;
            }

            // Generate UUID for service
            $data['uuid'] = $this->generateUuidString();

            // Update service
            $this->serviceModel->update($id, $data);

            return [
                'success' => true,
                'message' => 'Service updated successfully.',
                'data' => $this->serviceModel->find($id)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error updating service: ' . $e->getMessage()
            ];
        }
    }

    public function deleteService(int $id): array
    {
        try {
            // Delete service and related packages
            $this->serviceModel->delete($id);
            $this->packageModel->where('service_id', $id)->delete();

            return [
                'success' => true,
                'message' => 'Service deleted successfully.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error deleting service: ' . $e->getMessage()
            ];
        }
    }

    public function searchServices(string $keyword, int $limit = 10): array
    {
        return $this->serviceModel->search($keyword, $limit);
    }

    public function getServices(array $filters = []): array
    {
        $builder = $this->serviceModel->builder();
        
        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }
        
        if (!empty($filters['category_slug'])) {
            $builder->join('service_categories sc', 'sc.id = services.category_id')
                   ->where('sc.slug', $filters['category_slug']);
        }
        
        $services = $builder->orderBy('name', 'ASC')->get()->getResultArray();
        
        return [
            'success' => true,
            'data' => $services
        ];
    }

    public function getServiceBySlug(string $slug): array
    {
        $service = $this->serviceModel->where('slug', $slug)->first();
        
        if (!$service) {
            return ['success' => false, 'message' => 'Service not found.'];
        }
        
        return [
            'success' => true,
            'data' => $service
        ];
    }

    public function getServiceWithDetails(int $id): ?object
    {
        return $this->serviceModel->getWithCategory($id);
    }

    public function createPackage(int $serviceId, array $data): array
    {
        try {
            // Check if service exists
            $service = $this->serviceModel->find($serviceId);
            if (!$service) {
                return ['success' => false, 'message' => 'Service not found.'];
            }

            // Generate UUID for package
            $data['uuid'] = $this->generateUuidString();
            $data['service_id'] = $serviceId;

            // Insert package
            $packageId = $this->packageModel->insert($data);
            if (!$packageId) {
                return ['success' => false, 'message' => 'Failed to create package.'];
            }

            return [
                'success' => true,
                'message' => 'Package created successfully.',
                'data' => $this->packageModel->find($packageId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error creating package: ' . $e->getMessage()
            ];
        }
    }

    protected function generateUuidString(): string
    {
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }
}