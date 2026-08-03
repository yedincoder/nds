<h1>My Downloads</h1>
<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Order #</th>
            <th>Download Count</th>
            <th>Max Downloads</th>
            <th>Expires At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {{each downloads}}
        <tr>
            <td>{{this.product_name}}</td>
            <td>#{{this.order_number}}</td>
            <td>{{this.download_count}}</td>
            <td>{{this.max_downloads}}</td>
            <td>{{this.expires_at}}</td>
            <td>
                <a href="#" class="btn btn-sm btn-primary">Download</a>
            </td>
        </tr>
        {{/each}}
    </tbody>
</table>
<div class="mt-4">
    {{pager}}
</div>
