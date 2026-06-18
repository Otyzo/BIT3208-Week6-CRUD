<?php
// admin/edit_product.php — Edit an Existing Product (UPDATE operation)
// This page works in two steps:
//   Step 1: Load the page — it fetches the product's current details and pre-fills the form.
//   Step 2: Submit the form — it saves the changes to the database.

include('../config.php');

$error   = '';
$product = null;

// Make sure a product ID was given in the URL (e.g. edit_product.php?id=3)
// If not, send the admin back to the product list
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_products.php");
    exit();
}

$id = intval($_GET['id']); // Convert to integer to prevent any injection through the URL

// STEP 1: Fetch the current product record from the database
// I use a prepared statement even for SELECT to keep the code safe
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result  = $stmt->get_result();
$product = $result->fetch_assoc();

// If no product was found with that ID, go back to the list
if (!$product) {
    header("Location: manage_products.php");
    exit();
}

// STEP 2: Process the form when the admin clicks Update
if (isset($_POST['update_product'])) {

    // Clean and validate the submitted values
    $name  = htmlspecialchars(trim($_POST['name']));
    $desc  = htmlspecialchars(trim($_POST['description']));
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock_qty']);
    $cat   = htmlspecialchars(trim($_POST['category']));

    if (empty($name)) {
        $error = 'Product name is required.';
    } elseif ($price <= 0) {
        $error = 'Price must be greater than zero.';
    } elseif ($stock < 0) {
        $error = 'Stock quantity cannot be negative.';
    } else {
        // UPDATE the product row in the database
        // The WHERE id = ? part is very important — it makes sure only this one
        // product is updated. Without it, ALL products would get the same values.
        $upd = $conn->prepare(
            "UPDATE products SET name = ?, description = ?, price = ?, stock_qty = ?, category = ?
             WHERE id = ?"
        );
        // "ssdiis" = string, string, decimal, integer, integer, string
        $upd->bind_param("ssdiis", $name, $desc, $price, $stock, $cat, $id);

        if ($upd->execute()) {
            header("Location: manage_products.php?updated=1");
            exit();
        } else {
            $error = 'Something went wrong. Please try again.';
        }
    }
}

// Categories list — same as add_product.php
$categories = ['Electronics','Footwear','Accessories','Kitchenware','Home & Office','Clothing','Other'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopMart Admin – Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold">🛒 ShopMart <span class="text-blue-300 font-normal text-sm ml-2">Admin Panel</span></h1>
        <a href="manage_products.php" class="text-sm text-blue-200 hover:underline">← Back to Products</a>
    </nav>

    <div class="max-w-2xl mx-auto px-4 py-12">

        <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Product</h2>
        <p class="text-gray-400 text-sm mb-8">
            Editing: <span class="font-semibold text-gray-600"><?= htmlspecialchars($product['name']) ?></span>
        </p>

        <!-- Show error message if validation failed -->
        <?php if ($error): ?>
            <div class="mb-6 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                ❌ <?= $error ?>
            </div>
        <?php endif; ?>

        <!--
            The form uses the current product values ($product['...']) to pre-fill the fields.
            If the form fails validation, it uses $_POST values instead so the admin
            doesn't lose what they typed.
        -->
        <form method="POST" class="bg-white rounded-xl shadow p-8 space-y-5">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Product Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required
                       value="<?= htmlspecialchars($_POST['name'] ?? $product['name']) ?>"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"><?= htmlspecialchars($_POST['description'] ?? $product['description']) ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Price (KES) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price" step="0.01" min="0.01" required
                           value="<?= htmlspecialchars($_POST['price'] ?? $product['price']) ?>"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock_qty" min="0" required
                           value="<?= htmlspecialchars($_POST['stock_qty'] ?? $product['stock_qty']) ?>"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                <select name="category"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select a Category --</option>
                    <?php
                    $current_cat = $_POST['category'] ?? $product['category'];
                    foreach ($categories as $cat) {
                        $selected = ($current_cat === $cat) ? 'selected' : '';
                        echo "<option value=\"$cat\" $selected>$cat</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" name="update_product"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg transition text-sm">
                    💾 Update Product
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
