<?php
// admin/add_product.php — Add New Product (CREATE operation)
// This page has a form where the admin types in product details.
// When the form is submitted, the PHP code saves the product into the database.


include('../config.php');

$error = '';

if (isset($_POST['add_product'])) {
    // The form was submitted, so I process the input

    // Step 1: Get the values from the form and clean them up
    // trim() removes extra spaces the user may have typed by accident
    // htmlspecialchars() converts characters like < > into safe versions
    $name  = htmlspecialchars(trim($_POST['name']));
    $desc  = htmlspecialchars(trim($_POST['description']));
    $price = floatval($_POST['price']);     // floatval() ensures price is a decimal number
    $stock = intval($_POST['stock_qty']);   // intval() ensures stock is a whole number
    $cat   = htmlspecialchars(trim($_POST['category']));

    // Step 2: Validate — check that required fields are not empty or invalid
    if (empty($name)) {
        $error = 'Product name is required.';
    } elseif ($price <= 0) {
        $error = 'Price must be greater than zero.';
    } elseif ($stock < 0) {
        $error = 'Stock quantity cannot be negative.';
    } else {
        // Step 3: Prepare the SQL query
        // I use ? as placeholders instead of putting values directly into the query.
        // This is called a prepared statement and it prevents SQL injection attacks.
        $stmt = $conn->prepare(
            "INSERT INTO products (name, description, price, stock_qty, category)
             VALUES (?, ?, ?, ?, ?)"
        );

        // Step 4: Bind the actual values to the placeholders
        // "ssdis" tells PHP the data types: s=string, d=decimal, i=integer
        $stmt->bind_param("ssdis", $name, $desc, $price, $stock, $cat);

        // Step 5: Run the query
        if ($stmt->execute()) {
            // Product saved — send admin back to the list with a success message
            header("Location: manage_products.php?added=1");
            exit();
        } else {
            $error = 'Something went wrong. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopMart Admin – Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold">🛒 ShopMart <span class="text-blue-300 font-normal text-sm ml-2">Admin Panel</span></h1>
        <a href="manage_products.php" class="text-sm text-blue-200 hover:underline">← Back to Products</a>
    </nav>

    <div class="max-w-2xl mx-auto px-4 py-12">

        <h2 class="text-2xl font-bold text-gray-800 mb-2">Add New Product</h2>
        <p class="text-gray-400 text-sm mb-8">Fill in the details below and click Add Product to save.</p>

        <!-- Show error message if validation failed -->
        <?php if ($error): ?>
            <div class="mb-6 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                ❌ <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white rounded-xl shadow p-8 space-y-5">

            <!-- Product Name field -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Product Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required
                       value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
                       placeholder="e.g. Wireless Headphones"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <!-- value="" keeps the typed text if the form fails validation, so the user doesn't have to retype -->
            </div>

            <!-- Description field -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          placeholder="Short description of the product..."
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
            </div>

            <!-- Price and Stock side by side -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Price (KES) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price" step="0.01" min="0.01" required
                           value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>"
                           placeholder="0.00"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock_qty" min="0" required
                           value="<?= isset($_POST['stock_qty']) ? htmlspecialchars($_POST['stock_qty']) : '' ?>"
                           placeholder="0"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <!-- Category dropdown -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                <select name="category"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select a Category --</option>
                    <?php
                    // I loop through the categories to keep the code short and clean
                    $categories = ['Electronics','Footwear','Accessories','Kitchenware','Home & Office','Clothing','Other'];
                    foreach ($categories as $cat) {
                        $selected = (isset($_POST['category']) && $_POST['category'] === $cat) ? 'selected' : '';
                        echo "<option value=\"$cat\" $selected>$cat</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Submit and Cancel buttons -->
            <div class="flex gap-3 pt-2">
                <button type="submit" name="add_product"
                        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2 rounded-lg transition text-sm">
                    ✅ Add Product
                </button>
                <a href="manage_products.php"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2 rounded-lg transition text-sm">
                    Cancel
                </a>
            </div>

        </form>
    </div>

    <footer class="text-center text-gray-400 text-sm py-8">
        ShopMart Admin &copy; <?= date('Y') ?> 
    </footer>
</body>
</html>
