<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - G5 E-commerce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      .btn-update {
        margin-top: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px; /* space between icon and text */
}

.btn-update:hover {
    background-color: #45a049;
}

.btn-update i {
    font-size: 14px;
}

.admin-form .form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 16px;
}

.input-with-icon {
    position: relative;
}

.input-with-icon i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
}

.input-with-icon input,
.input-with-icon textarea {
    width: 100%;
    background: var(--secondary);
    border: 1px solid var(--glass-border);
    border-radius: 12px;
    padding: 14px 16px 14px 44px;
    color: var(--text);
    transition: var(--transition);
}

.input-with-icon textarea {
    min-height: 100px;
    resize: vertical;
}

.input-with-icon.full {
    grid-column: span 2;
}


.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th,
.admin-table td {
    padding: 14px;
    text-align: left;
    color: var(--text);
}

.admin-table th {
    color: var(--accent);
    font-size: 13px;
}

.admin-table tr {
    border-bottom: 1px solid var(--glass-border);
}

.icon-btn.danger {
    color: #ff4757;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .dashboard-layout {
        grid-template-columns: 1fr;
    }

    .dashboard-sidebar {
        position: relative;
        top: 0;
    }

    .input-with-icon.full {
        grid-column: span 1;
    }
}

    </style>
</head>

<body class="dashboard-page">

<?php

require '../db.php'; 



if (!isset($_SESSION['admin_id'])) {
    header("Location: /admin/staff.php");
    exit;
}


if ($_SESSION['admin_role'] !== 'admin') {
    header("Location: /admin/staff.php");
    exit;
}



$settingQuery = "SELECT * FROM app_settings WHERE setting_name = 'Price Demo Mode' LIMIT 1";
$settingResult = mysqli_query($conn, $settingQuery);
$settingRow = mysqli_fetch_assoc($settingResult);


// Handle toggle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_demo'])) {
    $newValue = ($_POST['toggle_demo'] == 1) ? 0 : 1; // flip ON/OFF
    $updateQuery = "UPDATE app_settings SET value = $newValue WHERE setting_name = 'Price Demo Mode'";
    mysqli_query($conn, $updateQuery);
    header("Location: " . $_SERVER['PHP_SELF']); // refresh page
    exit;
}











if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_id'], $_POST['newpasswd'])) {
    $adminIdentifier = (int) $_POST['admin_id'];
    $newPassword     = $_POST['newpasswd'];

    
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $pwUpdateSql  = "UPDATE admin SET password_hash = ? WHERE id = ?";
    $pwUpdateStmt = mysqli_prepare($conn, $pwUpdateSql);
    mysqli_stmt_bind_param($pwUpdateStmt, "si", $hashedPassword, $adminIdentifier);

    if (mysqli_stmt_execute($pwUpdateStmt)) {
        echo "<script>'Password updated successfully for admin ')</script>";
    } else {
        echo "<script>'Error Updating admin passwd')</script>";
    }

    mysqli_stmt_close($pwUpdateStmt);
}


$adminFetchSql    = "SELECT id, name, email, role, is_active FROM admin";
$adminFetchResult = mysqli_query($conn, $adminFetchSql);

if (!$adminFetchResult) {
    die("Query failed: " . mysqli_error($conn));
}






if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['newpasswd'])) {
    $uid       = (int) $_POST['user_id'];
    $newPass   = $_POST['newpasswd'];

 
    $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);

    $updateQuery = "UPDATE customer SET password = ? WHERE id = ?";
    $updateStmt  = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "si", $hashedPass, $uid);

    if (mysqli_stmt_execute($updateStmt)) {
        echo "<script>'Password updated successfully for user ID {$uid}')</script>";
    } else {
        echo "<script>'Error Updating passwd')</script>";
    }

    mysqli_stmt_close($updateStmt);
}

// Fetch customers
$selectQuery = "SELECT id, username, first_name FROM customer";
$selectResult = mysqli_query($conn, $selectQuery);

