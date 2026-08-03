<h1>Dashboard</h1>
<p>Welcome to your dashboard.</p>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>Total Orders</h5>
                <p class="display-4">{{stats.total_orders}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>Pending Orders</h5>
                <p class="display-4">{{stats.pending_orders}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>Unpaid Invoices</h5>
                <p class="display-4">{{stats.unpaid_invoices}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>Available Downloads</h5>
                <p class="display-4">{{stats.available_downloads}}</p>
            </div>
        </div>
    </div>
</div>

<h2>Recent Orders</h2>
<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        {{each recentOrders}}
        <tr>
            <td>#{{this.id}}</td>
            <td>{{this.created_at}}</td>
            <td>{{this.status}}</td>
            <td>${{this.total}}</td>
        </tr>
        {{/each}}
    </tbody>
</table>

<h2>Recent Invoices</h2>
<table class="table">
    <thead>
        <tr>
            <th>Invoice ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        {{each recentInvoices}}
        <tr>
            <td>#{{this.id}}</td>
            <td>{{this.created_at}}</td>
            <td>${{this.amount}}</td>
            <td>{{this.status}}</td>
        </tr>
        {{/each}}
    </tbody>
</table>
