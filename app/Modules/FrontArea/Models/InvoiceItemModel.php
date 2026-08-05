<?php

namespace App\Modules\FrontArea\Models;

use CodeIgniter\Model;

class InvoiceItemModel extends Model
{
    protected $table = 'invoice_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';

    protected $allowedFields = [
        'uuid',
        'invoice_id',
        'product_id',
        'service_id',
        'description',
        'quantity',
        'price',
        'subtotal',
        'created_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    public function getByInvoice(int $invoiceId)
    {
        return $this->where('invoice_id', $invoiceId)->findAll();
    }
}
