<div class="btn-group">
    @can('update_sale')
    <a href="{{ route('admin.sales.invoice', $row->id) }}" class="btn btn-sm btn-primary" title="Sale Invoice">
        <i class="fas fa-file-invoice"></i>
    </a>
    @endcan
    @can('update_sale')
    @if ($row->due > 0)
    <a href="{{ route('admin.sales.payments.create', $row->id) }}" class="btn btn-sm btn-success" title="Add Payments">
        <i class="fas fa-money-bill-wave"></i>
    </a>
    @endif
    @endcan
    @can('update_sale')
    <a href="{{ route('admin.sales.payments', $row->id) }}" class="btn btn-sm btn-warning" title="Payment List">
        <i class="fas fa-list"></i>
    </a>
    @endcan
</div>