<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Pending</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <svg class="text-warning" style="font-size: 5rem;" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                            </svg>
                        </div>
                        <h2 class="mb-3">Payment Pending</h2>
                        <p class="text-muted mb-4">
                            Your payment is being processed. Please wait for confirmation.
                        </p>
                        <?php if ($order_id): ?>
                        <p class="mb-4">
                            <strong>Order ID:</strong> <?php echo $order_id; ?>
                        </p>
                        <?php endif; ?>
                        <div class="alert alert-warning">
                            <small>You will receive a notification once the payment is confirmed.</small>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="<?php echo base_url('client/dashboard'); ?>" class="btn btn-primary">Back to Dashboard</a>
                            <a href="<?php echo base_url('client/invoices'); ?>" class="btn btn-outline-primary">View Invoices</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
