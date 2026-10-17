@extends('layouts.app')

@section('title', $product->name . ' - Compare Sellers on ShopKart')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 35) }}</li>
        </ol>
    </nav>

    <!-- Product Overview Grid -->
    <div class="row gy-4 mb-5">
        <!-- 1. Product Image & Gallery -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-3 sticky-top" style="top: 90px;">
                <div class="text-center mb-3 position-relative">
                    <img id="mainProductImage" src="{{ $product->thumbnail ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop' }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}" style="max-height: 400px; width: 100%; object-fit: contain;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop';">
                    @if($product->discount_percentage > 0)
                        <span class="sk-badge-discount position-absolute top-0 end-0 m-2">{{ $product->discount_percentage }}% OFF</span>
                    @endif
                </div>

                @if(!empty($product->images) && is_array($product->images) && count($product->images) > 1)
                    <div class="d-flex gap-2 justify-content-center mb-3">
                        @foreach($product->images as $img)
                            <img src="{{ $img }}" class="rounded border p-1 cursor-pointer hover-shadow" style="width: 55px; height: 55px; object-fit: cover; cursor: pointer;" onclick="document.getElementById('mainProductImage').src = this.src" title="Click to view">
                        @endforeach
                    </div>
                @endif
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#priceAlertModal">
                        <i class="bi bi-bell-fill"></i> Set Price Drop Alert
                    </button>
                    @auth
                        <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-heart"></i> Add to Wishlist
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

        <!-- 2. Product Details & Purchase Controls -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 h-100">
                <!-- Seller Trust Banner -->
                <div class="d-flex align-items-center justify-content-between p-2 mb-3 bg-light rounded border">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-shop text-primary fs-5"></i>
                        <div>
                            <span class="small text-muted">Sold by:</span>
                            <a href="{{ route('seller.storefront', $product->seller->slug) }}" class="fw-bold text-dark text-decoration-none ms-1">
                                {{ $product->seller->store_name }}
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> {{ $product->seller->rating }}</span>
                        <span class="sk-trust-badge">{{ $product->seller->trust_score }}% Trust Score</span>
                    </div>
                </div>

                <h1 class="h3 fw-bold mb-2">{{ $product->name }}</h1>

                <!-- Rating & Reviews Count -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-success px-2 py-1"><i class="bi bi-star-fill"></i> {{ $product->rating }}</span>
                    <span class="text-muted small">{{ $product->total_reviews }} Ratings & Verified Buyer Reviews</span>
                    <span class="text-secondary">&bull;</span>
                    <span class="text-muted small">SKU: <code>{{ $product->sku }}</code></span>
                </div>

                <!-- Price Box -->
                <div class="p-3 mb-4 bg-light rounded-3 d-flex align-items-baseline gap-3">
                    <span class="display-6 fw-bold text-dark" id="displayPrice">₹{{ number_format($product->effective_price) }}</span>
                    @if($product->discount_price && $product->discount_price < $product->price)
                        <span class="text-muted text-decoration-line-through fs-5">₹{{ number_format($product->price) }}</span>
                        <span class="badge bg-danger fs-6">{{ $product->discount_percentage }}% Savings</span>
                    @endif
                    <span class="text-muted small ms-auto">(Inclusive of {{ $product->tax_percent }}% GST)</span>
                </div>

                <!-- Fast Delivery Guarantee -->
                <div class="alert alert-warning d-flex align-items-center gap-2 mb-4 py-2">
                    <i class="bi bi-lightning-charge-fill fs-4 text-warning"></i>
                    <div>
                        <strong>Fast Local Delivery Available:</strong> Guaranteed delivery in
                        <span class="fw-bold text-dark">{{ $product->delivery_time_minutes }} minutes</span> to your selected area.
                    </div>
                </div>

                <!-- Add to Cart & Buy Now -->
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Variants Selection if available -->
                    @if($product->variants->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Select Variant / Option:</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($product->variants as $variant)
                                    <label class="btn btn-outline-secondary btn-sm">
                                        <input type="radio" name="product_variant_id" value="{{ $variant->id }}" class="d-none" onchange="document.getElementById('displayPrice').innerText = '₹{{ number_format($variant->effective_price) }}'">
                                        {{ $variant->color }} - {{ $variant->size }} (₹{{ number_format($variant->effective_price) }})
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="row g-2 align-items-center mb-3">
                        <div class="col-4 col-sm-3">
                            <label class="form-label small fw-bold text-muted mb-1">Quantity</label>
                            <select name="quantity" class="form-select">
                                @for($q = 1; $q <= min(5, $product->stock); $q++)
                                    <option value="{{ $q }}">{{ $q }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-8 col-sm-9 d-flex gap-2 align-items-end">
                            <button type="submit" class="btn btn-sk-primary flex-grow-1 py-2 fw-bold">
                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Group Buying CTA (USP #22) -->
                <div class="p-3 bg-danger bg-opacity-10 border border-danger rounded-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-danger text-uppercase">Group Buy Special</span>
                            <div class="fw-bold text-dark mt-1">Want to save an extra 15-25% on this item?</div>
                            <small class="text-muted">Start a group buy and invite friends or join existing buyers.</small>
                        </div>
                        <form action="{{ route('group-buying.create', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="target_buyers" value="2">
                            <button type="submit" class="btn btn-danger btn-sm fw-bold text-nowrap">
                                Start Group Buy
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Key Highlights & Return Policy -->
                <div class="row row-cols-2 g-3 pt-3 border-top text-muted small">
                    <div class="col"><i class="bi bi-shield-check text-success me-1"></i> {{ $product->warranty ?: '1 Year Brand Warranty' }}</div>
                    <div class="col"><i class="bi bi-check2-circle text-primary me-1"></i> {{ $product->return_policy }}</div>
                    <div class="col"><i class="bi bi-truck text-warning me-1"></i> Free Shipping on orders over ₹499</div>
                    <div class="col"><i class="bi bi-cash-coin text-success me-1"></i> Cash on Delivery & UPI available</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Smart Multi-Vendor Seller Comparison (Section 7 & 26) -->
    <div class="card border-0 shadow-sm p-4 mb-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <h3 class="fw-bold mb-1"><i class="bi bi-shop text-primary me-2"></i> Smart Seller Comparison</h3>
                <p class="text-muted small mb-0">Transparent multi-vendor comparison. Compare prices, delivery speeds, ratings and trust scores from different verified sellers.</p>
            </div>
            <span class="badge bg-light text-dark border p-2"><i class="bi bi-info-circle text-primary me-1"></i> Direct Store Comparison</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Seller Name & Location</th>
                        <th>Price</th>
                        <th>Seller Rating</th>
                        <th>Delivery Speed</th>
                        <th>Trust Score</th>
                        <th>Return Policy</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Current Selected Seller Row -->
                    <tr class="table-primary border-primary">
                        <td>
                            <div class="fw-bold text-dark">{{ $product->seller->store_name }} <span class="badge bg-primary">Current Choice</span></div>
                            <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $product->seller->city }}</small>
                        </td>
                        <td>
                            <span class="fw-bold text-dark fs-5">₹{{ number_format($product->effective_price) }}</span>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> {{ $product->seller->rating }}</span>
                        </td>
                        <td>
                            <span class="text-success fw-semibold"><i class="bi bi-lightning-fill"></i> {{ $product->delivery_time_minutes }} mins</span>
                        </td>
                        <td>
                            <span class="sk-trust-badge">{{ $product->seller->trust_score }}%</span>
                        </td>
                        <td class="small text-muted">{{ $product->return_policy }}</td>
                        <td class="text-end">
                            <span class="btn btn-sm btn-secondary disabled">Viewing</span>
                        </td>
                    </tr>

                    <!-- Alternative Sellers Selling Same or Similar Items -->
                    @foreach($alternativeSellers as $alt)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $alt->seller->store_name }}</div>
                                <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $alt->seller->city }}</small>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">₹{{ number_format($alt->effective_price) }}</span>
                                @if($alt->effective_price < $product->effective_price)
                                    <small class="text-success d-block fw-semibold">₹{{ number_format($product->effective_price - $alt->effective_price) }} cheaper!</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> {{ $alt->seller->rating }}</span>
                            </td>
                            <td>
                                <span class="text-muted"><i class="bi bi-clock"></i> {{ $alt->delivery_time_minutes }} mins</span>
                            </td>
                            <td>
                                <span class="sk-trust-badge">{{ $alt->seller->trust_score }}%</span>
                            </td>
                            <td class="small text-muted">{{ $alt->return_policy }}</td>
                            <td class="text-end">
                                <a href="{{ route('products.show', $alt->slug) }}" class="btn btn-sm btn-outline-primary">
                                    Switch Seller
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Best Value Recommendation Breakdown (Section 26) -->
        @if($bestValueOffer)
            <div class="mt-4 p-3 bg-light rounded-3 border-start border-4 border-warning">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-warning text-dark fw-bold">★ Best Value Breakdown</span>
                    <strong class="text-dark">{{ $bestValueOffer->seller->store_name }}</strong>
                </div>
                <small class="text-muted">
                    We evaluate transparent metrics: <strong>{{ $bestValueOffer->rating }}★ rating</strong> from {{ $bestValueOffer->total_reviews }} buyers + <strong>{{ $bestValueOffer->seller->trust_score }}% merchant trust score</strong> + fast <strong>{{ $bestValueOffer->delivery_time_minutes }} min local delivery</strong> at ₹{{ number_format($bestValueOffer->effective_price) }}.
                </small>
            </div>
        @endif
    </div>

    <!-- 4. Price History Analysis (Section 20) -->
    <div class="card border-0 shadow-sm p-4 mb-5">
        <h4 class="fw-bold mb-3"><i class="bi bi-graph-up text-success me-2"></i> Product Price History & Trend</h4>
        <p class="text-muted small mb-4">ShopKart tracks authentic price movements so you can make informed purchase decisions without fake discounts.</p>
        
        <div style="height: 250px;">
            <canvas id="priceHistoryChart"></canvas>
        </div>
    </div>

    <!-- 5. Product Description & Specifications -->
    <div class="card border-0 shadow-sm p-4 mb-5">
        <h4 class="fw-bold mb-3">Product Description</h4>
        <div class="text-muted mb-4" style="line-height: 1.8;">
            {!! nl2br(e($product->description)) !!}
        </div>
    </div>

    <!-- 6. Verified Customer Reviews (Section 32) -->
    <div class="card border-0 shadow-sm p-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h4 class="fw-bold mb-0">Customer Reviews & Ratings</h4>
            <div class="d-flex align-items-center gap-2">
                <span class="display-6 fw-bold text-warning">{{ $product->rating }}</span>
                <div>
                    <div class="text-warning">
                        @for($s=1; $s<=5; $s++)
                            <i class="bi bi-star{{ $s <= round($product->rating) ? '-fill' : '' }}"></i>
                        @endfor
                    </div>
                    <small class="text-muted">{{ $product->reviews->count() }} verified buyer reviews</small>
                </div>
            </div>
        </div>

        @if($product->reviews->isEmpty())
            <p class="text-muted">No reviews yet for this product. Be the first verified customer to leave a review!</p>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($product->reviews->take(5) as $review)
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success">{{ $review->rating }} ★</span>
                                <strong class="text-dark">{{ $review->user->name }}</strong>
                                @if($review->is_verified_purchase)
                                    <span class="badge bg-info text-dark" style="font-size: 0.7rem;"><i class="bi bi-patch-check-fill text-primary"></i> Verified Purchase</span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $review->created_at->format('d M, Y') }}</small>
                        </div>
                        @if($review->headline)
                            <h6 class="fw-bold mb-1">{{ $review->headline }}</h6>
                        @endif
                        <p class="text-muted small mb-0">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

