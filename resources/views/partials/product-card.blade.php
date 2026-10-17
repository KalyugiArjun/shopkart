<div class="sk-product-card">
    <div class="sk-product-thumb">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ $product->thumbnail ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop' }}" alt="{{ $product->name }}" loading="lazy" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop';">
        </a>

        @if($product->is_fast_delivery)
            <span class="sk-badge-fast">
                <i class="bi bi-lightning-fill text-warning"></i> {{ $product->delivery_time_minutes }}m
            </span>
        @endif

        @if($product->discount_percentage > 0)
            <span class="sk-badge-discount">
                {{ $product->discount_percentage }}% OFF
            </span>
        @endif

        @auth
            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="sk-wishlist-btn" title="Add to Wishlist">
                    <i class="bi bi-heart"></i>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="sk-wishlist-btn" title="Sign in to save">
                <i class="bi bi-heart"></i>
            </a>
        @endauth
    </div>

    <div class="p-3 d-flex flex-column flex-grow-1">
        <!-- Seller Info & Trust Score -->
        <div class="d-flex justify-content-between align-items-center mb-1">
            <a href="{{ route('seller.storefront', $product->seller->slug) }}" class="text-muted text-decoration-none small text-truncate" style="max-width: 60%;" title="{{ $product->seller->store_name }}">
                <i class="bi bi-shop"></i> {{ $product->seller->store_name }}
            </a>
            <span class="sk-trust-badge" title="Seller Trust Score based on fulfilled orders & customer ratings">
                {{ $product->seller->trust_score }}% Trust
            </span>
        </div>

        <!-- Product Title -->
        <h6 class="fw-bold mb-1 flex-grow-1" style="font-size: 0.925rem; line-height: 1.35;">
            <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none">
                {{ Str::limit($product->name, 48) }}
            </a>
        </h6>

        <!-- Rating -->
        <div class="d-flex align-items-center gap-1 mb-2 small">
            <span class="badge bg-warning text-dark py-1 px-2" style="font-size: 0.75rem;">
                {{ $product->rating }} <i class="bi bi-star-fill"></i>
            </span>
            <span class="text-muted" style="font-size: 0.75rem;">({{ $product->total_reviews }})</span>
        </div>

        <!-- Price -->
        <div class="d-flex align-items-baseline gap-2 mb-3">
            <span class="fs-5 fw-bold text-dark">₹{{ number_format($product->effective_price) }}</span>
            @if($product->discount_price && $product->discount_price < $product->price)
                <span class="text-muted text-decoration-line-through small">₹{{ number_format($product->price) }}</span>
            @endif
        </div>

        <!-- Add to Cart Form -->
        <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-sk-primary w-100 btn-sm d-flex align-items-center justify-content-center gap-1">
                <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
        </form>
    </div>
</div>
