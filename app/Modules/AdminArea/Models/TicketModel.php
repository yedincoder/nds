<?php

namespace App\Modules\AdminArea\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'user_id',
        'category_id',
        'assigned_to',
        'ticket_number',
        'subject',
        'priority',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'subject' => 'required|min_length[5]|max_length[255]',
        'priority' => 'in_list[low,medium,high,critical]',
        'status' => 'in_list[open,waiting_response,in_progress,resolved,closed]',
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

    public function getByUser(int $userId, int $limit = 0, int $offset = 0): array
    {
        $query = $this->where('user_id', $userId);
        if ($limit > 0) {
            $query->limit($limit, $offset);
        }
        return $query->orderBy('created_at', 'DESC')->findAll();
    }

    public function getOpenTickets(): array
    {
        return $this->where('status', 'open')
            ->orWhere('status', 'waiting_response')
            ->orWhere('status', 'in_progress')
            ->orderBy('priority', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function findByNumber(string $ticketNumber): ?object
    {
        return $this->where('ticket_number', $ticketNumber)->first();
    }

    public function getWithMessages(int $id): ?object
    {
        $ticket = $this->find($id);
        if ($ticket) {
            $db = \Config\Database::connect();
            $ticket->messages = $db->table('ticket_messages')
                ->where('ticket_id', $id)
                ->orderBy('created_at', 'ASC')
                ->get()
                ->getResult();
        }
        return $ticket;
    }
}