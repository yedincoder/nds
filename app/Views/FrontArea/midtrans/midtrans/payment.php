<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - <?php echo $invoice->invoice_number; ?></title>
    <script src="<?php echo $snap_url; ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="text-center">Payment for <?php echo $invoice->invoice_number; ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>Payment Details:</strong><br>
                            Invoice: <?php echo $invoice->invoice_number; ?><br>
                            Total: Rp <?php echo number_format($invoice->total, 2, ',', '.'); ?><br>
                            <br>
                            <small>Redirecting to Midtrans payment page...</small>
                        </div>

                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status" id="loadingSpinner">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <div id="errorContainer" style="display:none;" class="alert alert-danger mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            var snapToken = '<?php echo $snap_token; ?>';
            var clientKey = '<?php echo $client_key; ?>';
            
            console.log('Snap Token:', snapToken ? 'exists (' + snapToken.length + ' chars)' : 'EMPTY');
            console.log('Client Key:', clientKey ? 'exists' : 'EMPTY');
            
            if (!snapToken || snapToken === '') {
                $('#loadingSpinner').hide();
                $('#errorContainer').html('Payment token not found. Please try again.').show();
                return;
            }
            
            if (typeof snap === 'undefined') {
                $('#loadingSpinner').hide();
                $('#errorContainer').html('Midtrans Snap library failed to load. Please check your internet connection.').show();
                return;
            }
            
            try {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        console.log('Success:', result);
                        window.location.href = '/payment/midtrans/success';
                    },
                    onPending: function(result) {
                        console.log('Pending:', result);
                        window.location.href = '/payment/midtrans/pending';
                    },
                    onError: function(result) {
                        console.log('Error:', result);
                        window.location.href = '/payment/midtrans/error';
                    }
                });
            } catch (e) {
                console.error('Snap error:', e);
                $('#loadingSpinner').hide();
                $('#errorContainer').html('Payment error: ' + e.message).show();
            }
        });
    </script>
</body>
</html>
