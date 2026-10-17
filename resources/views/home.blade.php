@extends('layouts.app')

@section('title', "ShopKart - India's Multi-Vendor Marketplace | Shop Local • Fast Delivery")

@section('content')
<div class="container">

    <!-- 1. Hero Section -->
    <div class="sk-hero mb-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                    <i class="bi bi-geo-alt-fill"></i> Serving {{ $userCity }} & 50+ Indian Cities
                </span>
                <h1 class="display-5 fw-extrabold text-white mb-3">
                    India's Multi-Vendor Marketplace
                </h1>
                <p class="lead text-light opacity-90 mb-4">
                    Shop Local • Fast 30-Min Delivery • Transparent Price Comparisons • Group Buying Deals
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('nearby.index') }}" class="btn btn-warning fw-bold px-4 py-2">
                        <i class="bi bi-shop me-1"></i> Nearby Sellers
                    </a>
                    <a href="{{ route('fast-delivery.index') }}" class="btn btn-outline-light fw-bold px-4 py-2">
                        <i class="bi bi-lightning-charge-fill text-warning me-1"></i> Fast Delivery (<30m)
                    </a>
                    <a href="{{ route('ai.index') }}" class="btn btn-danger fw-bold px-4 py-2">
                        <i class="bi bi-robot me-1"></i> Ask ShopKart AI
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-end">
                <div class="p-3 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-20 backdrop-blur">
                    <div class="d-flex align-items-center gap-3 text-start mb-3">
                        <div class="bg-warning text-dark p-3 rounded-circle"><i class="bi bi-shield-check fs-3"></i></div>
                        <div>
                            <div class="text-white fw-bold">Verified Indian Merchants</div>
                            <small class="text-light">Transparent trust scores & certified GST credentials</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 text-start">
                        <div class="bg-success text-white p-3 rounded-circle"><i class="bi bi-tags fs-3"></i></div>
                        <div>
                            <div class="text-white fw-bold">Multi-Vendor Price Match</div>
                            <small class="text-light">Compare multiple sellers selling the same product</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Popular Categories (Visual Tiles) -->
    <div class="mb-5">
        <div class="sk-section-header">
            <div>
                <h2 class="sk-section-title"><i class="bi bi-grid text-warning"></i> Explore Popular Categories</h2>
                <small class="text-muted">Handpicked collections across Indian top sellers</small>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-link text-decoration-none text-warning fw-bold">View All Categories</a>
        </div>
        @php
            $catImages = [
                'fashion' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?w=400&h=400&fit=crop',
                'footwear' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop',
                'electronics' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400&h=400&fit=crop',
                'mobiles' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop',
                'watches' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?w=400&h=400&fit=crop',
                'home-kitchen' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?w=400&h=400&fit=crop',
                'handicrafts' => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=400&h=400&fit=crop',
                'sports-fitness' => 'https://images.unsplash.com/photo-1614632537423-1e6c2e7e0aab?w=400&h=400&fit=crop',
                'grocery' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=400&h=400&fit=crop',
                'beauty' => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=400&h=400&fit=crop',
                'luggage' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop',
                'jewelry' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=400&h=400&fit=crop',
                'books' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=400&fit=crop',
                'toys' => 'https://images.unsplash.com/photo-1585366119957-e9730b6d0f60?w=400&h=400&fit=crop',
                'automotive' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=400&h=400&fit=crop',
            ];
        @endphp
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-4 g-3">
            @foreach($categories->take(8) as $cat)
                <div class="col">
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="card h-100 text-decoration-none border-0 shadow-sm rounded-4 overflow-hidden position-relative group hover-lift transition">
                        <div class="position-relative" style="height: 140px; overflow: hidden; background: #e2e8f0;">
                            <img src="{{ $catImages[$cat->slug] ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop' }}" alt="{{ $cat->name }}" class="w-100 h-100 object-fit-cover transition transform-scale" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop';">
                            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(15,23,42,0.85) 100%);"></div>
                            <div class="position-absolute bottom-0 start-0 p-3 text-white">
                                <span class="badge bg-warning text-dark mb-1" style="font-size: 0.65rem;">
                                    <i class="bi {{ $cat->icon ?: 'bi-tag' }} me-1"></i> Featured
                                </span>
                                <div class="fw-bold fs-6 mb-0">{{ $cat->name }}</div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 3. Nearby Sellers (USP #8) -->
    <div class="mb-5">
        <div class="sk-section-header">
            <div>
                <h2 class="sk-section-title">
                    <i class="bi bi-shop text-primary"></i> Nearby Sellers Around You
                </h2>
                <small class="text-muted">Direct doorstep dispatch from verified stores in {{ $userCity }}</small>
            </div>
            <a href="{{ route('nearby.index') }}" class="btn btn-sm btn-outline-primary fw-semibold">
                <i class="bi bi-map me-1"></i> Interactive Map View
            </a>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($nearbySellers as $seller)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $seller->store_logo ?: 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=100&h=100&fit=crop' }}" alt="{{ $seller->store_name }}" class="rounded-circle border" style="width: 55px; height: 55px; object-fit: cover;">
                            <div>
                                <h5 class="mb-0 fw-bold fs-6">{{ $seller->store_name }}</h5>
                                <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $seller->city }}, {{ $seller->state }}</small>
                                <div class="mt-1 d-flex align-items-center gap-2">
                                    <span class="badge bg-warning text-dark"><i class="bi bi-star-fill text-dark"></i> {{ $seller->rating }}</span>
                                    <span class="sk-trust-badge"><i class="bi bi-shield-check"></i> {{ $seller->trust_score }}% Trust</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($seller->store_tagline ?: $seller->about_store, 90) }}</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <div class="small fw-semibold text-success">
                                <i class="bi bi-clock-history"></i> {{ $seller->estimated_delivery_minutes }} min delivery
                                @if(isset($seller->distance))
                                    &bull; <span class="text-secondary">{{ $seller->distance }} km away</span>
                                @endif
                            </div>
                            <a href="{{ route('seller.storefront', $seller->slug) }}" class="btn btn-sm btn-sk-outline">
                                Visit Store
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 4. Group Buying & Save (USP #22) -->
    @if($groupBuyingGroups->isNotEmpty())
    <div class="mb-5">
        <div class="sk-section-header">
            <div>
                <h2 class="sk-section-title text-danger">
                    <i class="bi bi-people-fill"></i> Group Buy & Save More
                </h2>
                <small class="text-muted">Team up with buyers to unlock wholesale tier pricing</small>
            </div>
            <a href="{{ route('group-buying.index') }}" class="btn btn-sm btn-outline-danger fw-semibold">View All Group Deals</a>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($groupBuyingGroups as $group)
                <div class="col">
                    <div class="sk-group-card shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-danger text-uppercase px-2 py-1">Save {{ round((($group->original_price - $group->discounted_price) / $group->original_price) * 100) }}% Off</span>
                                <span class="badge bg-light text-dark border"><i class="bi bi-clock"></i> Expires {{ $group->expires_at->diffForHumans() }}</span>
                            </div>
                            <div class="row align-items-center gy-3 mb-3">
                                <div class="col-4">
                                    <img src="{{ $group->product->thumbnail }}" class="img-fluid rounded" alt="{{ $group->product->name }}" style="max-height: 120px; object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop';">
                                </div>
                                <div class="col-8">
                                    <h6 class="fw-bold mb-1">{{ Str::limit($group->product->name, 50) }}</h6>
                                    <small class="text-muted d-block mb-1">Sold by {{ $group->product->seller->store_name }}</small>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <span class="fs-4 fw-bold text-danger">₹{{ number_format($group->discounted_price) }}</span>
                                        <span class="text-muted text-decoration-line-through small">₹{{ number_format($group->original_price) }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Progress Bar -->
                            <div class="mb-2">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Buyers Joined: <strong>{{ $group->current_buyers }}/{{ $group->target_buyers }}</strong></span>
                                    <span class="text-danger fw-semibold">{{ $group->remaining_buyers }} more needed!</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width: {{ $group->progress_percentage }}%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <span class="small text-secondary">Code: <code>{{ $group->group_code }}</code></span>
                            <a href="{{ route('group-buying.show', $group->group_code) }}" class="btn btn-sm btn-danger fw-bold px-3">
                                Join This Deal
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 5. Fast Delivery Near You (<45 mins) (USP #9) -->
    <div class="mb-5">
        <div class="sk-section-header">
            <div>
                <h2 class="sk-section-title">
                    <i class="bi bi-lightning-charge-fill text-warning"></i> Fast Delivery Near You
                </h2>
                <small class="text-muted">Delivered in 20-45 minutes from local stores</small>
            </div>
            <a href="{{ route('fast-delivery.index') }}" class="btn btn-sm btn-link text-warning fw-bold text-decoration-none">View All Fast Deliveries</a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($fastDeliveryProducts->take(4) as $product)
                <div class="col">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>

    <!-- 6. Today's Best Deals -->
    <div class="mb-5">
        <div class="sk-section-header">
            <div>
                <h2 class="sk-section-title">
                    <i class="bi bi-tag-fill text-danger"></i> Today's Best Deals
                </h2>
                <small class="text-muted">Top discounts on verified electronics, ethnic wear & living</small>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-link text-warning fw-bold text-decoration-none">Explore Catalog</a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($todaysDeals->take(4) as $product)
                <div class="col">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>

    <!-- 7. Price Drop Alerts (USP #20 & #21) -->
    @if($priceDrops->isNotEmpty())
    <div class="mb-5">
        <div class="sk-section-header">
            <div>
                <h2 class="sk-section-title text-success">
                    <i class="bi bi-graph-down-arrow"></i> Recent Price Drops
                </h2>
                <small class="text-muted">Products whose price dropped recently in the last few days</small>
            </div>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($priceDrops->take(4) as $product)
                <div class="col">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 8. Personalized Recommendations (USP #25) -->
    <div class="mb-5">
        <div class="sk-section-header">
            <div>
                <h2 class="sk-section-title">
                    <i class="bi bi-stars text-warning"></i> Recommended For You
                </h2>
                <small class="text-muted">Curated based on trending items and browsing interest</small>
            </div>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($recommendations->take(4) as $product)
                <div class="col">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
