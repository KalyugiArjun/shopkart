<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Commission;
use App\Models\Coupon;
use App\Models\GroupBuyingGroup;
use App\Models\GroupBuyingParticipant;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PriceAlert;
use App\Models\PriceHistory;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\Seller;
use App\Models\SellerDocument;
use App\Models\SellerOrder;
use App\Models\Shipment;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');

        // 1. Create Admin User
        $admin = User::create([
            'name' => 'Rajesh Sharma (Admin)',
            'email' => 'admin@shopkart.in',
            'phone' => '9876543210',
            'role' => 'admin',
            'status' => 'active',
            'preferred_city' => 'New Delhi',
            'preferred_pincode' => '110001',
            'password' => $password,
        ]);

        // 2. Create 10 Indian Sellers with Realistic Locations & Trust Metrics
        $sellerData = [
            [
                'name' => 'Amitabh Verma',
                'email' => 'lucknow.fashion@shopkart.in',
                'phone' => '9839012345',
                'store_name' => 'Lucknow Chikan & Fashion Hub',
                'slug' => 'lucknow-chikan-fashion-hub',
                'tagline' => 'Authentic Lakhnawi Chikankari & Modern Ethnic Wear',
                'address' => 'Shop 42, Janpath Market, Hazratganj',
                'city' => 'Lucknow',
                'state' => 'Uttar Pradesh',
                'pincode' => '226001',
                'lat' => 26.8500,
                'lng' => 80.9499,
                'radius' => 20.0,
                'delivery_min' => 25,
                'gst' => '09AAAAA0000A1Z5',
                'pan' => 'ABCDE1234F',
                'rating' => 4.9,
                'trust' => 99.2,
                'logo' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Vikas Malhotra',
                'email' => 'delhi.electronics@shopkart.in',
                'phone' => '9811098765',
                'store_name' => 'Delhi Gadgets & Audio Store',
                'slug' => 'delhi-gadgets-audio-store',
                'tagline' => 'Certified Electronics, Wearables & Audio Gear',
                'address' => 'G-12, Nehru Place Commercial Complex',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'pincode' => '110019',
                'lat' => 28.5494,
                'lng' => 77.2536,
                'radius' => 25.0,
                'delivery_min' => 30,
                'gst' => '07BBBBB1111B2Z6',
                'pan' => 'BCDEF2345G',
                'rating' => 4.8,
                'trust' => 98.5,
                'logo' => 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Pooja Kulkarni',
                'email' => 'mumbai.home@shopkart.in',
                'phone' => '9820011223',
                'store_name' => 'Mumbai Home & Living Store',
                'slug' => 'mumbai-home-living-store',
                'tagline' => 'Contemporary Kitchenware & Premium Living Essentials',
                'address' => 'Unit 3B, Phoenix Marketcity, Kurla West',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'pincode' => '400070',
                'lat' => 19.0860,
                'lng' => 72.8890,
                'radius' => 18.0,
                'delivery_min' => 35,
                'gst' => '27CCCCC2222C3Z7',
                'pan' => 'CDEFG3456H',
                'rating' => 4.7,
                'trust' => 97.4,
                'logo' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Karthik Rao',
                'email' => 'bangalore.tech@shopkart.in',
                'phone' => '9845033445',
                'store_name' => 'Bangalore Smart Tech Depot',
                'slug' => 'bangalore-smart-tech-depot',
                'tagline' => 'Smart Home, Wearables & High Performance Accessories',
                'address' => '88, 100 Feet Road, Indiranagar',
                'city' => 'Bengaluru',
                'state' => 'Karnataka',
                'pincode' => '560038',
                'lat' => 12.9716,
                'lng' => 77.5946,
                'radius' => 20.0,
                'delivery_min' => 20,
                'gst' => '29DDDDD3333D4Z8',
                'pan' => 'DEFGH4567I',
                'rating' => 4.9,
                'trust' => 99.0,
                'logo' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Mahendra Rathore',
                'email' => 'jaipur.crafts@shopkart.in',
                'phone' => '9829055667',
                'store_name' => 'Jaipur Royal Handicrafts',
                'slug' => 'jaipur-royal-handicrafts',
                'tagline' => 'Handcrafted Blue Pottery, Rugs & Heritage Decor',
                'address' => 'Plot 15, MI Road, Near Raj Mandir',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'pincode' => '302001',
                'lat' => 26.9124,
                'lng' => 75.7873,
                'radius' => 22.0,
                'delivery_min' => 40,
                'gst' => '08EEEEE4444E5Z9',
                'pan' => 'EFGHI5678J',
                'rating' => 4.9,
                'trust' => 98.8,
                'logo' => 'https://images.unsplash.com/photo-1606744837616-56c9a5c6a6eb?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Sai Krishna',
                'email' => 'hyderabad.bazaar@shopkart.in',
                'phone' => '9848077889',
                'store_name' => 'Hyderabad Pearl & Spices Bazaar',
                'slug' => 'hyderabad-pearl-spices-bazaar',
                'tagline' => 'Handpicked Spices, Dry Fruits & Traditional Jewelry',
                'address' => '22-7-268, Pathergatti, Near Charminar',
                'city' => 'Hyderabad',
                'state' => 'Telangana',
                'pincode' => '500002',
                'lat' => 17.3616,
                'lng' => 78.4747,
                'radius' => 25.0,
                'delivery_min' => 30,
                'gst' => '36FFFFF5555F6Z0',
                'pan' => 'FGHIJ6789K',
                'rating' => 4.6,
                'trust' => 96.5,
                'logo' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Deepak Sundaram',
                'email' => 'chennai.silks@shopkart.in',
                'phone' => '9840099887',
                'store_name' => 'Chennai Handloom Silks',
                'slug' => 'chennai-handloom-silks',
                'tagline' => 'Pure Kanjeevaram Silks & South Indian Cotton',
                'address' => '45, Usman Road, T. Nagar',
                'city' => 'Chennai',
                'state' => 'Tamil Nadu',
                'pincode' => '600017',
                'lat' => 13.0418,
                'lng' => 80.2341,
                'radius' => 15.0,
                'delivery_min' => 35,
                'gst' => '33GGGGG6666G7Z1',
                'pan' => 'GHIJK7890L',
                'rating' => 4.8,
                'trust' => 98.2,
                'logo' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Subhashis Roy',
                'email' => 'kolkata.sweets@shopkart.in',
                'phone' => '9830022334',
                'store_name' => 'Kolkata Gourmet Spices & Delights',
                'slug' => 'kolkata-gourmet-spices-delights',
                'tagline' => 'Artisanal Teas, Spices & Gourmet Bengal Specialties',
                'address' => '7B, Lindsay Street, New Market',
                'city' => 'Kolkata',
                'state' => 'West Bengal',
                'pincode' => '700087',
                'lat' => 22.5600,
                'lng' => 88.3500,
                'radius' => 15.0,
                'delivery_min' => 30,
                'gst' => '19HHHHH7777H8Z2',
                'pan' => 'HIJKL8901M',
                'rating' => 4.7,
                'trust' => 97.0,
                'logo' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Sameer Kadam',
                'email' => 'pune.sports@shopkart.in',
                'phone' => '9822044556',
                'store_name' => 'Pune SportsHub & Fitness Co.',
                'slug' => 'pune-sportshub-fitness-co',
                'tagline' => 'Professional Cricket, Badminton & Gym Gear',
                'address' => 'Shop 10, FC Road, Shivajinagar',
                'city' => 'Pune',
                'state' => 'Maharashtra',
                'pincode' => '411005',
                'lat' => 18.5204,
                'lng' => 73.8567,
                'radius' => 20.0,
                'delivery_min' => 25,
                'gst' => '27IIIII8888I9Z3',
                'pan' => 'IJKLM9012N',
                'rating' => 4.8,
                'trust' => 98.9,
                'logo' => 'https://images.unsplash.com/photo-1517649763962-0c623266ddc0?w=200&h=200&fit=crop',
            ],
            [
                'name' => 'Bhavesh Patel',
                'email' => 'ahmedabad.textiles@shopkart.in',
                'phone' => '9825066778',
                'store_name' => 'Ahmedabad Organic Textiles & Kurtas',
                'slug' => 'ahmedabad-organic-textiles-kurtas',
                'tagline' => '100% Pure Khadi, Bandhani & Daily Casuals',
                'address' => '24, CG Road, Navrangpura',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380009',
                'lat' => 23.0373,
                'lng' => 72.5614,
                'radius' => 20.0,
                'delivery_min' => 25,
                'gst' => '24JJJJJ9999J0Z4',
                'pan' => 'JKLMN0123O',
                'rating' => 4.9,
                'trust' => 99.4,
                'logo' => 'https://images.unsplash.com/photo-1523381294911-8d3cead13475?w=200&h=200&fit=crop',
            ],
        ];

        $sellers = [];
        foreach ($sellerData as $sd) {
            $user = User::create([
                'name' => $sd['name'],
                'email' => $sd['email'],
                'phone' => $sd['phone'],
                'role' => 'seller',
                'status' => 'active',
                'preferred_city' => $sd['city'],
                'preferred_pincode' => $sd['pincode'],
                'password' => $password,
            ]);

            $seller = Seller::create([
                'user_id' => $user->id,
                'store_name' => $sd['store_name'],
                'slug' => $sd['slug'],
                'store_tagline' => $sd['tagline'],
                'phone' => $sd['phone'],
                'business_email' => $sd['email'],
                'business_address' => $sd['address'],
                'city' => $sd['city'],
                'state' => $sd['state'],
                'pincode' => $sd['pincode'],
                'latitude' => $sd['lat'],
                'longitude' => $sd['lng'],
                'delivery_radius_km' => $sd['radius'],
                'estimated_delivery_minutes' => $sd['delivery_min'],
                'local_delivery_available' => true,
                'gst_number' => $sd['gst'],
                'pan_number' => $sd['pan'],
                'bank_account_name' => $sd['store_name'],
                'bank_account_number' => '50100' . rand(10000000, 99999999),
                'bank_ifsc' => 'HDFC0001234',
                'bank_name' => 'HDFC Bank',
                'store_logo' => $sd['logo'],
                'store_banner' => 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=1200&h=300&fit=crop',
                'status' => 'approved',
                'rating' => $sd['rating'],
                'total_reviews' => rand(150, 850),
                'trust_score' => $sd['trust'],
                'total_orders' => rand(400, 1500),
                'completed_orders' => rand(380, 1450),
                'cancelled_orders' => rand(2, 10),
                'on_time_deliveries' => rand(360, 1400),
                'return_count' => rand(5, 20),
                'return_policy' => '7 Days Replacement / Return with hassle-free doorstep pickup.',
                'about_store' => "Welcome to {$sd['store_name']}. We take pride in delivering genuine quality products with lightning-fast local delivery and full customer satisfaction guarantee.",
            ]);

            $sellers[] = $seller;
        }

        // 3. Create 40+ Indian Customer Users
        $customerNames = [
            'Aarav Sharma', 'Priya Patel', 'Rohit Verma', 'Ananya Iyer', 'Rohan Gupta',
            'Sneha Rao', 'Vikram Singh', 'Neha Joshi', 'Arjun Nair', 'Meera Reddy',
            'Aditya Kulkarni', 'Kavita Pillai', 'Karan Mehra', 'Pooja Chawla', 'Rahul Deshmukh',
            'Ishaan Bansal', 'Riya Sen', 'Varun Kapoor', 'Shruti Saxena', 'Abhishek Tiwari',
            'Swati Mukherjee', 'Naveen Kumar', 'Divya Chauhan', 'Manish Agarwal', 'Shalini Mishra',
            'Sanjay Das', 'Tanvi Hegde', 'Gaurav Bhatia', 'Preeti Menon', 'Kunal Sengupta',
            'Aakash Pandey', 'Simran Kaur', 'Harsh Vardhan', 'Shweta Nambiar', 'Mohit Jain',
            'Deepika Shukla', 'Pranav Bhatt', 'Ankita Ghosh', 'Siddharth Roy', 'Pallavi Dubey',
        ];

        $customers = [];
        foreach ($customerNames as $i => $name) {
            $email = Str::slug($name, '.') . ($i + 1) . '@example.com';
            $cust = User::create([
                'name' => $name,
                'email' => $email,
                'phone' => '98' . rand(10000000, 99999999),
                'role' => 'customer',
                'status' => 'active',
                'preferred_city' => ($i % 2 === 0) ? 'Lucknow' : 'New Delhi',
                'preferred_pincode' => ($i % 2 === 0) ? '226001' : '110001',
                'password' => $password,
            ]);

            // Add realistic Indian Address
            Address::create([
                'user_id' => $cust->id,
                'name' => $cust->name,
                'phone' => $cust->phone,
                'house_no' => 'Flat ' . rand(101, 804) . ', Tower ' . chr(65 + ($i % 6)),
                'street' => 'Civil Lines Main Road',
                'area' => ($i % 2 === 0) ? 'Hazratganj' : 'Connaught Place',
                'landmark' => ($i % 2 === 0) ? 'Near GPO' : 'Near Metro Gate 2',
                'city' => $cust->preferred_city,
                'state' => ($i % 2 === 0) ? 'Uttar Pradesh' : 'Delhi',
                'pincode' => $cust->preferred_pincode,
                'is_default' => true,
            ]);

            $customers[] = $cust;
        }

        // 4. Create 15 Indian E-Commerce Categories
        $categoryData = [
            ['name' => 'Fashion & Apparel', 'slug' => 'fashion', 'icon' => 'bi-bag', 'rate' => 12.0],
            ['name' => 'Footwear & Shoes', 'slug' => 'footwear', 'icon' => 'bi-lightning', 'rate' => 10.0],
            ['name' => 'Electronics & Gadgets', 'slug' => 'electronics', 'icon' => 'bi-laptop', 'rate' => 8.0],
            ['name' => 'Mobiles & Tablets', 'slug' => 'mobiles', 'icon' => 'bi-phone', 'rate' => 6.0],
            ['name' => 'Home & Kitchen', 'slug' => 'home-kitchen', 'icon' => 'bi-house-door', 'rate' => 10.0],
            ['name' => 'Sports & Fitness', 'slug' => 'sports-fitness', 'icon' => 'bi-bicycle', 'rate' => 9.0],
            ['name' => 'Indian Handicrafts', 'slug' => 'handicrafts', 'icon' => 'bi-gem', 'rate' => 14.0],
            ['name' => 'Watches & Wearables', 'slug' => 'watches', 'icon' => 'bi-smartwatch', 'rate' => 10.0],
            ['name' => 'Beauty & Personal Care', 'slug' => 'beauty', 'icon' => 'bi-stars', 'rate' => 12.0],
            ['name' => 'Grocery & Spices', 'slug' => 'grocery', 'icon' => 'bi-basket', 'rate' => 5.0],
            ['name' => 'Books & Stationery', 'slug' => 'books', 'icon' => 'bi-book', 'rate' => 8.0],
            ['name' => 'Toys & Baby Care', 'slug' => 'toys', 'icon' => 'bi-emoji-smile', 'rate' => 10.0],
            ['name' => 'Luggage & Backpacks', 'slug' => 'luggage', 'icon' => 'bi-briefcase', 'rate' => 10.0],
            ['name' => 'Jewelry & Accessories', 'slug' => 'jewelry', 'icon' => 'bi-flower1', 'rate' => 15.0],
            ['name' => 'Automotive Accessories', 'slug' => 'automotive', 'icon' => 'bi-speedometer2', 'rate' => 8.0],
        ];

        $categories = [];
        foreach ($categoryData as $idx => $cd) {
            $cat = Category::create([
                'name' => $cd['name'],
                'slug' => $cd['slug'],
                'icon' => $cd['icon'],
                'commission_rate' => $cd['rate'],
                'is_active' => true,
                'sort_order' => $idx + 1,
            ]);
            $categories[$cd['slug']] = $cat;
        }

        // 5. Create Popular Indian Brands
        $brandData = [
            'boAt', 'Noise', 'Titan', 'FabIndia', 'Wildcraft', 'Woodland',
            'Prestige', 'Puma India', 'Allen Solly', 'Fastrack', 'Havells', 'Bombay Dyeing'
        ];
        $brands = [];
        foreach ($brandData as $bName) {
            $brand = Brand::create([
                'name' => $bName,
                'slug' => Str::slug($bName),
                'is_active' => true,
            ]);
            $brands[$bName] = $brand;
        }

        // 6. Create 50+ Real-World Products with Indian Pricing, Variants & Fast Delivery
        $catalog = [
            [
                'name' => 'Lakhnawi Handcrafted Pure Cotton Chikan Kurta',
                'category' => 'fashion',
                'brand' => 'FabIndia',
                'seller_idx' => 0, // Lucknow seller
                'price' => 2499.00,
                'discount' => 1899.00,
                'fast' => true,
                'time' => 25,
                'rating' => 4.9,
                'stock' => 45,
                'thumb' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?w=600&h=600&fit=crop',
                'desc' => 'Traditional Lakhnawi Chikankari embroidery on 100% breathable organic cambric cotton. Mastercrafted by traditional artisans in Old Lucknow with intricate Bakhiya and Phanda stitches.',
                'variants' => [
                    ['color' => 'White', 'size' => 'M', 'price' => 1899.00, 'stock' => 15],
                    ['color' => 'White', 'size' => 'L', 'price' => 1899.00, 'stock' => 20],
                    ['color' => 'Pastel Blue', 'size' => 'L', 'price' => 1999.00, 'stock' => 10],
                ]
            ],
            [
                'name' => 'Men\'s Pure Cotton Embroidered Lucknowi Kurta Set',
                'category' => 'fashion',
                'brand' => 'FabIndia',
                'seller_idx' => 9, // Ahmedabad seller (Alternative seller)
                'price' => 2299.00,
                'discount' => 1749.00,
                'fast' => false,
                'time' => 50,
                'rating' => 4.7,
                'stock' => 30,
                'thumb' => 'https://images.unsplash.com/photo-1597983073493-88cd35cf93b0?w=600&h=600&fit=crop',
                'desc' => 'Classic Indian men ethnic wear with matching pajama. Soft cotton weave suitable for pujas, wedding festivities, and summer celebrations.',
            ],
            [
                'name' => 'boAt Airdopes 141 True Wireless ANC Earbuds',
                'category' => 'electronics',
                'brand' => 'boAt',
                'seller_idx' => 1, // Delhi Electronics
                'price' => 4490.00,
                'discount' => 1299.00,
                'fast' => true,
                'time' => 30,
                'rating' => 4.8,
                'stock' => 120,
                'thumb' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=600&h=600&fit=crop',
                'desc' => 'Up to 42 hours playback, ENx technology for crystal clear calling, Beast Mode for ultra-low latency mobile gaming, and IPX4 water resistance.',
                'variants' => [
                    ['color' => 'Active Black', 'size' => 'Standard', 'price' => 1299.00, 'stock' => 60],
                    ['color' => 'Cider Cyan', 'size' => 'Standard', 'price' => 1299.00, 'stock' => 40],
                    ['color' => 'Bold White', 'size' => 'Standard', 'price' => 1349.00, 'stock' => 20],
                ]
            ],
            [
                'name' => 'boAt Airdopes 141 Bluetooth Wireless Earbuds (Alt Seller)',
                'category' => 'electronics',
                'brand' => 'boAt',
                'seller_idx' => 3, // Bangalore Tech Store
                'price' => 4490.00,
                'discount' => 1249.00, // Cheaper!
                'fast' => true,
                'time' => 20,
                'rating' => 4.9,
                'stock' => 80,
                'thumb' => 'https://images.unsplash.com/photo-1572536147248-ac59a8abfa4b?w=600&h=600&fit=crop',
                'desc' => 'Genuine boAt Earbuds with official warranty card. Experience signature boAt bass and 8mm dynamic audio drivers.',
            ],
            [
                'name' => 'Noise ColorFit Pro 5 Smartwatch with AMOLED Display',
                'category' => 'watches',
                'brand' => 'Noise',
                'seller_idx' => 3, // Bangalore Tech Store
                'price' => 7999.00,
                'discount' => 3499.00,
                'fast' => true,
                'time' => 25,
                'rating' => 4.7,
                'stock' => 50,
                'thumb' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=600&h=600&fit=crop',
                'desc' => '1.85 inch AMOLED always-on display, Tru Sync Bluetooth Calling, comprehensive health suite with SpO2, heart-rate, and 100+ sports modes.',
                'variants' => [
                    ['color' => 'Jet Black', 'size' => '45mm', 'price' => 3499.00, 'stock' => 25],
                    ['color' => 'Rose Gold', 'size' => '45mm', 'price' => 3599.00, 'stock' => 25],
                ]
            ],
            [
                'name' => 'Titan Karishma Analog Dial Leather Watch',
                'category' => 'watches',
                'brand' => 'Titan',
                'seller_idx' => 1,
                'price' => 2995.00,
                'discount' => 2395.00,
                'fast' => false,
                'time' => 60,
                'rating' => 4.9,
                'stock' => 35,
                'thumb' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?w=600&h=600&fit=crop',
                'desc' => 'Classic dress watch featuring champagne dial, genuine mineral glass, water resistance up to 30 meters, and premium genuine brown leather strap.',
            ],
            [
                'name' => 'Woodland Men\'s Rugged Leather Trekking Shoes',
                'category' => 'footwear',
                'brand' => 'Woodland',
                'seller_idx' => 8, // Pune SportsHub
                'price' => 4995.00,
                'discount' => 3749.00,
                'fast' => true,
                'time' => 35,
                'rating' => 4.8,
                'stock' => 40,
                'thumb' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600&h=600&fit=crop',
                'desc' => 'Heavy duty nubuck leather outdoor boots with deep groove grooved rubber outsole for all-terrain traction across rocky and muddy Indian terrains.',
                'variants' => [
                    ['color' => 'Camel Khaki', 'size' => 'UK 8', 'price' => 3749.00, 'stock' => 15],
                    ['color' => 'Camel Khaki', 'size' => 'UK 9', 'price' => 3749.00, 'stock' => 15],
                    ['color' => 'Olive Green', 'size' => 'UK 8', 'price' => 3899.00, 'stock' => 10],
                ]
            ],
            [
                'name' => 'Puma Men\'s Comet Running & Gym Shoes',
                'category' => 'footwear',
                'brand' => 'Puma India',
                'seller_idx' => 8,
                'price' => 3999.00,
                'discount' => 1999.00,
                'fast' => true,
                'time' => 25,
                'rating' => 4.6,
                'stock' => 60,
                'thumb' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=600&fit=crop',
                'desc' => 'Lightweight breathable mesh athletic trainers with cushioned EVA midsole for daily morning runs, college wear, and gym training.',
                'variants' => [
                    ['color' => 'Black / White', 'size' => 'UK 7', 'price' => 1999.00, 'stock' => 20],
                    ['color' => 'Black / White', 'size' => 'UK 8', 'price' => 1999.00, 'stock' => 20],
                    ['color' => 'Navy Blue', 'size' => 'UK 9', 'price' => 2099.00, 'stock' => 20],
                ]
            ],
            [
                'name' => 'Prestige Tri-Ply Stainless Steel Pressure Cooker 3L',
                'category' => 'home-kitchen',
                'brand' => 'Prestige',
                'seller_idx' => 2, // Mumbai Home Store
                'price' => 3200.00,
                'discount' => 2499.00,
                'fast' => true,
                'time' => 35,
                'rating' => 4.9,
                'stock' => 30,
                'thumb' => 'https://images.unsplash.com/photo-1584269600464-37b1b58a9fe7?w=600&h=600&fit=crop',
                'desc' => 'Heavy gauge triply stainless steel base for uniform heat distribution without food burning. Induction and gas stove compatible with ISI certification.',
            ],
            [
                'name' => 'Jaipur Traditional Blue Pottery Ceramic Serving Bowl Set',
                'category' => 'handicrafts',
                'brand' => 'FabIndia',
                'seller_idx' => 4, // Jaipur Crafts
                'price' => 1899.00,
                'discount' => 1399.00,
                'fast' => false,
                'time' => 45,
                'rating' => 4.9,
                'stock' => 25,
                'thumb' => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=600&h=600&fit=crop',
                'desc' => 'Handmade by GI-tagged master craftsmen in Jaipur with quartz stone and traditional floral motif glaze. Lead-free and food-safe.',
            ],
            [
                'name' => 'Wildcraft 45L Trailblazer Adventure Rucksack',
                'category' => 'luggage',
                'brand' => 'Wildcraft',
                'seller_idx' => 8,
                'price' => 3499.00,
                'discount' => 2499.00,
                'fast' => true,
                'time' => 30,
                'rating' => 4.7,
                'stock' => 35,
                'thumb' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&h=600&fit=crop',
                'desc' => 'Ergonomic hiking backpack featuring padded back airflow system, rain cover pocket, trekking pole loops, and heavy duty ripstop fabric.',
            ],
            [
                'name' => 'Kashmir Pure Saffron (Kesar) Grade-A 5g Pack',
                'category' => 'grocery',
                'brand' => 'FabIndia',
                'seller_idx' => 5, // Hyderabad Bazaar
                'price' => 1999.00,
                'discount' => 1599.00,
                'fast' => true,
                'time' => 25,
                'rating' => 5.0,
                'stock' => 50,
                'thumb' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=600&h=600&fit=crop',
                'desc' => '100% pure organic Mongra Kesar directly harvested from the valleys of Pampore, Kashmir. Laboratory tested for deep aroma and natural coloring strength.',
            ],
            [
                'name' => 'Fastrack Reflex Beat+ Heart Rate Fitness Band',
                'category' => 'watches',
                'brand' => 'Fastrack',
                'seller_idx' => 1,
                'price' => 2995.00,
                'discount' => 1495.00,
                'fast' => true,
                'time' => 30,
                'rating' => 4.5,
                'stock' => 60,
                'thumb' => 'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?w=600&h=600&fit=crop',
                'desc' => 'Vibrant 1.4 inch color display, 24x7 active heart monitor, IP68 water resistance, smart call notifications, and 5-day battery life.',
            ],
            [
                'name' => 'SS Master English Willow Cricket Bat (Full Size)',
                'category' => 'sports-fitness',
                'brand' => 'Puma India',
                'seller_idx' => 8,
                'price' => 8500.00,
                'discount' => 6499.00,
                'fast' => true,
                'time' => 40,
                'rating' => 4.9,
                'stock' => 18,
                'thumb' => 'https://images.unsplash.com/photo-1531415074968-036ba1b575da?w=600&h=600&fit=crop',
                'desc' => 'Handpicked Grade 2 English willow with thick 38mm edges, balanced pickup, and Singapore cane handle for power strokeplay.',
            ],
            [
                'name' => 'Bombay Dyeing 100% Cotton 300TC King Bedsheet with Pillows',
                'category' => 'home-kitchen',
                'brand' => 'Bombay Dyeing',
                'seller_idx' => 2,
                'price' => 2799.00,
                'discount' => 1899.00,
                'fast' => true,
                'time' => 35,
                'rating' => 4.8,
                'stock' => 40,
                'thumb' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=600&h=600&fit=crop',
                'desc' => 'Sateen finish pure combed cotton bedsheet designed with soothing floral prints. Machine washable with color-lock technology.',
            ],
            [
                'name' => 'Allen Solly Men\'s Regular Fit Formal Shirt',
                'category' => 'fashion',
                'brand' => 'Allen Solly',
                'seller_idx' => 0,
                'price' => 2199.00,
                'discount' => 1499.00,
                'fast' => true,
                'time' => 25,
                'rating' => 4.6,
                'stock' => 50,
                'thumb' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=600&h=600&fit=crop',
                'desc' => 'Wrinkle-resistant easy care cotton formal shirt with French cuffs and spread collar. Ideal for corporate meetings and office wear.',
                'variants' => [
                    ['color' => 'Sky Blue', 'size' => '39 (M)', 'price' => 1499.00, 'stock' => 25],
                    ['color' => 'Crisp White', 'size' => '40 (L)', 'price' => 1499.00, 'stock' => 25],
                ]
            ],
        ];

        // Fill up to 50+ total products by generating complementary catalog items across all categories
        $additionalCatalogItems = [
            ['name' => 'Havells 1200mm High Speed Ceiling Fan', 'cat' => 'home-kitchen', 'price' => 2890, 'disc' => 2199, 'thumb' => 'https://images.unsplash.com/photo-1585338107529-13afc5f02586?w=600&h=600&fit=crop'],
            ['name' => 'Prestige 500W Mixer Grinder with 3 Stainless Jars', 'cat' => 'home-kitchen', 'price' => 3495, 'disc' => 2299, 'thumb' => 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=600&h=600&fit=crop'],
            ['name' => 'Noise Buds VS102 Wireless Earbuds 50H Battery', 'cat' => 'electronics', 'price' => 2999, 'disc' => 1099, 'thumb' => 'https://images.unsplash.com/photo-1606220588913-b3aacb4d2f46?w=600&h=600&fit=crop'],
            ['name' => 'boAt Stone 352 Bluetooth Speaker 10W Sound', 'cat' => 'electronics', 'price' => 3490, 'disc' => 1499, 'thumb' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=600&h=600&fit=crop'],
            ['name' => 'Woodland Brown Leather Formal Derby Shoes', 'cat' => 'footwear', 'price' => 4495, 'disc' => 3299, 'thumb' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?w=600&h=600&fit=crop'],
            ['name' => 'Puma Smash v2 Unisex Casual Sneakers', 'cat' => 'footwear', 'price' => 3999, 'disc' => 2199, 'thumb' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=600&h=600&fit=crop'],
            ['name' => 'Kanjeevaram Handwoven Pure Zari Silk Saree', 'cat' => 'fashion', 'price' => 12500, 'disc' => 8999, 'thumb' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=600&h=600&fit=crop'],
            ['name' => 'Jaipur Bandhani Printed Anarkali Kurta Set', 'cat' => 'fashion', 'price' => 3299, 'disc' => 1999, 'thumb' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?w=600&h=600&fit=crop'],
            ['name' => 'Wildcraft Multi-utility School & Laptop Bag', 'cat' => 'luggage', 'price' => 2199, 'disc' => 1399, 'thumb' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&h=600&fit=crop'],
            ['name' => 'Titan Octane Chronograph Watch Silver Metal', 'cat' => 'watches', 'price' => 8995, 'disc' => 6495, 'thumb' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?w=600&h=600&fit=crop'],
            ['name' => 'Handmade Brass Diya Peacock Stand Decor (Pair)', 'cat' => 'handicrafts', 'price' => 2499, 'disc' => 1799, 'thumb' => 'https://images.unsplash.com/photo-1606744837616-56c9a5c6a6eb?w=600&h=600&fit=crop'],
            ['name' => 'Handcrafted Wooden Spice Box (Masala Dabba)', 'cat' => 'handicrafts', 'price' => 1499, 'disc' => 999, 'thumb' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=600&h=600&fit=crop'],
            ['name' => 'Nivia Storm Football Rubber Moulded Size 5', 'cat' => 'sports-fitness', 'price' => 999, 'disc' => 649, 'thumb' => 'https://images.unsplash.com/photo-1614632537423-1e6c2e7e0aab?w=600&h=600&fit=crop'],
            ['name' => 'Yonex Muscle Power 29 Light Badminton Racquet', 'cat' => 'sports-fitness', 'price' => 2890, 'disc' => 2199, 'thumb' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=600&h=600&fit=crop'],
            ['name' => 'Organic Darjeeling First Flush Green Tea 250g', 'cat' => 'grocery', 'price' => 850, 'disc' => 650, 'thumb' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=600&fit=crop'],
            ['name' => 'Organic Certified Cold Pressed Mustard Oil 1L', 'cat' => 'grocery', 'price' => 260, 'disc' => 210, 'thumb' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=600&h=600&fit=crop'],
            ['name' => 'Biotique Bio Kelp Protein Shampoo 650ml', 'cat' => 'beauty', 'price' => 590, 'disc' => 415, 'thumb' => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=600&h=600&fit=crop'],
            ['name' => 'Forest Essentials Pure Rosewater Facial Toner', 'cat' => 'beauty', 'price' => 1450, 'disc' => 1250, 'thumb' => 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=600&h=600&fit=crop'],
            ['name' => 'Autofy Universal Car Mobile Phone Holder Mount', 'cat' => 'automotive', 'price' => 799, 'disc' => 449, 'thumb' => 'https://images.unsplash.com/photo-1517524008697-84bbe3c3fd98?w=600&h=600&fit=crop'],
            ['name' => 'Godrej Aer Twist Car Air Freshener Fragrance', 'cat' => 'automotive', 'price' => 399, 'disc' => 299, 'thumb' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=600&h=600&fit=crop'],
            ['name' => 'Classmate Pulse Spiral Notebook Pack of 6', 'cat' => 'books', 'price' => 480, 'disc' => 380, 'thumb' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=600&h=600&fit=crop'],
            ['name' => 'Parker Frontier Matte Black Fountain Pen', 'cat' => 'books', 'price' => 850, 'disc' => 699, 'thumb' => 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?w=600&h=600&fit=crop'],
            ['name' => 'Funskool Giggles Activity Walker for Infants', 'cat' => 'toys', 'price' => 1999, 'disc' => 1499, 'thumb' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=600&h=600&fit=crop'],
            ['name' => 'LEGO Classic Bricks Creative Building Kit', 'cat' => 'toys', 'price' => 2499, 'disc' => 1999, 'thumb' => 'https://images.unsplash.com/photo-1585366119957-e9730b6d0f60?w=600&h=600&fit=crop'],
            ['name' => 'American Tourister 55cm Cabin Trolley Bag', 'cat' => 'luggage', 'price' => 5500, 'disc' => 2999, 'thumb' => 'https://images.unsplash.com/photo-1565026057447-bc90a3dceb87?w=600&h=600&fit=crop'],
            ['name' => 'Skybags Casual Daypack Water Resistant 30L', 'cat' => 'luggage', 'price' => 1899, 'disc' => 1099, 'thumb' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&h=600&fit=crop'],
            ['name' => 'GIVA 925 Sterling Silver Zircon Solitaire Pendant', 'cat' => 'jewelry', 'price' => 2999, 'disc' => 1699, 'thumb' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=600&h=600&fit=crop'],
            ['name' => 'Traditional Kundan Gold Plated Choker Necklace Set', 'cat' => 'jewelry', 'price' => 3499, 'disc' => 1899, 'thumb' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=600&h=600&fit=crop'],
            ['name' => 'Samsung Galaxy M34 5G (Prism Blue, 128GB)', 'cat' => 'mobiles', 'price' => 18999, 'disc' => 15499, 'thumb' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&h=600&fit=crop'],
            ['name' => 'OnePlus Nord CE 3 Lite 5G (Chromatic Gray)', 'cat' => 'mobiles', 'price' => 19999, 'disc' => 17499, 'thumb' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=600&h=600&fit=crop'],
            ['name' => 'Realme Narzo 60 5G with 64MP Camera', 'cat' => 'mobiles', 'price' => 17999, 'disc' => 14999, 'thumb' => 'https://images.unsplash.com/photo-1580910051074-3eb694886505?w=600&h=600&fit=crop'],
            ['name' => 'Lenovo Yoga Tab 11 with 2K Display & JBL Audio', 'cat' => 'mobiles', 'price' => 29999, 'disc' => 21999, 'thumb' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&h=600&fit=crop'],
            ['name' => 'Sony WH-CH520 Wireless Bluetooth Headphones', 'cat' => 'electronics', 'price' => 4990, 'disc' => 3990, 'thumb' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=600&fit=crop'],
            ['name' => 'Mi Power Bank 3i 20000mAh Dual Output Fast Charge', 'cat' => 'electronics', 'price' => 2199, 'disc' => 1699, 'thumb' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=600&h=600&fit=crop'],
            ['name' => 'Peter England Men Slim Fit Formal Trousers', 'cat' => 'fashion', 'price' => 1999, 'disc' => 1299, 'thumb' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=600&h=600&fit=crop'],
            ['name' => 'Bata Men Formal Slip-on Loafers Leather', 'cat' => 'footwear', 'price' => 2499, 'disc' => 1799, 'thumb' => 'https://images.unsplash.com/photo-1533867617858-e7b97e060509?w=600&h=600&fit=crop'],
        ];

        $createdProducts = [];

        // Seed core catalog
        foreach ($catalog as $item) {
            $seller = $sellers[$item['seller_idx'] ?? rand(0, 9)];
            $cat = $categories[$item['category']];
            $brand = isset($brands[$item['brand']]) ? $brands[$item['brand']] : null;

            $prod = Product::create([
                'seller_id' => $seller->id,
                'category_id' => $cat->id,
                'brand_id' => $brand?->id,
                'name' => $item['name'],
                'slug' => Str::slug($item['name']) . '-' . rand(100, 999),
                'sku' => 'SKU-' . strtoupper(Str::random(8)),
                'short_description' => substr($item['desc'], 0, 140) . '...',
                'description' => $item['desc'] . "\n\n100% Genuine product guaranteed by ShopKart verified merchant. Local return & exchange policy applicable.",
                'price' => $item['price'],
                'discount_price' => $item['discount'],
                'tax_percent' => 18.0,
                'stock' => $item['stock'],
                'thumbnail' => $item['thumb'],
                'is_featured' => true,
                'is_fast_delivery' => $item['fast'] ?? false,
                'delivery_time_minutes' => $item['time'] ?? 30,
                'rating' => $item['rating'] ?? 4.8,
                'total_reviews' => rand(25, 340),
                'views_count' => rand(500, 4500),
            ]);

            // Add Price History
            PriceHistory::create([
                'product_id' => $prod->id,
                'old_price' => $prod->price + 200,
                'new_price' => $prod->effective_price,
                'reason' => 'Festive launch discount',
                'created_at' => now()->subDays(rand(1, 10)),
            ]);

            // Add Inventory
            Inventory::create([
                'seller_id' => $seller->id,
                'product_id' => $prod->id,
                'sku' => $prod->sku,
                'stock_quantity' => $prod->stock,
                'low_stock_threshold' => 5,
            ]);

            // Add Variants if specified
            if (!empty($item['variants'])) {
                foreach ($item['variants'] as $v) {
                    $variant = ProductVariant::create([
                        'product_id' => $prod->id,
                        'sku' => $prod->sku . '-' . strtoupper(substr($v['color'], 0, 2)) . '-' . $v['size'],
                        'color' => $v['color'],
                        'size' => $v['size'],
                        'price' => $v['price'],
                        'discount_price' => $v['price'],
                        'stock' => $v['stock'],
                    ]);

                    Inventory::create([
                        'seller_id' => $seller->id,
                        'product_id' => $prod->id,
                        'product_variant_id' => $variant->id,
                        'sku' => $variant->sku,
                        'stock_quantity' => $variant->stock,
                    ]);
                }
            }

            $createdProducts[] = $prod;
        }

        // Seed additional catalog items to exceed 50+ total items
        foreach ($additionalCatalogItems as $ai) {
            $seller = $sellers[rand(0, 9)];
            $cat = $categories[$ai['cat']] ?? $categories['home-kitchen'];

            $prod = Product::create([
                'seller_id' => $seller->id,
                'category_id' => $cat->id,
                'name' => $ai['name'],
                'slug' => Str::slug($ai['name']) . '-' . rand(100, 999),
                'sku' => 'SKU-' . strtoupper(Str::random(8)),
                'short_description' => "High quality authentic {$ai['name']} backed by verified ShopKart warranty.",
                'description' => "Experience superior craftsmanship with {$ai['name']}. Sourced from top verified suppliers with fast doorstep fulfillment across India.",
                'price' => (float) $ai['price'],
                'discount_price' => (float) $ai['disc'],
                'tax_percent' => 18.0,
                'stock' => rand(15, 75),
                'thumbnail' => $ai['thumb'],
                'is_featured' => rand(0, 1) === 1,
                'is_fast_delivery' => rand(0, 1) === 1,
                'delivery_time_minutes' => rand(20, 60),
                'rating' => rand(42, 50) / 10.0,
                'total_reviews' => rand(10, 120),
                'views_count' => rand(200, 2000),
            ]);

            PriceHistory::create([
                'product_id' => $prod->id,
                'old_price' => $prod->price + 150,
                'new_price' => $prod->effective_price,
                'reason' => 'Price drop offer',
                'created_at' => now()->subDays(rand(2, 8)),
            ]);

            Inventory::create([
                'seller_id' => $seller->id,
                'product_id' => $prod->id,
                'sku' => $prod->sku,
                'stock_quantity' => $prod->stock,
                'low_stock_threshold' => 5,
            ]);

            $createdProducts[] = $prod;
        }

        // 7. Seed Indian Discount Coupons (Section 28)
        $couponList = [
            ['code' => 'WELCOME100', 'title' => 'Flat ₹100 Off', 'type' => 'fixed', 'amount' => 100, 'min' => 499],
            ['code' => 'FESTIVE20', 'title' => '20% Mega Festive Off', 'type' => 'percentage', 'amount' => 20, 'min' => 999, 'max' => 500],
            ['code' => 'LOCALDELIVERY', 'title' => 'Free Delivery Discount', 'type' => 'fixed', 'amount' => 40, 'min' => 299],
            ['code' => 'SHOPKART15', 'title' => '15% Off Your Entire Cart', 'type' => 'percentage', 'amount' => 15, 'min' => 1499, 'max' => 750],
        ];

        foreach ($couponList as $c) {
            Coupon::create([
                'code' => $c['code'],
                'title' => $c['title'],
                'description' => "Use code {$c['code']} at checkout for instant savings.",
                'discount_type' => $c['type'],
                'discount_amount' => $c['amount'],
                'min_order_amount' => $c['min'],
                'max_discount_amount' => $c['max'] ?? null,
                'usage_limit' => 1000,
                'usage_limit_per_user' => 2,
                'is_active' => true,
            ]);
        }

        // 8. Seed Group Buying Campaigns (Section 22)
        if (!empty($createdProducts)) {
            $groupProduct1 = $createdProducts[0]; // Kurta
            $groupProduct2 = $createdProducts[2]; // boAt Earbuds

            $g1 = GroupBuyingGroup::create([
                'product_id' => $groupProduct1->id,
                'creator_user_id' => $customers[0]->id,
                'group_code' => 'GRP-LUCKNOW',
                'target_buyers' => 5,
                'current_buyers' => 3,
                'original_price' => $groupProduct1->effective_price,
                'discounted_price' => round($groupProduct1->effective_price * 0.82, 2),
                'discount_tiers' => [
                    ['buyers' => 2, 'price' => round($groupProduct1->effective_price * 0.90, 2)],
                    ['buyers' => 5, 'price' => round($groupProduct1->effective_price * 0.82, 2)],
                ],
                'status' => 'active',
                'expires_at' => now()->addHours(36),
            ]);

            GroupBuyingParticipant::create([
                'group_id' => $g1->id,
                'user_id' => $customers[0]->id,
                'paid_amount' => $g1->discounted_price,
                'status' => 'confirmed',
            ]);
            GroupBuyingParticipant::create([
                'group_id' => $g1->id,
                'user_id' => $customers[1]->id,
                'paid_amount' => $g1->discounted_price,
                'status' => 'confirmed',
            ]);
            GroupBuyingParticipant::create([
                'group_id' => $g1->id,
                'user_id' => $customers[2]->id,
                'paid_amount' => $g1->discounted_price,
                'status' => 'confirmed',
            ]);

            $g2 = GroupBuyingGroup::create([
                'product_id' => $groupProduct2->id,
                'creator_user_id' => $customers[3]->id,
                'group_code' => 'GRP-BOATTECH',
                'target_buyers' => 2,
                'current_buyers' => 1,
                'original_price' => $groupProduct2->effective_price,
                'discounted_price' => round($groupProduct2->effective_price * 0.90, 2),
                'discount_tiers' => [
                    ['buyers' => 2, 'price' => round($groupProduct2->effective_price * 0.90, 2)],
                ],
                'status' => 'active',
                'expires_at' => now()->addHours(24),
            ]);

            GroupBuyingParticipant::create([
                'group_id' => $g2->id,
                'user_id' => $customers[3]->id,
                'paid_amount' => $g2->discounted_price,
                'status' => 'confirmed',
            ]);
        }

        // 9. Seed Sample Verified Reviews (Section 32)
        $sampleComments = [
            'Absolutely in love with the quality! Received delivery within 30 minutes in Lucknow. Highly recommended local seller!',
            'Genuine original product. Packing was tamper proof and delivery guy was very polite.',
            'Best value deal compared to other apps. Great sound quality and deep bass.',
            'Fitting is perfect and cloth material feels pure and comfortable. Worth every rupee.',
            'Fast shipping and hassle-free ordering. ShopKart local discovery works great.',
        ];

        foreach ($createdProducts as $idx => $prod) {
            if ($idx < 15) {
                for ($r = 0; $r < 3; $r++) {
                    $reviewer = $customers[($idx + $r) % count($customers)];
                    Review::create([
                        'product_id' => $prod->id,
                        'user_id' => $reviewer->id,
                        'seller_id' => $prod->seller_id,
                        'rating' => rand(4, 5),
                        'headline' => 'Verified Customer - Great Purchase!',
                        'comment' => $sampleComments[($idx + $r) % count($sampleComments)],
                        'is_verified_purchase' => true,
                        'status' => 'approved',
                    ]);
                }
            }
        }

        // 10. Seed Realistic Past Orders with Multi-Vendor Splitting (Section 11)
        for ($o = 0; $o < 5; $o++) {
            $cust = $customers[$o];
            $ordNum = 'ORD-2026-' . (10001 + $o);
            
            $p1 = $createdProducts[$o];
            $p2 = $createdProducts[$o + 2];

            $subtotal = $p1->effective_price + $p2->effective_price;
            $tax = round($subtotal * 0.18, 2);
            $grand = $subtotal + $tax;

            $mainOrder = Order::create([
                'order_number' => $ordNum,
                'user_id' => $cust->id,
                'customer_name' => $cust->name,
                'customer_email' => $cust->email,
                'customer_phone' => $cust->phone,
                'shipping_address' => [
                    'name' => $cust->name,
                    'phone' => $cust->phone,
                    'house_no' => 'Flat 204, Tower B',
                    'street' => 'Civil Lines Road',
                    'city' => $cust->preferred_city,
                    'state' => 'Uttar Pradesh',
                    'pincode' => $cust->preferred_pincode,
                ],
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_fee' => 0.0,
                'discount_amount' => 100.0,
                'coupon_code' => 'WELCOME100',
                'grand_total' => $grand - 100.0,
                'payment_method' => ($o % 2 === 0) ? 'razorpay' : 'cod',
                'payment_status' => ($o % 2 === 0) ? 'paid' : 'pending',
                'order_status' => ($o === 0) ? 'delivered' : 'processing',
                'placed_at' => now()->subDays($o + 1),
            ]);

            Payment::create([
                'order_id' => $mainOrder->id,
                'user_id' => $cust->id,
                'payment_method' => $mainOrder->payment_method,
                'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
                'amount' => $mainOrder->grand_total,
                'status' => $mainOrder->payment_status,
                'paid_at' => ($mainOrder->payment_status === 'paid') ? now()->subDays($o + 1) : null,
            ]);

            // Sub-order 1
            $so1 = SellerOrder::create([
                'order_id' => $mainOrder->id,
                'seller_id' => $p1->seller_id,
                'sub_order_number' => 'SUB-' . (10001 + $o) . '-A',
                'subtotal' => $p1->effective_price,
                'tax_amount' => round($p1->effective_price * 0.18, 2),
                'grand_total' => round($p1->effective_price * 1.18, 2),
                'platform_commission_rate' => 10.0,
                'platform_commission_amount' => round($p1->effective_price * 0.10, 2),
                'seller_net_earnings' => round(($p1->effective_price * 1.18) - ($p1->effective_price * 0.10), 2),
                'status' => ($o === 0) ? 'delivered' : 'shipped',
                'tracking_number' => 'SK-TRK-' . rand(100000, 999999),
                'courier_name' => 'ShopKart Local Express',
            ]);

            OrderItem::create([
                'order_id' => $mainOrder->id,
                'seller_order_id' => $so1->id,
                'seller_id' => $p1->seller_id,
                'product_id' => $p1->id,
                'product_name' => $p1->name,
                'sku' => $p1->sku,
                'unit_price' => $p1->effective_price,
                'quantity' => 1,
                'total_price' => $p1->effective_price,
            ]);

            Shipment::create([
                'seller_order_id' => $so1->id,
                'courier_name' => 'ShopKart Local Express',
                'tracking_number' => $so1->tracking_number,
                'shipped_at' => now()->subDays($o),
                'status' => ($o === 0) ? 'delivered' : 'in_transit',
                'current_location' => $p1->seller->city,
                'tracking_events' => [
                    ['time' => now()->subDays($o)->toDateTimeString(), 'status' => 'Picked up by rider', 'location' => $p1->seller->city, 'message' => 'Package out for delivery to customer address.'],
                ],
            ]);

            Commission::create([
                'seller_order_id' => $so1->id,
                'seller_id' => $p1->seller_id,
                'order_amount' => $so1->subtotal,
                'commission_rate' => 10.0,
                'commission_amount' => $so1->platform_commission_amount,
                'seller_earnings' => $so1->seller_net_earnings,
                'status' => 'settled',
            ]);
        }
    }
}
