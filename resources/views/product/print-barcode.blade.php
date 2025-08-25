{{-- resources/views/barcode/print.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Barcode Labels</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            color: #333;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .print-button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(52, 152, 219, 0.4);
        }

        .page-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 30px;
            color: #2c3e50;
            text-align: center;
        }

        .barcode-labels {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #e0e0e0;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .store-name {
            font-size: 1rem;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
        }

        .product-name {
            font-size: 1.1rem;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #27ae60;
            margin-bottom: 15px;
        }

        .barcode {
            margin: 15px 0;
        }

        .barcode-lines {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
            margin-bottom: 8px;
            background: white;
        }

        .barcode-line {
            background: #000;
            margin: 0 0.5px;
            height: 100%;
        }

        .barcode-text {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            color: #666;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .product-id {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-top: 8px;
        }

        .red-accent {
            background-color: #e74c3c;
            width: 100px;
            height: 8px;
            margin: 0 auto 20px auto;
            border-radius: 4px;
        }

        .no-data {
            text-align: center;
            color: #7f8c8d;
            font-size: 1.2rem;
            margin: 50px 0;
        }

        .summary {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        @media print {
            .print-button, .summary {
                display: none !important;
            }
            
            body {
                background-color: white !important;
                padding: 10px !important;
            }
            
            .product-card {
                break-inside: avoid;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
                margin-bottom: 10px;
            }

            .barcode-labels {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .barcode-labels {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .barcode-labels {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    
    <div class="red-accent"></div>
    <h1 class="page-title">Product Barcode Labels</h1>

    @if(isset($productData) && count($productData) > 0)
        <div class="summary">
            <strong>{{ collect($productData)->sum('number_of_labels') }} labels</strong> for <strong>{{ count($productData) }} products</strong>
        </div>

        <div class="barcode-labels">
            @foreach($productData as $product)
                @for($i = 0; $i < $product['number_of_labels']; $i++)
                    <div class="product-card">
                        <div class="store-name">{{ $product['store_name'] }}</div>
                        <div class="product-name">{{ $product['name'] }}</div>
                        <div class="price">Price: ${{ number_format($product['latest_selling_price'], 2) }}</div>
                        <div class="barcode">
                            <div class="barcode-lines">
                                {!!  '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($product['barcode'], 'I25') . '" alt="barcode"   />';!!}
                            </div>
                            <div class="barcode-text">
                                {{ $product['barcode'] }}
                            </div>
                        </div>
                    </div>
                @endfor
            @endforeach
        </div>
    @else
        <div class="no-data">
            No products to display. Please provide product data.
        </div>
    @endif

    <script>
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);
        };

        // Close window after printing (optional)
        window.onafterprint = function() {
            // Uncomment if you want to auto-close after printing
            // window.close();
        };
    </script>
</body>
</html>