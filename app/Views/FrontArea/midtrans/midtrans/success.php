<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="bi bi-check-circle text-success" style="font-size: 5rem;"></i>
                            <svg class="text-success" style="font-size: 5rem;" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        </div>
                        <h2 class="mb-3">Payment Successful!</h2>
                        <p class="text-muted mb-4">
                            Your payment has been successfully processed.
                        </p>
                        <?php if ($order_id): ?>
                        <p class="mb-4">
                            <strong>Order ID:</strong> <?php echo $order_id; ?>
                        </p>
                        <?php endif; ?>
                        <div class="d-grid gap-2">
                            <a href="<?php echo base_url('client/dashboard'); ?>" class="btn btn-primary">Back to Dashboard</a>
                            <a href="<?php echo base_url('client/orders'); ?>" class="btn btn-outline-primary">View Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
