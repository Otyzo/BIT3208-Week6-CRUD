<?php
// admin/manage_products.php — Manage Products Page (READ + links to Edit and Delete)
// This is the admin's main product management page.
// It shows all products in a table with buttons to edit or delete each one.

include('../config.php');
// Going up one folder with ../ because this file is inside the admin/ folder

// Check if we were redirected here after an action
// These messages tell the admin what happened
$msg = '';
if (isset($_GET['added']))   $msg = '✅ Product added successfully.';
if (isset($_GET['updated'])) $msg = '✅ Product updated successfully.';
if (isset($_GET['deleted'])) $msg = '🗑️ Product deleted successfully.';

// READ: Fetch all products from the database, newest first
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopMart Admin – Manage Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold">🛒 ShopMart <span class="text-blue-300 font-normal text-sm ml-2">Admin Panel</span></h1>
        <div class="space-x-4 text-sm">
            <a href="add_product.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition">+ Add Product</a>
            <a href="../products.php" class="hover:underline text-blue-200">View Shop</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-10">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Manage Products</h2>

        <!-- Show the feedback message if one exists -->
        <?php if ($msg): ?>
            <div class="mb-6 px-4 py-3 bg-green-100 border border-green-400 text-green-800 rounded-lg text-sm font-medium">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <!-- Products Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-blue-800 text-white">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Price (KES)</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Date Added</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                <?php if (mysqli_num_rows($result) === 0): ?>
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-400">
                            No products yet. <a href="add_product.php" class="text-blue-600 underline">Add one</a>.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400"><?= (int)$row['id'] ?></td>
                        <td class="px-4 py-3 font-semibold text-gray-800"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="px-4 py-3 text-gray-500"><?= htmlspecialchars($row['category']) ?></td>
                        <td class="px-4 py-3 font-bold text-blue-700"><?= number_format($row['price'], 2) ?></td>
                        <td class="px-4 py-3">
                            <!-- Highlight low stock in red so the admin can see it quickly -->
                            <?php if ($row['stock_qty'] <= 5): ?>
                                <span class="text-red-600 font-semibold"><?= (int)$row['stock_qty'] ?> ⚠️</span>
                            <?php else: ?>
                                <span class="text-green-700"><?= (int)$row['stock_qty'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-gray-400 text-xs">
                            <?= date('d M Y', strtotime($row['created_at'])) ?>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">

                            <!-- Edit button: links to edit page with the product's ID in the URL -->
                            <a href="edit_product.php?id=<?= (int)$row['id'] ?>"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1 rounded-lg transition font-semibold">
                                Edit
                            </a>

                            <!--
                                Delete button: uses a form with method="POST" instead of a plain link.
                                This is important — a GET link could be clicked accidentally (or by a
                                search engine) and delete the product. POST requires a deliberate form submit.
                                The confirm() pop-up gives the admin a chance to cancel.
                            -->
                            <form method="POST" action="delete_product.php" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-lg transition font-semibold">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>

                </tbody>
            </table>
        </div>
    </div>

    <footer class="text-center text-gray-400 text-sm py-8">
        ShopMart Admin &copy; <?= date('Y') ?> 
    </footer>
</body>
</html>
