<div class="btn-group">
    @can('update_product')
    <a href="{{ route('admin.products.edit', $row->id) }}" class="btn btn-sm btn-primary">
        <i class="bi bi-pencil"></i>
    </a>
    @endcan
    @can('update_product')
    <a href="{{ route('admin.products.edit', $row->id) }}" class="btn btn-sm btn-primary">
        <i class="bi bi-cart"></i>
    </a>
    @endcan
    @can('delete_product')
    <a href="javascript:void(0)" onclick="deleteResource('{{ route('admin.products.destroy', $row->id) }}')"
        class="btn btn-sm btn-danger">
        <i class="bi bi-trash"></i>
    </a>
    @endcan
</div>