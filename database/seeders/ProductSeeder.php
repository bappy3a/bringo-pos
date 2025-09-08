<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            return;
        }
        // Get or create default category, brand, and unit (same as your original code)
        $category = Category::firstOrCreate([
            'name' => 'Electronics',
            'business_id' => $user->business_id
        ], [
            'name' => 'Electronics',
            'description' => 'Electronic products',
            'business_id' => $user->business_id
        ]);
        
        $brand = Brand::firstOrCreate([
            'name' => 'Generic',
            'business_id' => $user->business_id
        ], [
            'name' => 'Generic',
            'description' => 'Generic brand',
            'business_id' => $user->business_id
        ]);
        
        $unit = Unit::firstOrCreate([
            'name' => 'Piece',
            'business_id' => $user->business_id
        ], [
            'name' => 'Piece',
            'description' => 'Piece unit',
            'business_id' => $user->business_id
        ]);
        
        $products = [
            // Laptops & Computers (20 items)
            ['name' => 'MacBook Pro M3 14-inch', 'slug' => 'macbook-pro-m3-14-inch', 'sku' => 'LAP001', 'barcode' => '1234567890123', 'description' => 'Apple MacBook Pro with M3 chip'],
            ['name' => 'Dell XPS 13 Plus', 'slug' => 'dell-xps-13-plus', 'sku' => 'LAP002', 'barcode' => '1234567890124', 'description' => 'Ultra-thin Dell laptop'],
            ['name' => 'HP Spectre x360', 'slug' => 'hp-spectre-x360', 'sku' => 'LAP003', 'barcode' => '1234567890125', 'description' => 'Convertible premium laptop'],
            ['name' => 'Lenovo ThinkPad X1 Carbon', 'slug' => 'lenovo-thinkpad-x1-carbon', 'sku' => 'LAP004', 'barcode' => '1234567890126', 'description' => 'Business ultrabook'],
            ['name' => 'ASUS ZenBook Pro', 'slug' => 'asus-zenbook-pro', 'sku' => 'LAP005', 'barcode' => '1234567890127', 'description' => 'Creator-focused laptop'],
            ['name' => 'Microsoft Surface Laptop 5', 'slug' => 'microsoft-surface-laptop-5', 'sku' => 'LAP006', 'barcode' => '1234567890128', 'description' => 'Premium Windows laptop'],
            ['name' => 'MacBook Air M2', 'slug' => 'macbook-air-m2', 'sku' => 'LAP007', 'barcode' => '1234567890129', 'description' => 'Lightweight Mac laptop'],
            ['name' => 'Razer Blade 15 Gaming', 'slug' => 'razer-blade-15-gaming', 'sku' => 'LAP008', 'barcode' => '1234567890130', 'description' => 'High-performance gaming laptop'],
            ['name' => 'Acer Predator Helios 300', 'slug' => 'acer-predator-helios-300', 'sku' => 'LAP009', 'barcode' => '1234567890131', 'description' => 'Gaming laptop with RTX graphics'],
            ['name' => 'iMac 24-inch M3', 'slug' => 'imac-24-inch-m3', 'sku' => 'DES001', 'barcode' => '1234567890132', 'description' => 'All-in-one desktop computer'],
            ['name' => 'Dell Inspiron Desktop', 'slug' => 'dell-inspiron-desktop', 'sku' => 'DES002', 'barcode' => '1234567890133', 'description' => 'Family desktop computer'],
            ['name' => 'HP Pavilion All-in-One', 'slug' => 'hp-pavilion-all-in-one', 'sku' => 'DES003', 'barcode' => '1234567890134', 'description' => 'Compact desktop solution'],
            ['name' => 'Mac Studio M2 Max', 'slug' => 'mac-studio-m2-max', 'sku' => 'DES004', 'barcode' => '1234567890135', 'description' => 'Compact pro desktop'],
            ['name' => 'ASUS ROG Gaming Desktop', 'slug' => 'asus-rog-gaming-desktop', 'sku' => 'DES005', 'barcode' => '1234567890136', 'description' => 'High-end gaming PC'],
            ['name' => 'Lenovo IdeaCentre Mini', 'slug' => 'lenovo-ideacentre-mini', 'sku' => 'DES006', 'barcode' => '1234567890137', 'description' => 'Compact desktop PC'],
            ['name' => 'Intel NUC 13 Pro', 'slug' => 'intel-nuc-13-pro', 'sku' => 'DES007', 'barcode' => '1234567890138', 'description' => 'Mini PC for business'],
            ['name' => 'Mac Pro M2 Ultra', 'slug' => 'mac-pro-m2-ultra', 'sku' => 'DES008', 'barcode' => '1234567890139', 'description' => 'Professional workstation'],
            ['name' => 'Surface Studio 2+', 'slug' => 'surface-studio-2-plus', 'sku' => 'DES009', 'barcode' => '1234567890140', 'description' => 'Creative all-in-one PC'],
            ['name' => 'HP Z4 G5 Workstation', 'slug' => 'hp-z4-g5-workstation', 'sku' => 'DES010', 'barcode' => '1234567890141', 'description' => 'Professional workstation'],
            ['name' => 'Alienware Aurora R15', 'slug' => 'alienware-aurora-r15', 'sku' => 'DES011', 'barcode' => '1234567890142', 'description' => 'Premium gaming desktop'],
        
            // Smartphones & Tablets (25 items)
            ['name' => 'iPhone 15 Pro Max', 'slug' => 'iphone-15-pro-max', 'sku' => 'PHN001', 'barcode' => '2234567890123', 'description' => 'Latest iPhone with titanium design'],
            ['name' => 'Samsung Galaxy S24 Ultra', 'slug' => 'samsung-galaxy-s24-ultra', 'sku' => 'PHN002', 'barcode' => '2234567890124', 'description' => 'Android flagship with S Pen'],
            ['name' => 'Google Pixel 8 Pro', 'slug' => 'google-pixel-8-pro', 'sku' => 'PHN003', 'barcode' => '2234567890125', 'description' => 'AI-powered Android phone'],
            ['name' => 'OnePlus 12', 'slug' => 'oneplus-12', 'sku' => 'PHN004', 'barcode' => '2234567890126', 'description' => 'Fast-charging flagship phone'],
            ['name' => 'iPhone 15', 'slug' => 'iphone-15', 'sku' => 'PHN005', 'barcode' => '2234567890127', 'description' => 'Standard iPhone model'],
            ['name' => 'Samsung Galaxy Z Fold 5', 'slug' => 'samsung-galaxy-z-fold-5', 'sku' => 'PHN006', 'barcode' => '2234567890128', 'description' => 'Foldable smartphone'],
            ['name' => 'Xiaomi 14 Ultra', 'slug' => 'xiaomi-14-ultra', 'sku' => 'PHN007', 'barcode' => '2234567890129', 'description' => 'Camera-focused smartphone'],
            ['name' => 'Sony Xperia 1 V', 'slug' => 'sony-xperia-1-v', 'sku' => 'PHN008', 'barcode' => '2234567890130', 'description' => 'Photography smartphone'],
            ['name' => 'Nothing Phone 2', 'slug' => 'nothing-phone-2', 'sku' => 'PHN009', 'barcode' => '2234567890131', 'description' => 'Unique transparent design'],
            ['name' => 'Motorola Edge 40 Pro', 'slug' => 'motorola-edge-40-pro', 'sku' => 'PHN010', 'barcode' => '2234567890132', 'description' => 'Premium Android phone'],
            ['name' => 'iPad Pro 12.9-inch M2', 'slug' => 'ipad-pro-12-9-inch-m2', 'sku' => 'TAB001', 'barcode' => '2234567890133', 'description' => 'Professional tablet'],
            ['name' => 'Samsung Galaxy Tab S9 Ultra', 'slug' => 'samsung-galaxy-tab-s9-ultra', 'sku' => 'TAB002', 'barcode' => '2234567890134', 'description' => 'Large Android tablet'],
            ['name' => 'iPad Air 10.9-inch', 'slug' => 'ipad-air-10-9-inch', 'sku' => 'TAB003', 'barcode' => '2234567890135', 'description' => 'Mid-range iPad'],
            ['name' => 'Microsoft Surface Pro 9', 'slug' => 'microsoft-surface-pro-9', 'sku' => 'TAB004', 'barcode' => '2234567890136', 'description' => '2-in-1 Windows tablet'],
            ['name' => 'iPad Mini 6th Gen', 'slug' => 'ipad-mini-6th-gen', 'sku' => 'TAB005', 'barcode' => '2234567890137', 'description' => 'Compact iPad'],
            ['name' => 'Samsung Galaxy Tab A8', 'slug' => 'samsung-galaxy-tab-a8', 'sku' => 'TAB006', 'barcode' => '2234567890138', 'description' => 'Budget Android tablet'],
            ['name' => 'Lenovo Tab P12 Pro', 'slug' => 'lenovo-tab-p12-pro', 'sku' => 'TAB007', 'barcode' => '2234567890139', 'description' => 'Premium Android tablet'],
            ['name' => 'Amazon Fire Max 11', 'slug' => 'amazon-fire-max-11', 'sku' => 'TAB008', 'barcode' => '2234567890140', 'description' => 'Entertainment tablet'],
            ['name' => 'Google Pixel Tablet', 'slug' => 'google-pixel-tablet', 'sku' => 'TAB009', 'barcode' => '2234567890141', 'description' => 'AI-powered Android tablet'],
            ['name' => 'iPad 10th Generation', 'slug' => 'ipad-10th-generation', 'sku' => 'TAB010', 'barcode' => '2234567890142', 'description' => 'Entry-level iPad'],
            ['name' => 'HUAWEI MatePad Pro', 'slug' => 'huawei-matepad-pro', 'sku' => 'TAB011', 'barcode' => '2234567890143', 'description' => 'Professional Android tablet'],
            ['name' => 'Xiaomi Pad 6', 'slug' => 'xiaomi-pad-6', 'sku' => 'TAB012', 'barcode' => '2234567890144', 'description' => 'Value Android tablet'],
            ['name' => 'Samsung Galaxy Z Flip 5', 'slug' => 'samsung-galaxy-z-flip-5', 'sku' => 'PHN011', 'barcode' => '2234567890145', 'description' => 'Compact foldable phone'],
            ['name' => 'iPhone 14 Pro', 'slug' => 'iphone-14-pro', 'sku' => 'PHN012', 'barcode' => '2234567890146', 'description' => 'Previous gen Pro iPhone'],
            ['name' => 'Google Pixel 7a', 'slug' => 'google-pixel-7a', 'sku' => 'PHN013', 'barcode' => '2234567890147', 'description' => 'Mid-range Pixel phone'],
        
            // Audio Equipment (20 items)
            ['name' => 'Sony WH-1000XM5 Headphones', 'slug' => 'sony-wh-1000xm5-headphones', 'sku' => 'AUD001', 'barcode' => '3234567890123', 'description' => 'Noise-canceling headphones'],
            ['name' => 'AirPods Pro 2nd Gen', 'slug' => 'airpods-pro-2nd-gen', 'sku' => 'AUD002', 'barcode' => '3234567890124', 'description' => 'Wireless earbuds with ANC'],
            ['name' => 'Bose QuietComfort 45', 'slug' => 'bose-quietcomfort-45', 'sku' => 'AUD003', 'barcode' => '3234567890125', 'description' => 'Premium noise-canceling headphones'],
            ['name' => 'Samsung Galaxy Buds2 Pro', 'slug' => 'samsung-galaxy-buds2-pro', 'sku' => 'AUD004', 'barcode' => '3234567890126', 'description' => 'Wireless earbuds for Samsung'],
            ['name' => 'JBL Charge 5 Speaker', 'slug' => 'jbl-charge-5-speaker', 'sku' => 'AUD005', 'barcode' => '3234567890127', 'description' => 'Portable Bluetooth speaker'],
            ['name' => 'Sonos One Gen 2', 'slug' => 'sonos-one-gen-2', 'sku' => 'AUD006', 'barcode' => '3234567890128', 'description' => 'Smart speaker with Alexa'],
            ['name' => 'Audio-Technica ATH-M50x', 'slug' => 'audio-technica-ath-m50x', 'sku' => 'AUD007', 'barcode' => '3234567890129', 'description' => 'Studio monitor headphones'],
            ['name' => 'Marshall Kilburn II', 'slug' => 'marshall-kilburn-ii', 'sku' => 'AUD008', 'barcode' => '3234567890130', 'description' => 'Vintage-style Bluetooth speaker'],
            ['name' => 'Beats Studio3 Wireless', 'slug' => 'beats-studio3-wireless', 'sku' => 'AUD009', 'barcode' => '3234567890131', 'description' => 'Wireless headphones with ANC'],
            ['name' => 'Sennheiser HD 660S', 'slug' => 'sennheiser-hd-660s', 'sku' => 'AUD010', 'barcode' => '3234567890132', 'description' => 'Open-back audiophile headphones'],
            ['name' => 'Amazon Echo Dot 5th Gen', 'slug' => 'amazon-echo-dot-5th-gen', 'sku' => 'AUD011', 'barcode' => '3234567890133', 'description' => 'Compact smart speaker'],
            ['name' => 'Google Nest Audio', 'slug' => 'google-nest-audio', 'sku' => 'AUD012', 'barcode' => '3234567890134', 'description' => 'Smart speaker with Google Assistant'],
            ['name' => 'Bang & Olufsen Beoplay H9i', 'slug' => 'bang-olufsen-beoplay-h9i', 'sku' => 'AUD013', 'barcode' => '3234567890135', 'description' => 'Luxury wireless headphones'],
            ['name' => 'Ultimate Ears BOOM 3', 'slug' => 'ultimate-ears-boom-3', 'sku' => 'AUD014', 'barcode' => '3234567890136', 'description' => '360-degree wireless speaker'],
            ['name' => 'AirPods 3rd Generation', 'slug' => 'airpods-3rd-generation', 'sku' => 'AUD015', 'barcode' => '3234567890137', 'description' => 'Standard wireless earbuds'],
            ['name' => 'Jabra Elite 85h', 'slug' => 'jabra-elite-85h', 'sku' => 'AUD016', 'barcode' => '3234567890138', 'description' => 'Business-focused headphones'],
            ['name' => 'Sony SRS-XB43 Speaker', 'slug' => 'sony-srs-xb43-speaker', 'sku' => 'AUD017', 'barcode' => '3234567890139', 'description' => 'Extra bass portable speaker'],
            ['name' => 'Shure SM7B Microphone', 'slug' => 'shure-sm7b-microphone', 'sku' => 'AUD018', 'barcode' => '3234567890140', 'description' => 'Professional broadcast microphone'],
            ['name' => 'Blue Yeti USB Microphone', 'slug' => 'blue-yeti-usb-microphone', 'sku' => 'AUD019', 'barcode' => '3234567890141', 'description' => 'USB microphone for streaming'],
            ['name' => 'HomePod 2nd Generation', 'slug' => 'homepod-2nd-generation', 'sku' => 'AUD020', 'barcode' => '3234567890142', 'description' => 'Apple smart speaker'],
        
            // Smart Home & IoT (15 items)
            ['name' => 'Amazon Echo Show 10', 'slug' => 'amazon-echo-show-10', 'sku' => 'SMT001', 'barcode' => '4234567890123', 'description' => 'Smart display with rotating screen'],
            ['name' => 'Google Nest Hub Max', 'slug' => 'google-nest-hub-max', 'sku' => 'SMT002', 'barcode' => '4234567890124', 'description' => 'Smart display with camera'],
            ['name' => 'Ring Video Doorbell Pro 2', 'slug' => 'ring-video-doorbell-pro-2', 'sku' => 'SMT003', 'barcode' => '4234567890125', 'description' => 'Smart doorbell with 3D motion'],
            ['name' => 'Nest Learning Thermostat', 'slug' => 'nest-learning-thermostat', 'sku' => 'SMT004', 'barcode' => '4234567890126', 'description' => 'Smart programmable thermostat'],
            ['name' => 'Philips Hue Starter Kit', 'slug' => 'philips-hue-starter-kit', 'sku' => 'SMT005', 'barcode' => '4234567890127', 'description' => 'Smart LED lighting system'],
            ['name' => 'Arlo Pro 4 Security Camera', 'slug' => 'arlo-pro-4-security-camera', 'sku' => 'SMT006', 'barcode' => '4234567890128', 'description' => 'Wireless security camera'],
            ['name' => 'August Smart Lock Pro', 'slug' => 'august-smart-lock-pro', 'sku' => 'SMT007', 'barcode' => '4234567890129', 'description' => 'WiFi-enabled smart lock'],
            ['name' => 'ecobee SmartThermostat', 'slug' => 'ecobee-smartthermostat', 'sku' => 'SMT008', 'barcode' => '4234567890130', 'description' => 'Voice-controlled thermostat'],
            ['name' => 'Samsung SmartThings Hub', 'slug' => 'samsung-smartthings-hub', 'sku' => 'SMT009', 'barcode' => '4234567890131', 'description' => 'Smart home automation hub'],
            ['name' => 'TP-Link Kasa Smart Plugs', 'slug' => 'tp-link-kasa-smart-plugs', 'sku' => 'SMT010', 'barcode' => '4234567890132', 'description' => 'WiFi smart outlet plugs'],
            ['name' => 'Wyze Cam v3', 'slug' => 'wyze-cam-v3', 'sku' => 'SMT011', 'barcode' => '4234567890133', 'description' => 'Affordable security camera'],
            ['name' => 'Sonos Beam Gen 2', 'slug' => 'sonos-beam-gen-2', 'sku' => 'SMT012', 'barcode' => '4234567890134', 'description' => 'Smart soundbar'],
            ['name' => 'iRobot Roomba j7+', 'slug' => 'irobot-roomba-j7-plus', 'sku' => 'SMT013', 'barcode' => '4234567890135', 'description' => 'Self-emptying robot vacuum'],
            ['name' => 'Nest Protect Smoke Detector', 'slug' => 'nest-protect-smoke-detector', 'sku' => 'SMT014', 'barcode' => '4234567890136', 'description' => 'Smart smoke and CO detector'],
            ['name' => 'Lutron Caseta Smart Switch', 'slug' => 'lutron-caseta-smart-switch', 'sku' => 'SMT015', 'barcode' => '4234567890137', 'description' => 'Wireless smart light switch'],
        
            // Gaming Devices (20 items)
            ['name' => 'PlayStation 5 Console', 'slug' => 'playstation-5-console', 'sku' => 'GAM001', 'barcode' => '5234567890123', 'description' => 'Next-gen gaming console'],
            ['name' => 'Xbox Series X', 'slug' => 'xbox-series-x', 'sku' => 'GAM002', 'barcode' => '5234567890124', 'description' => 'Microsoft gaming console'],
            ['name' => 'Nintendo Switch OLED', 'slug' => 'nintendo-switch-oled', 'sku' => 'GAM003', 'barcode' => '5234567890125', 'description' => 'Hybrid gaming console'],
            ['name' => 'Steam Deck 512GB', 'slug' => 'steam-deck-512gb', 'sku' => 'GAM004', 'barcode' => '5234567890126', 'description' => 'Handheld PC gaming device'],
            ['name' => 'ASUS ROG Ally', 'slug' => 'asus-rog-ally', 'sku' => 'GAM005', 'barcode' => '5234567890127', 'description' => 'Windows handheld gaming PC'],
            ['name' => 'Logitech G Pro X Superlight', 'slug' => 'logitech-g-pro-x-superlight', 'sku' => 'GAM006', 'barcode' => '5234567890128', 'description' => 'Wireless gaming mouse'],
            ['name' => 'Razer DeathAdder V3 Pro', 'slug' => 'razer-deathadder-v3-pro', 'sku' => 'GAM007', 'barcode' => '5234567890129', 'description' => 'Ergonomic gaming mouse'],
            ['name' => 'Corsair K95 RGB Platinum', 'slug' => 'corsair-k95-rgb-platinum', 'sku' => 'GAM008', 'barcode' => '5234567890130', 'description' => 'Mechanical gaming keyboard'],
            ['name' => 'SteelSeries Apex Pro TKL', 'slug' => 'steelseries-apex-pro-tkl', 'sku' => 'GAM009', 'barcode' => '5234567890131', 'description' => 'Adjustable mechanical keyboard'],
            ['name' => 'HyperX Cloud II Headset', 'slug' => 'hyperx-cloud-ii-headset', 'sku' => 'GAM010', 'barcode' => '5234567890132', 'description' => '7.1 surround gaming headset'],
            ['name' => 'Xbox Wireless Controller', 'slug' => 'xbox-wireless-controller', 'sku' => 'GAM011', 'barcode' => '5234567890133', 'description' => 'Wireless gaming controller'],
            ['name' => 'DualSense Wireless Controller', 'slug' => 'dualsense-wireless-controller', 'sku' => 'GAM012', 'barcode' => '5234567890134', 'description' => 'PS5 haptic controller'],
            ['name' => '8BitDo Pro 2 Controller', 'slug' => '8bitdo-pro-2-controller', 'sku' => 'GAM013', 'barcode' => '5234567890135', 'description' => 'Retro-style wireless controller'],
            ['name' => 'Elgato Stream Deck', 'slug' => 'elgato-stream-deck', 'sku' => 'GAM014', 'barcode' => '5234567890136', 'description' => 'Live content creation controller'],
            ['name' => 'SCUF Instinct Pro Controller', 'slug' => 'scuf-instinct-pro-controller', 'sku' => 'GAM015', 'barcode' => '5234567890137', 'description' => 'Professional Xbox controller'],
            ['name' => 'Nintendo Pro Controller', 'slug' => 'nintendo-pro-controller', 'sku' => 'GAM016', 'barcode' => '5234567890138', 'description' => 'Wireless Switch controller'],
            ['name' => 'Razer Kishi V2 Mobile Controller', 'slug' => 'razer-kishi-v2-mobile-controller', 'sku' => 'GAM017', 'barcode' => '5234567890139', 'description' => 'Mobile gaming controller'],
            ['name' => 'ASUS ROG Phone 7', 'slug' => 'asus-rog-phone-7', 'sku' => 'GAM018', 'barcode' => '5234567890140', 'description' => 'Gaming smartphone'],
            ['name' => 'Turtle Beach Stealth 700 Gen 2', 'slug' => 'turtle-beach-stealth-700-gen-2', 'sku' => 'GAM019', 'barcode' => '5234567890141', 'description' => 'Wireless gaming headset'],
            ['name' => 'Backbone One Mobile Controller', 'slug' => 'backbone-one-mobile-controller', 'sku' => 'GAM020', 'barcode' => '5234567890142', 'description' => 'iPhone gaming controller'],
        
            // TV & Entertainment (15 items)
            ['name' => 'Samsung 65" QLED 4K TV', 'slug' => 'samsung-65-qled-4k-tv', 'sku' => 'TVS001', 'barcode' => '6234567890123', 'description' => 'Quantum dot LED smart TV'],
            ['name' => 'LG 55" OLED C3 TV', 'slug' => 'lg-55-oled-c3-tv', 'sku' => 'TVS002', 'barcode' => '6234567890124', 'description' => 'Self-lit OLED smart TV'],
            ['name' => 'Sony 75" Bravia XR TV', 'slug' => 'sony-75-bravia-xr-tv', 'sku' => 'TVS003', 'barcode' => '6234567890125', 'description' => 'Cognitive processor TV'],
            ['name' => 'TCL 65" 6-Series Mini LED', 'slug' => 'tcl-65-6-series-mini-led', 'sku' => 'TVS004', 'barcode' => '6234567890126', 'description' => 'QLED Mini LED smart TV'],
            ['name' => 'Hisense 55" U8K ULED TV', 'slug' => 'hisense-55-u8k-uled-tv', 'sku' => 'TVS005', 'barcode' => '6234567890127', 'description' => 'Quantum dot ULED TV'],
            ['name' => 'Apple TV 4K 3rd Gen', 'slug' => 'apple-tv-4k-3rd-gen', 'sku' => 'STR001', 'barcode' => '6234567890128', 'description' => 'Premium streaming device'],
            ['name' => 'NVIDIA Shield TV Pro', 'slug' => 'nvidia-shield-tv-pro', 'sku' => 'STR002', 'barcode' => '6234567890129', 'description' => 'Android TV streaming device'],
            ['name' => 'Roku Ultra 4K', 'slug' => 'roku-ultra-4k', 'sku' => 'STR003', 'barcode' => '6234567890130', 'description' => '4K HDR streaming player'],
            ['name' => 'Amazon Fire TV Stick 4K Max', 'slug' => 'amazon-fire-tv-stick-4k-max', 'sku' => 'STR004', 'barcode' => '6234567890131', 'description' => 'Streaming stick with Alexa'],
            ['name' => 'Chromecast with Google TV', 'slug' => 'chromecast-with-google-tv', 'sku' => 'STR005', 'barcode' => '6234567890132', 'description' => '4K streaming device'],
            ['name' => 'Yamaha YAS-209 Soundbar', 'slug' => 'yamaha-yas-209-soundbar', 'sku' => 'AUD021', 'barcode' => '6234567890133', 'description' => 'Soundbar with wireless subwoofer'],
            ['name' => 'Bose TV Speaker', 'slug' => 'bose-tv-speaker', 'sku' => 'AUD022', 'barcode' => '6234567890134', 'description' => 'Compact TV soundbar'],
            ['name' => 'JBL Bar 9.1 Soundbar', 'slug' => 'jbl-bar-9-1-soundbar', 'sku' => 'AUD023', 'barcode' => '6234567890135', 'description' => 'Dolby Atmos soundbar system'],
            ['name' => 'Samsung HW-Q990C Soundbar', 'slug' => 'samsung-hw-q990c-soundbar', 'sku' => 'AUD024', 'barcode' => '6234567890136', 'description' => '11.1.4 channel soundbar'],
            ['name' => 'Sony HT-A7000 Soundbar', 'slug' => 'sony-ht-a7000-soundbar', 'sku' => 'AUD025', 'barcode' => '6234567890137', 'description' => '7.1.2 channel Dolby Atmos'],
        
            // Cameras & Photography (15 items)
            ['name' => 'Canon EOS R5 Mirrorless', 'slug' => 'canon-eos-r5-mirrorless', 'sku' => 'CAM001', 'barcode' => '7234567890123', 'description' => '45MP full-frame mirrorless camera'],
            ['name' => 'Sony A7 IV Full Frame', 'slug' => 'sony-a7-iv-full-frame', 'sku' => 'CAM002', 'barcode' => '7234567890124', 'description' => '33MP hybrid camera'],
            ['name' => 'Nikon Z9 Mirrorless', 'slug' => 'nikon-z9-mirrorless', 'sku' => 'CAM003', 'barcode' => '7234567890125', 'description' => 'Professional mirrorless camera'],
            ['name' => 'Fujifilm X-T5', 'slug' => 'fujifilm-x-t5', 'sku' => 'CAM004', 'barcode' => '7234567890126', 'description' => 'APS-C mirrorless camera'],
            ['name' => 'Panasonic Lumix GH6', 'slug' => 'panasonic-lumix-gh6', 'sku' => 'CAM005', 'barcode' => '7234567890127', 'description' => 'Micro Four Thirds camera'],
            ['name' => 'Canon RF 24-70mm f/2.8L', 'slug' => 'canon-rf-24-70mm-f-2-8l', 'sku' => 'LEN001', 'barcode' => '7234567890128', 'description' => 'Professional zoom lens'],
            ['name' => 'Sony FE 85mm f/1.4 GM', 'slug' => 'sony-fe-85mm-f-1-4-gm', 'sku' => 'LEN002', 'barcode' => '7234567890129', 'description' => 'Portrait prime lens'],
            ['name' => 'Nikon Z 50mm f/1.2 S', 'slug' => 'nikon-z-50mm-f-1-2-s', 'sku' => 'LEN003', 'barcode' => '7234567890130', 'description' => 'Fast prime lens'],
            ['name' => 'DJI Mini 3 Pro Drone', 'slug' => 'dji-mini-3-pro-drone', 'sku' => 'DRN001', 'barcode' => '7234567890131', 'description' => 'Compact 4K drone'],
            ['name' => 'DJI Air 2S Drone', 'slug' => 'dji-air-2s-drone', 'sku' => 'DRN002', 'barcode' => '7234567890132', 'description' => '1-inch sensor drone'],
            ['name' => 'GoPro Hero 12 Black', 'slug' => 'gopro-hero-12-black', 'sku' => 'ACT001', 'barcode' => '7234567890133', 'description' => 'Action camera with 5.3K video'],
            ['name' => 'DJI Action 2', 'slug' => 'dji-action-2', 'sku' => 'ACT002', 'barcode' => '7234567890134', 'description' => 'Compact action camera'],
            ['name' => 'Insta360 X3 Action Camera', 'slug' => 'insta360-x3-action-camera', 'sku' => 'ACT003', 'barcode' => '7234567890135', 'description' => '360-degree action camera'],
            ['name' => 'Polaroid Now+ Instant Camera', 'slug' => 'polaroid-now-plus-instant-camera', 'sku' => 'CAM006', 'barcode' => '7234567890136', 'description' => 'App-connected instant camera'],
            ['name' => 'Fujifilm Instax Mini 11', 'slug' => 'fujifilm-instax-mini-11', 'sku' => 'CAM007', 'barcode' => '7234567890137', 'description' => 'Instant film camera'],
        
            // Wearables & Fitness (15 items)
            ['name' => 'Apple Watch Series 9', 'slug' => 'apple-watch-series-9', 'sku' => 'WER001', 'barcode' => '8234567890123', 'description' => 'Advanced health and fitness watch'],
            ['name' => 'Samsung Galaxy Watch 6', 'slug' => 'samsung-galaxy-watch-6', 'sku' => 'WER002', 'barcode' => '8234567890124', 'description' => 'Wear OS smartwatch'],
            ['name' => 'Garmin Forerunner 965', 'slug' => 'garmin-forerunner-965', 'sku' => 'WER003', 'barcode' => '8234567890125', 'description' => 'Premium GPS running watch'],
            ['name' => 'Fitbit Charge 5', 'slug' => 'fitbit-charge-5', 'sku' => 'WER004', 'barcode' => '8234567890126', 'description' => 'Advanced fitness tracker'],
            ['name' => 'WHOOP 4.0', 'slug' => 'whoop-4-0', 'sku' => 'WER005', 'barcode' => '8234567890127', 'description' => 'Continuous health monitor'],
            ['name' => 'Oura Ring Gen 3', 'slug' => 'oura-ring-gen-3', 'sku' => 'WER006', 'barcode' => '8234567890128', 'description' => 'Smart ring fitness tracker'],
            ['name' => 'Polar Vantage V3', 'slug' => 'polar-vantage-v3', 'sku' => 'WER007', 'barcode' => '8234567890129', 'description' => 'Premium sports watch'],
            ['name' => 'Amazfit GTR 4', 'slug' => 'amazfit-gtr-4', 'sku' => 'WER008', 'barcode' => '8234567890130', 'description' => 'GPS fitness smartwatch'],
            ['name' => 'Suunto 9 Peak Pro', 'slug' => 'suunto-9-peak-pro', 'sku' => 'WER009', 'barcode' => '8234567890131', 'description' => 'Outdoor sports watch'],
            ['name' => 'Withings ScanWatch 2', 'slug' => 'withings-scanwatch-2', 'sku' => 'WER010', 'barcode' => '8234567890132', 'description' => 'Hybrid health smartwatch'],
            ['name' => 'Coros Pace 3', 'slug' => 'coros-pace-3', 'sku' => 'WER011', 'barcode' => '8234567890133', 'description' => 'Ultra-light GPS watch'],
            ['name' => 'Huawei Watch GT 4', 'slug' => 'huawei-watch-gt-4', 'sku' => 'WER012', 'barcode' => '8234567890134', 'description' => 'Long-battery smartwatch'],
            ['name' => 'Xiaomi Mi Band 8', 'slug' => 'xiaomi-mi-band-8', 'sku' => 'WER013', 'barcode' => '8234567890135', 'description' => 'Affordable fitness tracker'],
            ['name' => 'Apple Watch Ultra 2', 'slug' => 'apple-watch-ultra-2', 'sku' => 'WER014', 'barcode' => '8234567890136', 'description' => 'Rugged outdoor smartwatch'],
            ['name' => 'Garmin Venu 3', 'slug' => 'garmin-venu-3', 'sku' => 'WER015', 'barcode' => '8234567890137', 'description' => 'AMOLED GPS smartwatch'],
        
            // Accessories & Components (10 items)
            ['name' => 'Anker PowerCore 26800 Power Bank', 'slug' => 'anker-powercore-26800-power-bank', 'sku' => 'ACC001', 'barcode' => '9234567890123', 'description' => 'High-capacity portable charger'],
            ['name' => 'Belkin MagSafe 3-in-1 Charger', 'slug' => 'belkin-magsafe-3-in-1-charger', 'sku' => 'ACC002', 'barcode' => '9234567890124', 'description' => 'Wireless charging station'],
            ['name' => 'Samsung T7 Portable SSD 1TB', 'slug' => 'samsung-t7-portable-ssd-1tb', 'sku' => 'ACC003', 'barcode' => '9234567890125', 'description' => 'External solid state drive'],
            ['name' => 'Western Digital My Passport 2TB', 'slug' => 'western-digital-my-passport-2tb', 'sku' => 'ACC004', 'barcode' => '9234567890126', 'description' => 'Portable hard drive'],
            ['name' => 'CalDigit TS3 Plus Dock', 'slug' => 'caldigit-ts3-plus-dock', 'sku' => 'ACC005', 'barcode' => '9234567890127', 'description' => 'Thunderbolt 3 dock'],
            ['name' => 'Corsair Vengeance LPX 32GB RAM', 'slug' => 'corsair-vengeance-lpx-32gb-ram', 'sku' => 'COM001', 'barcode' => '9234567890128', 'description' => 'DDR4 desktop memory'],
            ['name' => 'NVIDIA GeForce RTX 4080 GPU', 'slug' => 'nvidia-geforce-rtx-4080-gpu', 'sku' => 'COM002', 'barcode' => '9234567890129', 'description' => 'High-end graphics card'],
            ['name' => 'Samsung 980 PRO NVMe SSD 2TB', 'slug' => 'samsung-980-pro-nvme-ssd-2tb', 'sku' => 'COM003', 'barcode' => '9234567890130', 'description' => 'PCIe 4.0 internal SSD'],
            ['name' => 'AMD Ryzen 9 7950X Processor', 'slug' => 'amd-ryzen-9-7950x-processor', 'sku' => 'COM004', 'barcode' => '9234567890131', 'description' => '16-core desktop CPU'],
            ['name' => 'Intel Core i9-13900K Processor', 'slug' => 'intel-core-i9-13900k-processor', 'sku' => 'COM005', 'barcode' => '9234567890132', 'description' => 'High-performance desktop CPU'],
        ];
        
        foreach ($products as $productData) {
            $productData['category_id'] = $category->id;
            $productData['brand_id'] = $brand->id;
            $productData['unit_id'] = $unit->id;
            $productData['user_id'] = $user->id;
            $productData['business_id'] = $user->business_id;
            $productData['status'] = 'active';
            
            Product::firstOrCreate(['sku' => $productData['sku']], $productData);
        }
        
    }
}
