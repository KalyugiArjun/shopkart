@extends('layouts.app')

@section('title', 'Group Buy & Save More - ShopKart Marketplace')

@section('content')
<div class="container">
    <div class="card border-0 shadow-sm p-4 mb-4 bg-danger text-white rounded-4 overflow-hidden position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-danger px-3 py-1 rounded-pill fw-bold mb-2">
                    <i class="bi bi-people-fill"></i> Community Buying Power
                </span>
                <h2 class="display-6 fw-bold mb-2">Shop Together, Save Bigger!</h2>
                <p class="text-light opacity-90 mb-0">Join an existing buying circle or launch your own group buy. When target participants join, everyone unlocks massive group discounts!</p>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-people text-white" style="font-size: 5rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>

    <!-- Active Groups Grid (Section 22) -->
    <h4 class="fw-bold mb-3"><i class="bi bi-fire text-danger me-2"></i> Active Group Deals</h4>

    @if($activeGroups->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center mb-5">
            <p class="text-muted">No group buying campaigns currently active. Be the first to start a group buy below!</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            @foreach($activeGroups as $group)
                <div class="col">
                    <div class="sk-group-card shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-danger text-uppercase px-2 py-1">Save {{ round((($group->original_price - $group->discounted_price) / $group->original_price) * 100) }}% Off</span>
                                <span class="badge bg-light text-dark border"><i class="bi bi-clock"></i> {{ $group->expires_at->diffForHumans() }}</span>
                            </div>

                            <div class="text-center my-3">
                                <img src="{{ $group->product->thumbnail }}" class="img-fluid rounded" alt="{{ $group->product->name }}" style="height: 140px; object-fit: cover;">
                            </div>

                            <h6 class="fw-bold mb-1">{{ Str::limit($group->product->name, 45) }}</h6>
                            <small class="text-muted d-block mb-2">Started by {{ $group->creator->name }} &bull; Sold by {{ $group->product->seller->store_name }}</small>

                            <div class="d-flex align-items-baseline gap-2 mb-3">
                                <span class="fs-4 fw-bold text-danger">₹{{ number_format($group->discounted_price) }}</span>
                                <span class="text-muted text-decoration-line-through small">₹{{ number_format($group->original_price) }}</span>
                            </div>

                            <!-- Progress -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Buyers: <strong>{{ $group->current_buyers }}/{{ $group->target_buyers }}</strong></span>
                                    <span class="text-danger fw-semibold">{{ $group->remaining_buyers }} more needed!</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width: {{ $group->progress_percentage }}%;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="small text-secondary">Code: <code>{{ $group->group_code }}</code></span>
                            <a href="{{ route('group-buying.show', $group->group_code) }}" class="btn btn-sm btn-danger fw-bold">
                                Join Deal
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Eligible Products to Start a Group Buy -->
    <h4 class="fw-bold mb-3"><i class="bi bi-plus-circle text-primary me-2"></i> Start a New Group Buy</h4>
    <p class="text-muted small mb-4">Choose any eligible product below to initiate a new 48-hour group deal for your circle:</p>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-5">
        @foreach($eligibleProducts as $prod)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm p-3">
                    <img src="{{ $prod->thumbnail }}" class="card-img-top rounded mb-2" alt="{{ $prod->name }}" style="height: 140px; object-fit: cover;">
                    <h6 class="fw-bold mb-1 fs-6">{{ Str::limit($prod->name, 35) }}</h6>
                    <div class="fw-bold text-dark mb-2">₹{{ number_format($prod->effective_price) }}</div>
                    
                    <form action="{{ route('group-buying.create', $prod->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <div class="mb-2">
                            <select name="target_buyers" class="form-select form-select-sm">
                                <option value="2">2 Buyers (10% Off: ₹{{ number_format(round($prod->effective_price * 0.90)) }})</option>
                                <option value="5">5 Buyers (18% Off: ₹{{ number_format(round($prod->effective_price * 0.82)) }})</option>
                                <option value="10">10 Buyers (25% Off: ₹{{ number_format(round($prod->effective_price * 0.75)) }})</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm w-100 fw-semibold">
                            Launch Group Buy
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
