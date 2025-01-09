<div class="btn-group">
    @can('update_purchase')
    <a href="{{ route('admin.purchases.edit', $row->id) }}" class="btn btn-sm btn-primary">
        <i class="bi bi-pencil"></i>
    </a>
    @endcan
    @can('update_purchase')
    <a href="{{ route('admin.purchases.edit', $row->id) }}" class="btn btn-sm btn-primary">
        <i class="bi bi-cart"></i>
    </a>
    @endcan
    @can('delete_purchase')
    <a href="javascript:void(0)" onclick="deleteResource('{{ route('admin.purchases.destroy', $row->id) }}')"
        class="btn btn-sm btn-danger">
        <i class="bi bi-trash"></i>
    </a>
    @endcan
</div>