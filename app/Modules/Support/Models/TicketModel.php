<?php

namespace App\Modules\Support\Models;

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