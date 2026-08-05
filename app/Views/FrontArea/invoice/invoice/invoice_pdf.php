<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= esc($invoice->invoice_number) ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .invoice-header {
            border-bottom: 3px solid #E65C00;
            padding-bottom: 15px;
            margin-bottom: 25px;
            overflow: hidden;
        }
        .invoice-header .company {
            float: left;
        }
        .invoice-header .company h1 {
            font-size: 22px;
            color: #E65C00;
            margin-bottom: 3px;
        }
        .invoice-header .company p {
            font-size: 11px;
            color: #666;
        }
        .invoice-header .invoice-title {
            float: right;
            text-align: right;
        }
        .invoice-header .invoice-title h2 {
            font-size: 26px;
            color: #333;
            margin-bottom: 5px;
        }
        .invoice-header .invoice-title p {
            font-size: 12px;
            color: #666;
        }
        .invoice-meta {
            margin-bottom: 25px;
            overflow: hidden;
        }
        .bill-to {
            float: left;
            width: 50%;
        }
        .invoice-details {
            float: right;
            width: 45%;
            text-align: right;
        }
        .invoice-meta h5 {
            font-size: 13px;
            color: #E65C00;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .invoice-meta p {
            font-size: 11px;
            color: #333;
            margin-bottom: 2px;
        }
        .invoice-meta strong {
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background: #E65C00;
            color: #fff;
            font-size: 11px;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: left;
        }
        table td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            font-size: 11px;
        }
        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        table tfoot td {
            font-weight: bold;
            background: #f5f5f5;
        }
        .total-row td {
            font-size: 14px;
            background: #E65C00 !important;
            color: #fff;
        }
        .text-right {
            text-align: right;
        }
        .invoice-footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        .invoice-footer .thanks {
            font-size: 13px;
            color: #E65C00;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
	
	<table>
	<tr>
		<td colspan="2" style="text-align:center">		
            <h1>NGAPPID DIGITAL</h1>
            <p>PT. YEDIN DIGITAL MANDIRI<br>
            Jl. RA. Kartini No.23L, Rangkasbitung<br>
            Lebak, Banten 42314<br>
            info@ngappid.com · 08977487315</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center"></td>
	</tr>
	<tr>
		<td style="text-align:left">
            <h5>Bill To</h5>
            <p><strong><?= esc($invoice->billing_name ?? 'Customer') ?></strong></p>
            <p><?= esc($invoice->billing_email ?? '') ?></p>
            <p><?= esc($invoice->billing_phone ?? '') ?></p>
            <?php if (!empty($invoice->billing_address)): ?>
            <p><?= esc($invoice->billing_address) ?><br><?= esc($invoice->billing_city ?? '') ?>, <?= esc($invoice->billing_province ?? '') ?></p>
            <?php endif; ?>
		</td>
		<td style="text-align:right">
            <h5>Invoice Details</h5>
            <p><strong>Invoice #:</strong> <?= esc($invoice->invoice_number) ?></p>
            <p><strong>Tanggal:</strong> <?= date('d M Y', strtotime($invoice->created_at ?? 'now')) ?></p>
            <p><strong>Jatuh Tempo:</strong> <?= $invoice->due_date ? date('d M Y', strtotime($invoice->due_date)) : '-' ?></p>
            <p><strong>Status:</strong> <?= esc(ucfirst($invoice->status ?? 'unpaid')) ?></p>
		</td>
	</tr>
	</table>
	<table>
	<tr>
		<td style="text-align:center">
            <h2>INVOICE</h2>
            <p>No. <?= esc($invoice->invoice_number) ?></p>
		</td>
	</tr>
	</table>

    <table>
        <thead>
            <tr>
                <th style="width:55%">Deskripsi</th>
                <th style="width:10%" class="text-right">Qty</th>
                <th style="width:17%" class="text-right">Harga</th>
                <th style="width:18%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($invoice->items)): ?>
                <?php foreach ($invoice->items as $item): ?>
                    <tr>
                        <td><?= esc($item->description ?? $item->name ?? 'Item') ?></td>
                        <td class="text-right"><?= (int) $item->quantity ?></td>
                        <td class="text-right"><?= format_price($item->price) ?></td>
                        <td class="text-right"><?= format_price($item->subtotal) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-right">No items</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right">Subtotal</td>
                <td class="text-right"><?= format_price($invoice->subtotal ?? 0) ?></td>
            </tr>
            <?php if (($invoice->discount ?? 0) > 0): ?>
                <tr>
                    <td colspan="3" class="text-right">Diskon</td>
                    <td class="text-right">-<?= format_price($invoice->discount) ?></td>
                </tr>
            <?php endif; ?>
            <?php if (($invoice->tax ?? 0) > 0): ?>
                <tr>
                    <td colspan="3" class="text-right">Pajak</td>
                    <td class="text-right"><?= format_price($invoice->tax) ?></td>
                </tr>
            <?php endif; ?>
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL</td>
                <td class="text-right"><?= format_price($invoice->total ?? 0) ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="invoice-footer">
        <div class="thanks">Terima kasih atas kepercayaan Anda!</div>
        <p>PT. YEDIN DIGITAL MANDIRI · Jl. RA. Kartini No.23L, Rangkasbitung, Lebak, Banten 42314<br>
        Email: info@ngappid.com · Telp/WA: 08977487315</p>
    </div>
</body>
</html>
