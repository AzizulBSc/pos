<div class="btn-group">
    @can('update_supplier')
        <a href="{{ route('admin.suppliers.edit', $row->id) }}" class="btn btn-sm btn-primary">
            <i class="bi bi-pencil"></i>
        </a>
    @endcan

    @can('delete_supplier')
        <a href="javascript:void(0)" onclick="deleteResource('{{ route('admin.suppliers.destroy', $row->id) }}')"
            class="btn btn-sm btn-danger">
            <i class="bi bi-trash"></i>
        </a>
    @endcan
</div>