<div class="btn-group">
    @can('update_purchase')
    <a href="{{ route('admin.purchases.create', ['purchase_id' => $row->id]) }}" class="btn btn-sm btn-primary">
        <i class="bi bi-pencil"></i>
    </a>
    @endcan
    @can('update_purchase')
    <a href="{{ route('admin.purchase.products', $row->id) }}" class="btn btn-sm btn-success">
        <i class="bi bi-eye"></i>
    </a>
    @endcan
</div>