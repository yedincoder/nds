<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MidtransConfig extends BaseConfig
{
    public $serverKey = '';
    public $clientKey = '';
    public $isProduction = false;
    public $merchantId = '';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->serverKey = getenv('MIDTRANS_SERVER_KEY');
        $this->clientKey = getenv('MIDTRANS_CLIENT_KEY');
        $this->isProduction = getenv('MIDTRANS_IS_PRODUCTION') === 'true';
        $this->merchantId = getenv('MIDTRANS_MERCHANT_ID');
    }
}
