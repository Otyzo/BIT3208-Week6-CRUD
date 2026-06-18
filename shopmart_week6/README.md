# ShopMart – Week 6: Database Integration & CRUD Operations
**BIT3208 Advanced Web Design and Development | **

---

## 📁 File Structure

```
shopmart_week6/
├── config.php                  # Database connection
├── products.php                # Public product listing (READ)
├── setup.sql                   # Database + table creation script
├── README.md
└── admin/
    ├── manage_products.php     # View all products + Edit/Delete links
    ├── add_product.php         # Add new product form (CREATE)
    ├── edit_product.php        # Edit existing product (UPDATE)
    └── delete_product.php      # Delete handler — POST only (DELETE)
```

---

## ⚙️ Setup Instructions

### 1. Requirements
- XAMPP (Apache + MySQL + PHP 8)
- Browser (Chrome / Firefox)

### 2. Database Setup
1. Open **phpMyAdmin** → `http://localhost/phpmyadmin`
2. Click **SQL** tab
3. Paste the contents of `setup.sql` and click **Go**
4. This creates the `shopmart` database, `products` table, and 5 sample products

### 3. File Placement
Copy the `shopmart_week6` folder to your XAMPP `htdocs` directory:
```
C:\xampp\htdocs\shopmart_week6\
```

### 4. Run the Application
| Page | URL |
|------|-----|
| Public product listing | `http://localhost/shopmart_week6/products.php` |
| Admin – manage products | `http://localhost/shopmart_week6/admin/manage_products.php` |
| Admin – add product | `http://localhost/shopmart_week6/admin/add_product.php` |

---

## 🔐 Security Features
- All queries use **MySQLi prepared statements** (`prepare()` + `bind_param()`) — SQL injection proof
- All output uses **`htmlspecialchars()`** — XSS safe
- **DELETE** only accepted via POST — prevents accidental deletion via URL
- Input validated with `intval()`, `floatval()`, `empty()` checks

---

## 📚 CRUD Summary
| Operation | File | SQL |
|-----------|------|-----|
| **Create** | admin/add_product.php | INSERT INTO products |
| **Read** | products.php, admin/manage_products.php | SELECT * FROM products |
| **Update** | admin/edit_product.php | UPDATE products SET ... WHERE id=? |
| **Delete** | admin/delete_product.php | DELETE FROM products WHERE id=? |
