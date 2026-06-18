<?php
// products.php — Public Product Listing Page (READ operation)
// This is the page customers see when they visit ShopMart.
// It fetches all available products from the database and displays them as cards.


include('config.php');
// I include config.php so this file can talk to the database.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopMart – Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tailwind CSS gives me ready-made styles without writing a lot of CSS myself -->
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navigation Bar -->
    <nav class="bg-blue-800 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-2xl font-bold tracking-wide">🛒 ShopMart</h1>
        <div class="space-x-4 text-sm">
            <a href="products.php" class="hover:underline font-semibold">Products</a>
            <a href="admin/manage_products.php" class="hover:underline">Admin Panel</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-10">

        <h2 class="text-3xl font-bold text-gray-800 mb-2">Our Products</h2>
        <p class="text-gray-500 mb-8">Browse our latest collection</p>

        <!-- Product Grid: displays product cards side by side -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        <?php
        // READ: I fetch all products where stock is more than 0
        // so customers only see items that are actually available.
        // ORDER BY created_at DESC shows the newest products first.
        $result = mysqli_query($conn,
            "SELECT * FROM products WHERE stock_qty > 0 ORDER BY created_at DESC"
        );

        // Check if there are any products in the database
        if (mysqli_num_rows($result) === 0) {
            echo '<p class="col-span-4 text-center text-gray-500 py-12">No products available yet.</p>';
        }

        // Loop through each product row and build a card for it
        while ($row = mysqli_fetch_assoc($result)) {
        // mysqli_fetch_assoc() gives me each row as an array like $row['name'], $row['price']
        ?>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition duration-200 overflow-hidden flex flex-col">

                <!-- Simple placeholder image area -->
                <div class="bg-blue-100 h-44 flex items-center justify-center text-5xl">🛍️</div>

                <div class="p-4 flex flex-col flex-grow">

                    <!-- Category label -->
                    <span class="text-xs font-semibold text-blue-600 uppercase mb-1">
                        <?= htmlspecialchars($row['category']) ?>
                        <!-- htmlspecialchars() stops any HTML tags in the category from being treated as real HTML -->
                    </span>

                    <!-- Product name -->
                    <h3 class="text-base font-bold text-gray-800 mb-1 leading-tight">
                        <?= htmlspecialchars($row['name']) ?>
                    </h3>

                    <!-- Product description -->
                    <p class="text-gray-500 text-sm mb-3 flex-grow">
                        <?= htmlspecialchars($row['description']) ?>
                    </p>

                    <div class="flex items-center justify-between mt-auto">
                        <!-- Price: number_format shows 2 decimal places, e.g. 3,500.00 -->
                        <span class="text-blue-800 font-bold text-lg">
                            KES <?= number_format($row['price'], 2) ?>
                        </span>
                        <!-- (int) makes sure stock is shown as a whole number -->
                        <span class="text-xs text-gray-400">
                            Stock: <?= (int)$row['stock_qty'] ?>
                        </span>
                    </div>

                    <button class="mt-3 w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-2 rounded-lg transition">
                        Add to Cart
                    </button>
                </div>
            </div>
        <?php } // end while loop ?>

        </div>
    </div>

    <footer class="text-center text-gray-400 text-sm py-8">
        ShopMart &copy; <?= date('Y') ?> | BIT3208 CAT 2 | Stephen Otiende
    </footer>
</body>
</html>
