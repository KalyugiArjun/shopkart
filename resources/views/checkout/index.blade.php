@extends('layouts.app')

@section('title', 'Secure Checkout - ShopKart Marketplace')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4"><i class="bi bi-shield-check text-success me-2"></i> Secure Checkout</h2>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="row gy-4">
            <!-- Left Column: Address, Gift Mode & Payment -->
            <div class="col-lg-8">
                <!-- 1. Customer & Shipping Address (Section 43) -->
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt text-primary me-2"></i> 1. Delivery Address</h5>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="customer_name" class="form-control form-control-sm" value="{{ old('customer_name', Auth::user()->name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Mobile Number (10 Digits)</label>
                            <input type="text" name="customer_phone" class="form-control form-control-sm" value="{{ old('customer_phone', Auth::user()->phone) }}" required pattern="^[6-9]\d{9}$">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="customer_email" class="form-control form-control-sm" value="{{ old('customer_email', Auth::user()->email) }}" required>
                        </div>
                    </div>

                    <!-- Existing Saved Addresses Selection if available -->
                    @if($addresses->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Select from Saved Addresses:</label>
                            <div class="row g-2">
                                @foreach($addresses as $addr)
                                    <div class="col-md-6">
                                        <div class="form-check p-3 border rounded bg-light">
                                            <input class="form-check-input" type="radio" name="address_id" id="addr_{{ $addr->id }}" value="{{ $addr->id }}" {{ $loop->first ? 'checked' : '' }} onchange="toggleNewAddressForm(false)">
                                            <label class="form-check-label small" for="addr_{{ $addr->id }}">
                                                <strong>{{ $addr->name }}</strong> ({{ ucfirst($addr->address_type) }})<br>
                                                {{ $addr->formatted_address }}<br>
                                                Phone: {{ $addr->phone }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="address_id" id="addr_new" value="" onchange="toggleNewAddressForm(true)">
                            <label class="form-check-label small fw-bold" for="addr_new">+ Add a Different New Address</label>
                        </div>
                    @endif

                    <!-- New Address Form Fields -->
                    <div id="newAddressFields" style="{{ $addresses->isNotEmpty() ? 'display: none;' : '' }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Flat, House no., Building</label>
                                <input type="text" name="house_no" class="form-control form-control-sm" placeholder="e.g. Flat 302, Green Heights">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Street, Road, Colony</label>
                                <input type="text" name="street" class="form-control form-control-sm" placeholder="e.g. MG Marg, Civil Lines">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Area / Locality</label>
                                <input type="text" name="area" class="form-control form-control-sm" placeholder="e.g. Hazratganj">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Landmark (Optional)</label>
                                <input type="text" name="landmark" class="form-control form-control-sm" placeholder="e.g. Near Post Office">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Pincode</label>
                                <input type="text" name="pincode" class="form-control form-control-sm" placeholder="e.g. 226001" pattern="^[1-9][0-9]{5}$">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">City</label>
                                <input type="text" name="city" class="form-control form-control-sm" value="Lucknow">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">State</label>
                                <input type="text" name="state" class="form-control form-control-sm" value="Uttar Pradesh">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Gift Mode (Section 31: "This is a gift") -->
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="bi bi-gift-fill text-danger me-2"></i> 2. Gift Mode</h5>
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Optional Surprise</span>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_gift" id="isGiftSwitch" value="1" onchange="document.getElementById('giftOptionsCollapse').style.display = this.checked ? 'block' : 'none'">
                        <label class="form-check-label fw-bold" for="isGiftSwitch">This is a gift for someone special</label>
                    </div>

                    <div id="giftOptionsCollapse" style="display: none;" class="p-3 bg-light rounded-3 border">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Recipient Full Name</label>
                                <input type="text" name="gift_recipient_name" class="form-control form-control-sm" placeholder="e.g. Anjali Verma">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Scheduled Delivery Date (Optional)</label>
                                <input type="date" name="scheduled_delivery_date" class="form-control form-control-sm" min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Custom Gift Greeting Message</label>
                                <textarea name="gift_message" class="form-control form-control-sm" rows="2" placeholder="e.g. Wishing you a very Happy Birthday! Lots of love."></textarea>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gift_wrap" id="giftWrapCheck" value="1">
                                    <label class="form-check-label small fw-semibold" for="giftWrapCheck">
                                        <i class="bi bi-box2-heart text-danger"></i> Premium Gift Packaging (Complimentary)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hide_price" id="hidePriceCheck" value="1" checked>
                                    <label class="form-check-label small fw-semibold" for="hidePriceCheck">
                                        <i class="bi bi-eye-slash text-dark"></i> Hide Price on Invoice Package
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Payment Methods (Section 12: COD, Razorpay, UPI) -->
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-credit-card-2-front text-warning me-2"></i> 3. Select Payment Method</h5>

                    <div class="d-flex flex-column gap-3">
                        <!-- Cash on Delivery -->
                        <div class="form-check p-3 border rounded bg-light d-flex align-items-center gap-3">
                            <input class="form-check-input ms-0" type="radio" name="payment_method" id="pay_cod" value="cod" checked>
                            <label class="form-check-label flex-grow-1" for="pay_cod">
                                <strong class="d-block text-dark"><i class="bi bi-cash-stack text-success"></i> Cash on Delivery (COD)</strong>
                                <small class="text-muted">Pay in cash or UPI QR code at your doorstep upon package arrival.</small>
                            </label>
                        </div>

                        <!-- Razorpay Online -->
                        <div class="form-check p-3 border rounded bg-light d-flex align-items-center gap-3">
                            <input class="form-check-input ms-0" type="radio" name="payment_method" id="pay_razorpay" value="razorpay">
                            <label class="form-check-label flex-grow-1" for="pay_razorpay">
                                <strong class="d-block text-dark"><i class="bi bi-credit-card-fill text-primary"></i> Online Payment via Razorpay</strong>
                                <small class="text-muted">Cards, Netbanking, Wallets & Razorpay secure checkout.</small>
                            </label>
                        </div>

                        <!-- UPI Direct -->
                        <div class="form-check p-3 border rounded bg-light d-flex align-items-center gap-3">
                            <input class="form-check-input ms-0" type="radio" name="payment_method" id="pay_upi" value="upi">
                            <label class="form-check-label flex-grow-1" for="pay_upi">
                                <strong class="d-block text-dark"><i class="bi bi-qr-code text-dark"></i> UPI Instant Transfer (GPay, PhonePe, Paytm, BHIM)</strong>
                                <small class="text-muted">Fast & zero surcharge Indian digital payment.</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Review & Breakdown -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 90px;">
                    <h5 class="fw-bold mb-3">Order Packages</h5>

                    <!-- Multi-Vendor Packages Preview -->
                    <div class="mb-3">
                        @foreach($itemsBySeller as $sellerId => $sellerItems)
                            <div class="p-2 border rounded mb-2 bg-light small">
                                <div class="fw-bold text-dark"><i class="bi bi-shop"></i> {{ $sellerItems->first()->seller->store_name }}</div>
                                <div class="text-muted">{{ $sellerItems->count() }} items &bull; Est. {{ $sellerItems->first()->seller->estimated_delivery_minutes }} min delivery</div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Price Breakdown -->
                    <div class="d-flex justify-content-between text-muted mb-2 small">
                        <span>Items Subtotal:</span>
                        <span class="text-dark">₹{{ number_format($cart->subtotal) }}</span>
                    </div>

                    <div class="d-flex justify-content-between text-muted mb-2 small">
                        <span>Estimated GST (18%):</span>
                        <span class="text-dark">₹{{ number_format($cart->tax_amount) }}</span>
                    </div>

                    <div class="d-flex justify-content-between text-muted mb-2 small">
                        <span>Shipping & Local Delivery:</span>
                        <span class="text-dark">{{ $cart->shipping_fee == 0 ? 'FREE' : '₹' . number_format($cart->shipping_fee) }}</span>
                    </div>

                    @if($couponDiscount > 0)
                        <div class="d-flex justify-content-between text-success mb-2 small fw-bold">
                            <span>Coupon Discount ({{ $appliedCoupon?->code }}):</span>
                            <span>-₹{{ number_format($couponDiscount) }}</span>
                        </div>
                    @endif

                    <hr>

                    <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                        <span>Total to Pay:</span>
                        <span class="text-dark">₹{{ number_format($grandTotal) }}</span>
                    </div>

                    <button type="submit" class="btn btn-sk-primary w-100 py-3 fw-bold fs-6">
                        Place Order
                    </button>

                    <div class="mt-3 text-center text-muted small">
                        <i class="bi bi-lock-fill text-success"></i> 256-Bit SSL Encrypted Indian Gateway
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function toggleNewAddressForm(show) {
        document.getElementById('newAddressFields').style.display = show ? 'block' : 'none';
    }
</script>
@endpush
