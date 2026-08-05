<?php

namespace App\Modules\AdminArea\Services;

use App\Modules\AdminArea\Models\TicketModel;
use App\Modules\AdminArea\Models\TicketMessageModel;

class SupportService
{
    protected $ticketModel;
    protected $messageModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->messageModel = new TicketMessageModel();
    }

    public function createTicket(int $userId, array $data): array
    {
        try {
            $ticketData = [
                'uuid' => $this->generateUuidString(),
                'user_id' => $userId,
                'category_id' => $data['category_id'] ?? null,
                'ticket_number' => $this->generateTicketNumber(),
                'subject' => $data['subject'],
                'priority' => $data['priority'] ?? 'medium',
                'status' => 'open',
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $ticketId = $this->ticketModel->insert($ticketData);
            if (!$ticketId) {
                return ['success' => false, 'message' => 'Failed to create ticket.'];
            }

            // Create initial message
            $messageData = [
                'uuid' => $this->generateUuidString(),
                'ticket_id' => $ticketId,
                'user_id' => $userId,
                'message' => $data['message'],
                'attachment' => $data['attachment'] ?? null,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->messageModel->insert($messageData);

            return [
                'success' => true,
                'message' => 'Ticket created successfully.',
                'data' => $this->ticketModel->getWithMessages($ticketId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error creating ticket: ' . $e->getMessage()
            ];
        }
    }

    public function updateTicket(int $ticketId, array $data): array
    {
        try {
            $ticket = $this->ticketModel->find($ticketId);
            if (!$ticket) {
                return ['success' => false, 'message' => 'Ticket not found.'];
            }

            $updateData = [];
            if (isset($data['category_id'])) $updateData['category_id'] = $data['category_id'];
            if (isset($data['assigned_to'])) $updateData['assigned_to'] = $data['assigned_to'];
            if (isset($data['subject'])) $updateData['subject'] = $data['subject'];
            if (isset($data['priority'])) $updateData['priority'] = $data['priority'];
            if (isset($data['status'])) $updateData['status'] = $data['status'];

            $this->ticketModel->update($ticketId, $updateData);

            return [
                'success' => true,
                'message' => 'Ticket updated successfully.',
                'data' => $this->ticketModel->find($ticketId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error updating ticket: ' . $e->getMessage()
            ];
        }
    }

    public function addMessage(int $ticketId, int $userId, array $data): array
    {
        try {
            $ticket = $this->ticketModel->find($ticketId);
            if (!$ticket) {
                return ['success' => false, 'message' => 'Ticket not found.'];
            }

            if ($ticket->status === 'closed' || $ticket->status === 'resolved') {
                return ['success' => false, 'message' => 'Cannot add message to closed/resolved ticket.'];
            }

            $messageData = [
                'uuid' => $this->generateUuidString(),
                'ticket_id' => $ticketId,
                'user_id' => $userId,
                'message' => $data['message'],
                'attachment' => $data['attachment'] ?? null,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $messageId = $this->messageModel->insert($messageData);
            if (!$messageId) {
                return ['success' => false, 'message' => 'Failed to add message.'];
            }

            // Update ticket status based on message source
            $updateData = [];
            if ($userId === $ticket->user_id) {
                // Customer replied, set to waiting response
                $updateData['status'] = 'waiting_response';
            } else {
                // Support staff replied, set to in progress
                $updateData['status'] = 'in_progress';
            }
            $this->ticketModel->update($ticketId, $updateData);

            return [
                'success' => true,
                'message' => 'Message added successfully.',
                'data' => [
                    'ticket' => $this->ticketModel->find($ticketId),
                    'message' => $this->messageModel->find($messageId)
                ]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error adding message: ' . $e->getMessage()
            ];
        }
    }

    public function getUserTickets(int $userId, int $limit = 10, int $offset = 0): array
    {
        try {
            $tickets = $this->ticketModel->getByUser($userId, $limit, $offset);
            return [
                'success' => true,
                'message' => 'Tickets retrieved successfully.',
                'data' => ['tickets' => $tickets]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving tickets: ' . $e->getMessage()
            ];
        }
    }

    public function countByUser(int $userId): int
    {
        return $this->ticketModel->where('user_id', $userId)->countAllResults();
    }

    public function getTicketsByUser(int $userId): array
    {
        try {
            $tickets = $this->ticketModel->getByUser($userId);
            return [
                'success' => true,
                'message' => 'Tickets retrieved successfully.',
                'data' => ['tickets' => $tickets]
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving tickets: ' . $e->getMessage()
            ];
        }
    }

    public function getTicketWithMessages(int $ticketId): array
    {
        try {
            $ticket = $this->ticketModel->getWithMessages($ticketId);
            if (!$ticket) {
                return ['success' => false, 'message' => 'Ticket not found.'];
            }

            return [
                'success' => true,
                'message' => 'Ticket retrieved successfully.',
                'data' => $ticket
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error retrieving ticket: ' . $e->getMessage()
            ];
        }
    }

    public function closeTicket(int $ticketId, string $resolution = ''): array
    {
        try {
            $ticket = $this->ticketModel->find($ticketId);
            if (!$ticket) {
                return ['success' => false, 'message' => 'Ticket not found.'];
            }

            $this->ticketModel->update($ticketId, ['status' => 'closed']);

            if ($resolution) {
                $messageData = [
                    'uuid' => $this->generateUuidString(),
                    'ticket_id' => $ticketId,
                    'user_id' => 0, // System
                    'message' => "Ticket closed. Resolution: $resolution",
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->messageModel->insert($messageData);
            }

            return [
                'success' => true,
                'message' => 'Ticket closed successfully.',
                'data' => $this->ticketModel->find($ticketId)
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error closing ticket: ' . $e->getMessage()
            ];
        }
    }

    protected function generateUuidString(): string
    {
        // Simple implementation dengan timestamp dan random number (Windows compatible)
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(100000, 999999)), 0, 8);
    }

    protected function generateTicketNumber(): string
    {
        $lastTicket = db_connect()->table('tickets')
            ->select('ticket_number')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

        $counter = $lastTicket ? (int)substr($lastTicket->ticket_number, -6) + 1 : 1;

        return 'TKT-' . date('Ymd') . '-' . str_pad($counter, 6, '0', STR_PAD_LEFT);
    }
}