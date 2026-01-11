<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Sorting & Filtering</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 28px;
        }
        .controls { 
            display: flex; 
            flex-wrap: wrap;
            justify-content: space-between; 
            margin-bottom: 30px;
            gap: 15px;
        }
        .control-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }
        select, input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        select {
            cursor: pointer;
            min-width: 150px;
            background-color: white;
        }
        select:focus, input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52,152,219,0.2);
        }
        input {
            width: 80px;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        button:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
        }
        button:active {
            transform: translateY(0);
        }
        .product-list { 
            display: flex; 
            flex-wrap: wrap; 
            justify-content: center;
            gap: 20px;
        }
        .product { 
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin: 10px; 
            padding: 15px; 
            width: 200px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }
        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: #3498db;
        }
        img { 
            width: 100%; 
            height: 150px;
            object-fit: contain;
            margin-bottom: 15px;
        }
        h4 {
            margin: 10px 0;
            color: #2c3e50;
            font-size: 16px;
            height: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        p {
            color: #3498db;
            font-weight: bold;
            margin: 10px 0 0;
            font-size: 18px;
        }
        .buy-now-btn {
            margin-top: auto;
            background-color: #2ecc71;
            padding: 8px 15px;
            font-size: 14px;
        }
        .buy-now-btn:hover {
            background-color: #27ae60;
        }
        
        @media (max-width: 768px) {
            .controls {
                flex-direction: column;
                align-items: flex-start;
            }
            .control-group {
                width: 100%;
                justify-content: space-between;
            }
            .product {
                width: calc(50% - 20px);
            }
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            h2 {
                font-size: 24px;
                margin-bottom: 20px;
            }
            .control-group {
                flex-wrap: wrap;
                gap: 8px;
            }
            .control-group label {
                width: 100%;
            }
            select, input {
                padding: 8px 12px;
                font-size: 13px;
            }
            button {
                padding: 8px 15px;
                font-size: 13px;
            }
            .product {
                width: calc(50% - 15px);
                padding: 12px;
                margin: 8px;
            }
            img {
                height: 120px;
            }
            h4 {
                font-size: 15px;
                height: 36px;
            }
            p {
                font-size: 16px;
            }
        }
        
        @media (max-width: 380px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 12px;
            }
            h2 {
                font-size: 20px;
                margin-bottom: 15px;
            }
            .controls {
                gap: 10px;
                margin-bottom: 20px;
            }
            .product {
                width: 100%;
                margin: 5px 0;
            }
            .control-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            input {
                width: 100%;
            }
            select {
                min-width: 100%;
            }
            button {
                width: 100%;
                margin-top: 5px;
            }
            img {
                height: 100px;
            }
            h4 {
                font-size: 14px;
                height: 32px;
            }
            p {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Product Sorting & Filtering</h2>
        <div class="controls">
            <div class="control-group">
                <label for="sort">Sort by:</label>
                <select id="sort" onchange="sortProducts()">
                    <option value="low">Low to High</option>
                    <option value="high">High to Low</option>
                </select>
            </div>
            <div class="control-group">
                <label>Filter Price:</label>
                <input type="number" id="minPrice" placeholder="Min" min="100" max="10000">
                <span>-</span>
                <input type="number" id="maxPrice" placeholder="Max" min="100" max="10000">
                <button onclick="filterProducts()">Apply</button>
            </div>
        </div>
        <div class="product-list" id="products"></div>
    </div>

    <script>
        const products = [
            { img: 'pimg/cc1.jpeg', name: 'Multifunction wire splitting pliers', price: 445 },
            { img: 'pimg/cc2.jpeg', name: 'Cable stripping', price: 300 },
            { img: 'pimg/cc3.jpeg', name: 'Wire plier tool', price: 399 },
            { img: 'pimg/cc4.jpeg', name: 'Stripper wire', price: 299 },
            { img: 'pimg/cc5.jpeg', name: 'Durable wire stripper', price: 380 },
            { img: 'pimg/cc6.jpeg', name: 'Electrician pliers', price: 386 },
            { img: 'pimg/cc7.jpeg', name: 'Proskit 8pk', price: 780 },
            { img: 'pimg/cc8.jpeg', name: 'Cheferyn wire stripper', price: 390 },
            { img: 'pimg/cc9.jpeg', name: 'Multi-function tool', price: 599 },
            { img: 'pimg/cc10.jpeg', name: 'Cable stripper', price: 299 },
        ];

        function displayProducts(filteredProducts) {
            const productContainer = document.getElementById('products');
            productContainer.innerHTML = '';
            
            if (filteredProducts.length === 0) {
                productContainer.innerHTML = '<p style="width:100%; text-align:center; color:#7f8c8d;">No products match your filters</p>';
                return;
            }
            
            filteredProducts.forEach(product => {
                productContainer.innerHTML += `
                    <div class="product">
                        <img src="${product.img}" alt="${product.name}">
                        <h4>${product.name}</h4>
                        <p>₹${product.price.toFixed(2)}</p>
                        <button class="buy-now-btn" onclick="buyNow('${encodeURIComponent(product.name)}', ${product.price}, '${encodeURIComponent(product.img)}')">Buy Now</button>
                    </div>
                `;
            });
        }

        function buyNow(name, price, img) {
            window.location.href = `order.php?name=${name}&price=${price}&img=${img}`;
        }

        function sortProducts() {
            const sortOption = document.getElementById('sort').value;
            const sortedProducts = [...products].sort((a, b) => 
                sortOption === 'low' ? a.price - b.price : b.price - a.price
            );
            displayProducts(sortedProducts);
        }

        function filterProducts() {
            const minPrice = parseInt(document.getElementById('minPrice').value) || 0;
            const maxPrice = parseInt(document.getElementById('maxPrice').value) || 10000;
            
            // Validate inputs
            if (minPrice > maxPrice) {
                alert("Minimum price cannot be greater than maximum price");
                return;
            }
            
            const filteredProducts = products.filter(p => p.price >= minPrice && p.price <= maxPrice);
            displayProducts(filteredProducts);
        }

        // Initial display
        displayProducts(products); 
    </script>
</body>
</html>
