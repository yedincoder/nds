<h1>My Orders</h1>
<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {{each orders}}
        <tr>
            <td>#{{this.id}}</td>
            <td>{{this.created_at}}</td>
            <td>{{this.status}}</td>
            <td>${{this.total}}</td>
            <td>
                <a href="#" class="btn btn-sm btn-primary">View</a>
                <a href="#" class="btn btn-sm btn-danger">Cancel</a>
            </td>
        </tr>
        {{/each}}
    </tbody>
</table>
<div class="mt-4">
    {{pager}}
</div>
