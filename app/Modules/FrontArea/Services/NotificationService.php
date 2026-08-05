<?php

namespace App\Modules\FrontArea\Services;

use App\Modules\FrontArea\Models\NotificationModel;

class NotificationService
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function create(int $userId, array $data): array
    {
        try {
            $notificationData = [
                'uuid' => $this->generateUuidString(),
                'user_id' => $userId,
                'title' => $data['title'],
                'message' => $data['message'],
                'type' => $data['type'] ?? 'system',
                'status' => 'unread',
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $notificationId = $this->notificationModel->insert($notificationData);
            if (!$notificationId) {
                return ['success' => false, 'message' => 'Failed to create notification.'];
            }

            return [
                'success' => true,
                'message' => 'Notification created successfully.',
                'data' => $this->notificationModel->find($notificationId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error creating notification: ' . $e->getMessage()
            ];
        }
    }

    public function markAsRead(int $notificationId): array
    {
        try {
            $notification = $this->notificationModel->find($notificationId);
            if (!$notification) {
                return ['success' => false, 'message' => 'Notification not found.'];
            }

            $this->notificationModel->update($notificationId, ['status' => 'read']);

            return [
                'success' => true,
                'message' => 'Notification marked as read.',
                'data' => $this->notificationModel->find($notificationId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error marking notification as read: ' . $e->getMessage()
            ];
        }
    }

    public function markAllAsRead(int $userId): array
    {
        try {
            $this->notificationModel->where('user_id', $userId)
                ->where('status', 'unread')
                ->update(['status' => 'read']);

            return [
                'success' => true,
                'message' => 'All notifications marked as read.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error marking notifications as read: ' . $e->getMessage()
            ];
        }
    }

    public function delete(int $notificationId): array
    {
        try {
            $notification = $this->notificationModel->find($notificationId);
            if (!$notification) {
                return ['success' => false, 'message' => 'Notification not found.'];
            }

            $this->notificationModel->delete($notificationId);

            return [
                'success' => true,
                'message' => 'Notification deleted successfully.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error deleting notification: ' . $e->getMessage()
            ];
        }
    }

    public function getUserNotifications(int $userId, int $limit = 10, int $offset = 0): array
    {
        try {
            $notifications = $this->notificationModel->getByUser($userId, $limit, $offset);
            $unreadCount = $this->notificationModel->countUnread($userId);

            return [
                'success' => true,
                'message' => 'Notifications retrieved successfully.',
                'data' => [
                    'notifications' => $notifications,
                    'unread_count' => $unreadCount
                ]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving notifications: ' . $e->getMessage()
            ];
        }
    }

    public function sendToMultipleUsers(array $userIds, array $data): array
    {
        try {
            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                foreach ($userIds as $userId) {
                    $notificationData = [
                        'uuid' => $this->generateUuidString(),
                        'user_id' => $userId,
                        'title' => $data['title'],
                        'message' => $data['message'],
                        'type' => $data['type'] ?? 'system',
                        'status' => 'unread',
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->notificationModel->insert($notificationData);
                }

                if ($db->transStatus() === false) {
                    $db->transRollback();
                    return ['success' => false, 'message' => 'Failed to send notifications.'];
                }

                $db->transCommit();

                return [
                    'success' => true,
                    'message' => 'Notifications sent successfully.',
                    'data' => ['count' => count($userIds)]
                ];
            } catch (\Throwable $e) {
                $db->transRollback();
                throw $e;
            }
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error sending notifications: ' . $e->getMessage()
            ];
        }
    }

    protected function generateUuidString(): string
    {
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }
}