if (!$selectResult) {
    die("Query failed: " . mysqli_error($conn));
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];
    $delSql   = "DELETE FROM product WHERE id = ?";
    $delStmt  = mysqli_prepare($conn, $delSql);
    mysqli_stmt_bind_param($delStmt, "i", $deleteId);
    mysqli_stmt_execute($delStmt);
    mysqli_stmt_close($delStmt);

    echo "Product $deleteId deleted";
    exit; 
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title        = $_POST['title'];
    $brand        = $_POST['brand'];
    $price_cents  = (int) $_POST['price_cents'];
    $stock        = (int) $_POST['stock'];
    $img_location = $_POST['img_location'];
    $description  = $_POST['description'];

    $rating = 4.7;

    $sql = "INSERT INTO product 
            (title, description, brand, price_cents, stock, img_location, rating, currency) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'ETB')";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssiisd",
        $title,
        $description,
        $brand,
        $price_cents,
        $stock,
        $img_location,
        $rating
    );

    mysqli_stmt_execute($stmt);


    // if (mysqli_stmt_execute($stmt)) {
    //     echo "";
       
    // } else {
    //     echo "";
        
    // };
    






}
    $queryProducts = "SELECT id, title, price_cents, currency, stock 
                  FROM product 
                  ORDER BY created_at DESC";

    $productsRes = mysqli_query($conn, $queryProducts);



?>





