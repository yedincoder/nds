<?php

namespace App\Modules\AdminArea\Models;

use CodeIgniter\Model;

class TicketMessageModel extends Model
{
    protected $table = 'ticket_messages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'uuid',
        'ticket_id',
        'user_id',
        'message',
        'attachment',
        'created_at',
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'ticket_id' => 'required|integer',
        'user_id' => 'required|integer',
        'message' => 'required',
    ];

    protected $beforeInsert = ['generateUuid'];

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

    public function getByTicket(int $ticketId): array
    {
        return $this->where('ticket_id', $ticketId)->orderBy('created_at', 'ASC')->findAll();
    }

    public function getLastMessage(int $ticketId): ?object
    {
        return $this->where('ticket_id', $ticketId)
            ->orderBy('created_at', 'DESC')
            ->first();
    }
}