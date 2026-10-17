@extends('layouts.app')

@section('title', 'Your Cart - ShopKart Multi-Vendor Marketplace')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4"><i class="bi bi-cart3 text-warning me-2"></i> Shopping Cart</h2>

    @if($cart->items->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center">
            <i class="bi bi-cart-x text-muted display-4 mb-3"></i>
            <h4>Your Cart is Empty</h4>
            <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
            <div>
                <a href="{{ route('products.index') }}" class="btn btn-sk-primary px-4">Continue Shopping</a>
            </div>
        </div>
    @else
        <div class="row gy-4">
            <!-- 1. Cart Items Grouped by Seller (Section 10) -->
            <div class="col-lg-8">
                @foreach($itemsBySeller as $sellerId => $sellerItems)
                    @php 
                        $seller = $sellerItems->first()->seller;
                        $sellerSubtotal = $sellerItems->sum(fn($i) => $i->price * $i->quantity);
                        $sellerTax = $sellerItems->sum(fn($i) => ($i->price * $i->quantity) * (($i->product->tax_percent ?? 18) / 100));
                        $sellerShipping = $sellerSubtotal < 499 ? 40.0 : 0.0;
                    @endphp

                    <div class="card border-0 shadow-sm mb-4">
                        <!-- Seller Header -->
                        <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-shop text-primary fs-5"></i>
                                <div>
                                    <strong class="text-dark">{{ $seller->store_name }}</strong>
                                    <small class="text-muted ms-2"><i class="bi bi-geo-alt"></i> {{ $seller->city }} ({{ $seller->estimated_delivery_minutes }} min delivery)</small>
                                </div>
                            </div>
                            <span class="sk-trust-badge">{{ $seller->trust_score }}% Trust</span>
                        </div>

                        <!-- Items from this seller -->
                        <div class="card-body p-0">
                            @foreach($sellerItems as $item)
                                <div class="p-3 border-bottom d-flex align-items-center gap-3">
                                    <img src="{{ $item->product->thumbnail ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&h=100&fit=crop' }}" class="rounded" alt="{{ $item->product->name }}" style="width: 80px; height: 80px; object-fit: cover;">
                                    
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1">
                                            <a href="{{ route('products.show', $item->product->slug) }}" class="text-dark text-decoration-none">
                                                {{ $item->product->name }}
                                            </a>
                                        </h6>
                                        @if($item->variant)
                                            <small class="text-muted d-block">Variant: {{ $item->variant->color }} - {{ $item->variant->size }}</small>
                                        @endif
                                        <div class="fw-bold text-dark mt-1">₹{{ number_format($item->price) }} each</div>
                                    </div>

                                    <!-- Quantity Update -->
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center gap-1">
                                        @csrf
                                        <select name="quantity" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 70px;">
                                            @for($q=1; $q<=10; $q++)
                                                <option value="{{ $q }}" {{ $item->quantity == $q ? 'selected' : '' }}>{{ $q }}</option>
                                            @endfor
                                        </select>
                                    </form>

                                    <!-- Item Subtotal -->
                                    <div class="fw-bold text-dark fs-6" style="min-width: 90px; text-align: right;">
                                        ₹{{ number_format($item->subtotal) }}
                                    </div>

                                    <!-- Remove Button -->
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Remove Item">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <!-- Seller Package Subtotal Summary Footer -->
                        <div class="card-footer bg-white d-flex justify-content-between align-items-center small text-muted py-2">
                            <span>Package Subtotal: ₹{{ number_format($sellerSubtotal) }} + Tax: ₹{{ number_format($sellerTax) }}</span>
                            <span class="{{ $sellerShipping == 0 ? 'text-success fw-bold' : '' }}">
                                {{ $sellerShipping == 0 ? '✓ Free Local Delivery' : 'Standard Delivery: ₹40' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- 2. Order Summary & Coupon Box -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 90px;">
                    <h5 class="fw-bold mb-3">Order Price Summary</h5>

                    <!-- Coupon Box -->
                    <div class="mb-4">
                        @if($appliedCoupon)
                            <div class="alert alert-success d-flex justify-content-between align-items-center py-2 mb-0">
                                <div>
                                    <strong>{{ $appliedCoupon->code }}</strong> applied!
                                    <small class="d-block text-success">Saved ₹{{ number_format($couponDiscount) }}</small>
                                </div>
                                <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link btn-sm text-danger p-0">Remove</button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" class="input-group">
                                @csrf
                                <input type="text" name="code" class="form-control form-control-sm text-uppercase" placeholder="Coupon Code (e.g. WELCOME100)">
                                <button type="submit" class="btn btn-dark btn-sm">Apply</button>
                            </form>
                        @endif
                    </div>

                    <!-- Price Calculations -->
                    <div class="d-flex justify-content-between text-muted mb-2">
                        <span>Items Subtotal ({{ $cart->items_count }} items):</span>
                        <span class="text-dark">₹{{ number_format($cart->subtotal) }}</span>
                    </div>

                    <div class="d-flex justify-content-between text-muted mb-2">
                        <span>Estimated GST (18%):</span>
                        <span class="text-dark">₹{{ number_format($cart->tax_amount) }}</span>
                    </div>

                    <div class="d-flex justify-content-between text-muted mb-2">
                        <span>Local Shipping & Handling:</span>
                        <span class="text-dark">{{ $cart->shipping_fee == 0 ? 'FREE' : '₹' . number_format($cart->shipping_fee) }}</span>
                    </div>

                    @if($couponDiscount > 0)
                        <div class="d-flex justify-content-between text-success mb-2 fw-semibold">
                            <span>Coupon Discount:</span>
                            <span>-₹{{ number_format($couponDiscount) }}</span>
                        </div>
                    @endif

                    <hr>

                    <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                        <span>Grand Total:</span>
                        <span class="text-dark">₹{{ number_format($grandTotal) }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-sk-primary w-100 py-2 fw-bold text-center">
                        Proceed to Checkout
                    </a>

                    <div class="mt-3 text-center text-muted small">
                        <i class="bi bi-shield-lock-fill text-success"></i> Safe & Secure Indian Checkout
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