<section class="dashboard">
    <div class="container">
        <div class="dashboard-layout">

          
            <aside class="dashboard-sidebar">

                <div class="user-profile-card">
                    <div class="user-avatar">
                        <img src="https://th.bing.com/th/id/OIP.Zqlr7UPiDa4GxRgwgAoqhgHaGP?w=192&h=180&c=7&r=0&o=5&cb=ucfimg2&pid=1.7&ucfimg=1">
                    </div>
                    <div class="user-info">
                        <h3>Admin Panel</h3>
                        <p><?php echo $_SESSION['mail'] ?></p>
                        <div class="user-tier">
                            <i class="fas fa-shield-halved"></i>
                            Administrator
                        </div>
                    </div>
                   
                </div>

                <nav class="dashboard-nav">
                    <a class="nav-item active" data-section="overview">
                        <i class="fas fa-box"></i> OverView
                    </a>
                    <!-- <a class="nav-item" data-section="users">
                        <i class="fas fa-users"></i> Users
                    </a> -->
                    <!-- <a class="nav-item">
                        <i class="fas fa-chart-line"></i> Analytics
                    </a> -->

                     <a href="/logout.php">

                            <button class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                Sign Out
                            </button>
                    </a>
                </nav>

            </aside>

            <!-- CONTENT -->
            <main class="dashboard-content content-section active">

                <div class="section-header">
                    <h1>Manage Products</h1>
                    <p>Add and manage products in your store</p>
                </div>

                <!-- ADD PRODUCT FORM -->
                <div class="recent-orders">
                    <div class="card-header">
                        <h3>Add Product</h3>
                    </div>

                    <form class="admin-form" method="POST">
                      <div class="form-grid">

                        <div class="input-with-icon">
                          <i class="fas fa-tag"></i>
                          <input type="text" name="title" placeholder="Product Title" required>
                        </div>

                        <div class="input-with-icon">
                          <i class="fas fa-building"></i>
                          <input type="text" name="brand" placeholder="Brand">
                        </div>

                        <div class="input-with-icon">
                          <i class="fas fa-dollar-sign"></i>
                          <input type="number" name="price_cents" min="0" placeholder="Price (cents)" required>
                        </div>

                        <div class="input-with-icon">
                          <i class="fas fa-boxes-stacked"></i>
                          <input type="number" name="stock" placeholder="Stock" required>
                        </div>

                        <div class="input-with-icon full">
                          <i class="fas fa-image"></i>
                          <input type="text" name="img_location" placeholder="Image URL" required>
                        </div>

                        <div class="input-with-icon full">
                          <i class="fas fa-align-left"></i>
                          <textarea name="description" placeholder="Description"></textarea>
                        </div>

                        <button class="btn btn-primary btn-full" type="submit">
                          <i class="fas fa-plus"></i> Add Product
                        </button>

                      </div>
                    </form>
                </div>

                <!-- PRODUCT TABLE -->
                <div class="recent-orders" style="margin-top:30px">
    <div class="card-header">
        <h3>Products</h3>
    </div>

    <table class="admin-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        </thead>
            <tbody>
            <?php if ($productsRes && mysqli_num_rows($productsRes) > 0): ?>
                <?php while ($productRow = mysqli_fetch_assoc($productsRes)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($productRow['id']); ?></td>
                        <td><?php echo htmlspecialchars($productRow['title']); ?></td>
                        <td>
                            <?php 
                                echo htmlspecialchars($productRow['currency']) . ' ' . number_format($productRow['price_cents'], 2);
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($productRow['stock']); ?></td>
                        <td>
                            <button class="icon-btn danger" onclick="deleteProduct(<?php echo $productRow['id']; ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No products found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <br><br>
        <div class="card-header">
            <h3><i class="fas fa-user-shield"></i> Users Info</h3>
        </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Change password</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cust = mysqli_fetch_assoc($selectResult)) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cust['id']); ?></td>
                            <td><?php echo htmlspecialchars($cust['username']); ?></td>
                            <td><?php echo htmlspecialchars($cust['first_name']); ?></td>
                            <td>
                                <form method="post">
                                    <div class="input-with-icon">
                                        <i class="fas fa-lock"></i>
                                        <input type="password" 
                                               name="newpasswd" 
                                               placeholder="New password" 
                                               required>
                                    </div>
                                    <input type="hidden" name="user_id" value="<?php echo $cust['id']; ?>">
                                    <button type="submit" class="btn-update"><i class="fas fa-sync-alt"></i> Update</button>

                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <br><br>
        <div class="card-header">
            <div class="user-tier">
                <i class="fas fa-shield-halved"></i> Administrator Info
            </div>
            
        </div>

        <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Active</th>
                <th>Change Password</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($adminRow = mysqli_fetch_assoc($adminFetchResult)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($adminRow['id']); ?></td>
                    <td><?php echo htmlspecialchars($adminRow['name']); ?></td>
                    <td><?php echo htmlspecialchars($adminRow['email']); ?></td>
                    <td><?php echo htmlspecialchars($adminRow['role']); ?></td>
                    <td>
                        <?php if ($adminRow['is_active']) : ?>
                            <i class="fas fa-check-circle" style="color:green;"></i> yes
                        <?php else : ?>
                            <i class="fas fa-times-circle" style="color:red;"></i> No
                        <?php endif; ?>
                    </td>


                    <td>
                        <form method="post">
                            <div class="input-with-icon">
                                <i class="fas fa-lock"></i>
                                <input type="password" 
                                       name="newpasswd" 
                                       placeholder="New password" 
                                       required>
                            </div>
                            <input type="hidden" name="admin_id" value="<?php echo $adminRow['id']; ?>">
                            <button type="submit" class="btn-update">
                                <i class="fas fa-sync-alt"></i> Update
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br><br>
    <div class="card-header">
        <div class="settings-tier">
            <i class="fas fa-sliders-h"></i> Application Settings
        </div>
    </div>

    <table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Setting Name</th>
            <th>Description</th>
            <th>Toggle</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo htmlspecialchars($settingRow['id']); ?></td>
            <td><?php echo htmlspecialchars($settingRow['setting_name']); ?></td>
            <td><?php echo htmlspecialchars($settingRow['description']); ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="toggle_demo" value="<?php echo $settingRow['value']; ?>">
                    <?php if ($settingRow['value'] == 1): ?>
                        <button type="submit" class="btn-toggle" style="background:green;color:white;border: 2px solid green;border-radius: 12px;width: 86%">
                            <i class="fas fa-toggle-on"></i> ON
                        </button>
                    <?php else: ?>
                        <button type="submit" class="btn-toggle" style="background:red;color:white; border: 2px solid red;border-radius: 12px;width: 86%">
                            <i class="fas fa-toggle-off"></i> OFF
                        </button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
    </tbody>
</table>




    </div>

            </main>
        </div>
    </div>
        

</section>

<script>

function deleteProduct(id) {
    if (!confirm("Delete product " + id + "?")) return;

        fetch("admin.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "delete_id=" + encodeURIComponent(id)
        })
        .then(response => response.text())
        .then(data => {
        
            console.log("Deleted:", data);
            
            location.reload();
        })
        .catch(err => console.error("Error deleting:", err));
    }


//     document.querySelectorAll(".nav-item").forEach(item=>{
//     item.addEventListener("click",e=>{
//         e.preventDefault();

//         document.querySelectorAll(".nav-item").forEach(n=>n.classList.remove("active"));
//         document.querySelectorAll(".content-section").forEach(s=>s.classList.remove("active"));

//         item.classList.add("active");
//         document.getElementById(item.dataset.section+"Section").classList.add("active");
//     });
// });

</script>

<?php
mysqli_stmt_close($stmt);
?>
</body>
</html>
