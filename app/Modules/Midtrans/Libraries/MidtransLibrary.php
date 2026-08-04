<?php

namespace App\Modules\Midtrans\Libraries;

class MidtransLibrary
{
    protected $serverKey;
    protected $clientKey;
    protected $isProduction;
    protected $apiUrl;
    protected $snapUrl;

    public function __construct()
    {
        $config = config('MidtransConfig');
        
        $this->serverKey = $config->serverKey ?? getenv('MIDTRANS_SERVER_KEY');
        $this->clientKey = $config->clientKey ?? getenv('MIDTRANS_CLIENT_KEY');
        $this->isProduction = $config->isProduction ?? (getenv('MIDTRANS_IS_PRODUCTION') === 'true');
        
        // Core API untuk status & verify
        $this->apiUrl = $this->isProduction ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com';
        // Snap API untuk token generation
        $this->snapUrl = $this->isProduction ? 'https://app.midtrans.com' : 'https://app.sandbox.midtrans.com';
    }

    public function snapToken(array $transactionDetails): ?string
    {
        $result = $this->createSnapTransaction($transactionDetails);
        return $result['token'] ?? null;
    }

    /**
     * Create Snap transaction and return full response (token + redirect_url)
     *
     * @param array $payload Struktur lengkap Midtrans: 
     *                       ['transaction_details'=>[...], 'customer_details'=>[...], 'item_details'=>[...]]
     */
    public function createSnapTransaction(array $payload): ?array
    {
        log_message('error', 'MidtransLibrary::createSnapTransaction() called - isProduction: ' . ($this->isProduction ? 'true' : 'false') . ', snapUrl: ' . $this->snapUrl);
        log_message('error', 'MidtransLibrary::createSnapTransaction() payload: ' . json_encode($payload));
        
        $curl = curl_init();
        
        $curlOptions = [
            CURLOPT_URL => $this->snapUrl . '/snap/v1/transactions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->serverKey . ':'),
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
        ];
        
        // Disable SSL verification for sandbox (Windows PHP compatibility)
        if (!$this->isProduction) {
            $curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
            $curlOptions[CURLOPT_SSL_VERIFYHOST] = 0;
        }
        
        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        log_message('error', 'Midtrans API Response: HTTP ' . $httpCode . ' | Error: ' . $err . ' | Response: ' . $response);

        if ($err) {
            log_message('error', 'Midtrans API cURL error: ' . $err);
            return null;
        }

        if ($httpCode >= 400) {
            log_message('error', 'Midtrans API HTTP ' . $httpCode . ': ' . $response);
            return null;
        }

        return json_decode($response, true) ?: null;
    }

    public function verifyPayment(string $transactionId): ?array
    {
        $curl = curl_init();
        
        $curlOptions = [
            CURLOPT_URL => $this->apiUrl . '/v2/' . $transactionId . '/status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => false,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->serverKey . ':'),
            ],
        ];
        
        // Disable SSL verification for sandbox (Windows PHP compatibility)
        if (!$this->isProduction) {
            $curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
            $curlOptions[CURLOPT_SSL_VERIFYHOST] = 0;
        }
        
        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            log_message('error', 'Midtrans verification error: ' . $err);
            return null;
        }

        if ($httpCode >= 400) {
            log_message('error', 'Midtrans verification HTTP ' . $httpCode . ': ' . $response);
            return null;
        }

        return json_decode($response, true);
    }

    public function status(): array
    {
        return [
            'success' => $this->isProduction ? 'production' : 'sandbox',
            'server_key' => $this->serverKey ? 'configured' : 'not_configured',
            'client_key' => $this->clientKey ? 'configured' : 'not_configured',
        ];
    }
}
