<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <svg class="text-danger" style="font-size: 5rem;" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                            </svg>
                        </div>
                        <h2 class="mb-3">Payment Failed</h2>
                        <p class="text-muted mb-4">
                            Unfortunately, your payment could not be processed.
                        </p>
                        <?php if ($order_id): ?>
                        <p class="mb-4">
                            <strong>Order ID:</strong> <?php echo $order_id; ?>
                        </p>
                        <?php endif; ?>
                        <div class="alert alert-danger">
                            <small>Please try again or contact our support team if the problem persists.</small>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="<?php echo base_url('client/invoices'); ?>" class="btn btn-primary">Try Again</a>
                            <a href="<?php echo base_url('client/dashboard'); ?>" class="btn btn-outline-primary">Back to Dashboard</a>
                            <a href="<?php echo base_url('support/tickets'); ?>" class="btn btn-outline-secondary">Contact Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