<!-- Price Alert Target Modal (Section 21) -->
<div class="modal fade" id="priceAlertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-bell-fill text-warning me-2"></i> Set Price Drop Alert</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('products.price-alert', $product->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small">Current Price: <strong>₹{{ number_format($product->effective_price) }}</strong>. Tell us your target budget price, and we'll alert you the moment the price drops!</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Target Price (₹)</label>
                        <input type="number" name="target_price" class="form-control" max="{{ $product->effective_price - 1 }}" value="{{ round($product->effective_price * 0.9) }}" required>
                        <small class="text-muted">Recommended: ₹{{ number_format(round($product->effective_price * 0.9)) }} (10% drop)</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sk-primary btn-sm px-4">Activate Alert</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Price History Chart (Chart.js)
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('priceHistoryChart').getContext('2d');
        const priceData = @json($product->priceHistories->map(fn($ph) => ['date' => $ph->created_at->format('d M'), 'price' => $ph->new_price]));
        
        // Add current price if needed
        let labels = priceData.map(d => d.date);
        let values = priceData.map(d => d.price);

        if (labels.length === 0) {
            labels = ['Launch', 'Today'];
            values = [{{ $product->price }}, {{ $product->effective_price }}];
        }

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Price in ₹',
                    data: values,
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#ea580c',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            callback: function(val) { return '₹' + val; }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
