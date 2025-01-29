<div class="btn-group">
    @can('update_sale')
    <a href="{{ route('admin.sales.invoice', $row->id) }}" class="btn btn-sm btn-primary">
        <i class="fas fa-file-invoice"></i>
    </a>
    @endcan
    @can('update_sale')
    <a href="{{ route('admin.sales.payments.collection', $row->id) }}" class="btn btn-sm btn-success">
        <i class="fas fa-receipt"></i>
    </a>
    @endcan
    @can('update_sale')
    <a href="{{ route('admin.sales.payments', $row->id) }}" class="btn btn-sm btn-primary">
        <i class="fas fa-exchange-alt"></i>
    </a>
    @endcan
</div>