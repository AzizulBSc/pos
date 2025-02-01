<div class="btn-group">
    @can('update_product')
    <a href="{{ route('admin.products.edit', $row->id) }}" class="btn btn-sm btn-primary">
        <i class="bi bi-pencil"></i>
    </a>
    @endcan
    @can('create_purchase')
    <a class="btn btn-sm btn-success" href="{{route('admin.purchases.create', ['barcode' => $row->sku])}}" title="Purchase">
        <i class="fas fa-cart-plus"></i>
    </a>
    @endcan
    @can('delete_product')
    <a href="javascript:void(0)" onclick="deleteResource('{{ route('admin.products.destroy', $row->id) }}')"
        class="btn btn-sm btn-danger">
        <i class="bi bi-trash"></i>
    </a>
    @endcan
</div>