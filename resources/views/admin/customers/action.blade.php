<div class="btn-group">
    @can('update_customer')
        <a href="{{ route('admin.customers.edit', $row->id) }}" class="btn btn-sm btn-primary">
            <i class="bi bi-pencil"></i>
        </a>
    @endcan

    @can('delete_customer')
        <a href="javascript:void(0)" onclick="deleteResource('{{ route('admin.customers.destroy', $row->id) }}')"
            class="btn btn-sm btn-danger">
            <i class="bi bi-trash"></i>
        </a>
    @endcan
</div>