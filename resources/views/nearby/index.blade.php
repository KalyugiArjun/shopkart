@extends('layouts.app')

@section('title', 'Nearby Sellers & Local Discovery - ShopKart')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Nearby Sellers & Local Delivery</h2>
            <p class="text-muted small mb-0">Discover verified neighborhood shops within your delivery radius in <strong>{{ $city }}</strong>.</p>
        </div>
        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#locationModal">
            <i class="bi bi-pencil-square me-1"></i> Change Location ({{ $pincode }})
        </button>
    </div>

    <!-- Interactive Leaflet OpenStreetMap View (Section 8) -->
    <div class="card border-0 shadow-sm p-2 mb-4">
        <div id="nearbyMap" style="height: 400px; width: 100%; border-radius: 8px;"></div>
    </div>

    <!-- Nearby Sellers Cards Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
        @forelse($nearbySellers as $seller)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm p-4 hover-shadow transition">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $seller->store_logo ?: 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=100&h=100&fit=crop' }}" class="rounded-circle border" alt="{{ $seller->store_name }}" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <h5 class="fw-bold mb-0 fs-6">{{ $seller->store_name }}</h5>
                            <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $seller->city }}, {{ $seller->state }}</small>
                            <div class="d-flex gap-2 mt-1">
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> {{ $seller->rating }}</span>
                                <span class="sk-trust-badge">{{ $seller->trust_score }}% Trust</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($seller->about_store ?: $seller->store_tagline, 100) }}</p>

                    <div class="p-2 bg-light rounded-3 mb-3 small d-flex justify-content-between align-items-center">
                        <span class="text-success fw-bold"><i class="bi bi-lightning-fill"></i> {{ $seller->estimated_delivery_minutes }} min delivery</span>
                        <span class="text-secondary fw-semibold">{{ $seller->distance }} km away</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <small class="text-muted">{{ $seller->products()->count() }} Products</small>
                        <a href="{{ route('seller.storefront', $seller->slug) }}" class="btn btn-sm btn-sk-primary">
                            Explore Store
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm p-5 text-center">
                    <h5>No sellers currently registered within {{ $radiusKm }} km of your location</h5>
                    <p class="text-muted">Try increasing your location radius or switching to a major Indian city.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const userLat = {{ $userLat }};
        const userLng = {{ $userLng }};
        const markersData = @json($mapMarkers);

        // Initialize Leaflet Map
        const map = L.map('nearbyMap').setView([userLat, userLng], 12);

        // OpenStreetMap Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // User Location Pin
        const userIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        L.marker([userLat, userLng], { icon: userIcon }).addTo(map)
            .bindPopup("<strong>Your Location</strong><br>{{ $city }} ({{ $pincode }})")
            .openPopup();

        // Seller Pins
        const sellerIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        markersData.forEach(function (s) {
            if (s.lat && s.lng) {
                L.marker([s.lat, s.lng], { icon: sellerIcon }).addTo(map)
                    .bindPopup(`
                        <div style="min-width: 160px;">
                            <strong>${s.name}</strong><br>
                            <span class="badge bg-warning text-dark">${s.rating} ★</span> &bull; ${s.trust_score}% Trust<br>
                            <span class="text-success fw-bold">${s.delivery_time} mins &bull; ${s.distance} km</span><br>
                            <a href="${s.url}" class="btn btn-sm btn-dark text-white w-100 mt-2 py-0" style="font-size: 11px;">Visit Store</a>
                        </div>
                    `);
            }
        });
    });
</script>
@endpush
