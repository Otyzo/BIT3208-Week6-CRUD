<?php
// admin/delete_product.php — Delete a Product (DELETE operation)
// This file only handles the deletion — it has no HTML form of its own.
// The Delete button in manage_products.php submits a POST form to this file.
//
// IMPORTANT SECURITY POINT:
// I only allow POST requests here, not GET.
// A GET request would mean someone could delete a product just by visiting a URL.
// That is dangerous because links can be clicked accidentally, or crawled by search engines.
// Using POST makes deletion a deliberate, intentional action.
//

include('../config.php');

// Check that this is a POST request — if not, send the user back to the product list
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: manage_products.php");
    exit();
}

// Make sure a product ID was submitted and that it is a valid number
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header("Location: manage_products.php");
    exit();
}

$id = intval($_POST['id']); // Convert to integer for safety

// First, check that a product with this ID actually exists in the database
// This prevents errors if the admin tries to delete a product that was already removed
$check = $conn->prepare("SELECT id FROM products WHERE id = ?");
$check->bind_param("i", $id);
$check->execute();
$check->store_result();

if ($check->num_rows === 0) {
    // No product found — go back silently
    header("Location: manage_products.php");
    exit();
}

// Now delete the product using a prepared statement
// The WHERE id = ? ensures only this specific product is deleted
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Deletion was successful — redirect with a success message
    header("Location: manage_products.php?deleted=1");
} else {
    // Something went wrong — redirect with an error indicator
    header("Location: manage_products.php?error=delete_failed");
}
exit();
?>
