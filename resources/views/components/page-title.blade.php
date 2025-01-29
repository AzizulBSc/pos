<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-1 order-md-1 order-first">
            <a href="{{ route('admin.cart.index') }}" title="POS" class="btn btn-primary">
                <i class="bi bi-cart"></i>
            </a>
        </div>
        <div class="col-12 col-md-5 order-md-1 order-first">
            <h3>{{ $title }}</h3>
            <p class="text-subtitle text-muted">{{ $subtitle ?? '' }}</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-last">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>