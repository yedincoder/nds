<?php

namespace App\Modules\Midtrans\Libraries;

class MidtransLibrary
{
    protected $serverKey;
    protected $clientKey;
    protected $isProduction;
    protected $apiUrl;

    public function __construct()
    {
        $config = config('MidtransConfig');
        
        $this->serverKey = $config->serverKey ?? getenv('MIDTRANS_SERVER_KEY');
        $this->clientKey = $config->clientKey ?? getenv('MIDTRANS_CLIENT_KEY');
        $this->isProduction = $config->isProduction ?? (getenv('MIDTRANS_IS_PRODUCTION') === 'true');
        
        $this->apiUrl = $this->isProduction ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com';
    }

    public function snapToken(array $transactionDetails): ?string
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . '/v2/snap/transactions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->serverKey . ':'),
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'transaction_details' => $transactionDetails,
                'credit_card' => [
                    'secure' => true
                ],
            ]),
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            log_message('error', 'Midtrans API error: ' . $err);
            return null;
        }

        if ($httpCode >= 400) {
            log_message('error', 'Midtrans API HTTP ' . $httpCode . ': ' . $response);
            return null;
        }

        $data = json_decode($response, true);
        
        return $data['token'] ?? null;
    }

    public function verifyPayment(string $transactionId): ?array
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . '/v2/' . $transactionId . '/status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => false,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->serverKey . ':'),
            ],
        ]);

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
