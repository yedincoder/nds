<h1>My Invoices</h1>
<table class="table">
    <thead>
        <tr>
            <th>Invoice ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {{each invoices}}
        <tr>
            <td>#{{this.id}}</td>
            <td>{{this.created_at}}</td>
            <td>${{this.amount}}</td>
            <td>{{this.status}}</td>
            <td>
                <a href="#" class="btn btn-sm btn-primary">View</a>
                <a href="#" class="btn btn-sm btn-success">Pay</a>
            </td>
        </tr>
        {{/each}}
    </tbody>
</table>
<div class="mt-4">
    {{pager}}
</div>
