<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-page">
    
    <div class="notch-container">
        <div class="notch">
            <div class="notch-time">12:30</div>
            <div class="notch-icons">
                <a href="https://www.google.com/maps" 
                     class="notch-map-link" 
                     target="_blank" 
                     rel="noopener" 
                     aria-label="Open Google Maps">
                    <i class="fas fa-compass" style="color: white;"></i>
                  </a>
                <div class="notch-time">24/7</div>

            </div>
        </div>
    </div>

    <?php 
      require_once 'db.php';

      if (!isset($_SESSION['username'])) {
            header("Location: loginReg.php");
            exit;
        }

        $username = $_SESSION['username'];


    ?>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <a href="index.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <a href="index.php" class="logo">Gr5 <span>Ecommerce</span></a>
            </div>
            
            <div class="header-right">
               <!--  <button class="icon-btn" id="wishlistBtn">
                    <i class="far fa-heart"></i>
                </button> -->
                <a href="index.php">
                    <button class="icon-btn" id="cartBtn">
                        <i class="fas fa-home"></i>
                        
                    </button>
                </a>
            </div>
        </div>
    </header>

    <!-- Dashboard -->
    <section class="dashboard">
        <div class="container">
            <div class="dashboard-layout">
                <!-- Sidebar -->
                <div class="dashboard-sidebar">
                    <div class="user-profile-card">
                        <div class="user-avatar">
                            <img src="https://as2.ftcdn.net/v2/jpg/05/89/93/27/1000_F_589932782_vQAEAZhHnq1QCGu5ikwrYaQD0Mmurm0N.jpg" alt="<?php echo htmlspecialchars($_SESSION['username']); ?>">
                            <button class="edit-avatar">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <div class="user-info">
                            <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                            <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                            <div class="user-tier">
                                <i class="fas fa-crown"></i>
                                Elite Member
                            </div>
                        </div>
                        <div class="profile-stats">
                            <?php
                                $sql = "SELECT COUNT(*) AS order_count
                                FROM orders o
                                JOIN customer c ON o.customer_id = c.id
                                WHERE c.username = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "s", $username);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);

                        $orderCount = $row['order_count'];

                        ?>

                        <div class="stat">
                            <div class="stat-number"><?php echo $orderCount; ?></div>
                            <div class="stat-label">Orders</div>
                        </div>
                           <!--  <div class="stat">
                                <div class="stat-number">8</div>
                                <div class="stat-label">Wishlist</div>
                            </div> -->                        
                        </div>
                    </div>

                    <nav class="dashboard-nav">
                        <a href="#overview" class="nav-item active" data-section="overview">
                            <i class="fas fa-chart-pie"></i>
                            Overview
                        </a>
                        <a href="#orders" class="nav-item" data-section="orders">
                            <i class="fas fa-shopping-bag"></i>
                            Orders
                            <span class="nav-badge"><?php echo $orderCount; ?></span>
                        </a>
                        
                       <!--  <a href="#addresses" class="nav-item" data-section="addresses">
                            <i class="fas fa-map-marker-alt"></i>
                            Addresses
                        </a> -->
                        <a href="#payment" class="nav-item" data-section="payment">
                            <i class="fas fa-credit-card"></i>
                            Payment Methods
                        </a>

                    <!--     <a href="#profile" class="nav-item" data-section="profile">
                            <i class="fas fa-user"></i>
                            Profile
                        </a> -->
                       <!--  <a href="#preferences" class="nav-item" data-section="preferences">
                            <i class="fas fa-cog"></i>
                            Preferences
                        </a> -->
                    </nav>

                    <div class="sidebar-footer">
                        <a href="/logout.php">

                            <button class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                Sign Out
                            </button>
                        </a>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="dashboard-content">
                    <!-- Overview Section -->
                    <div class="content-section active" id="overviewSection">
                        <div class="section-header">
                            <h1>Dashboard Overview</h1>
                            <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>! Here's your activity summary.</p>
                        </div>

                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-value"><?php echo $orderCount; ?></div>
                                    <div class="stat-label">Active Orders</div>
                                    <div class="stat-trend positive">
                                        <i class="fas fa-arrow-up"></i>
                                        <?php echo $orderCount; ?> Total order from us
                                    </div>
                                </div>
                            </div>
<!-- 
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-value">8</div>
                                    <div class="stat-label">Wishlist Items</div>
                                    <div class="stat-trend positive">
                                        <i class="fas fa-arrow-up"></i>
                                        2 new items
                                    </div>
                                </div>
                            </div -->

                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-value">0</div>
                                    <div class="stat-label"> Future Average Rating</div>
                                    <div class="stat-trend neutral">
                                        <i class="fas fa-minus"></i>
                                        No change
                                    </div>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-value">0000</div>
                                    <div class="stat-label">Loyalty Points Will Appear here in future </div>
                                    <div class="stat-trend positive">
                                        <i class="fas fa-arrow-up"></i>
                                        0 points earned
                                    </div>
                                </div>
                            </div> 
                        </div>

                        <div class="content-grid">
                            <div class="recent-orders">
                                <div class="card-header">
                                    <h3>Recent Orders</h3>
                                    <a href="#orders" class="view-all">View All</a>
                                </div>
                                <div class="orders-list">
                                <?php 
                                    $sql = "SELECT o.id, o.order_number, o.status, o.total_cents, o.placed_at
                                            FROM orders o
                                            JOIN customer c ON o.customer_id = c.id
                                            WHERE c.username = ?";
                                    $stmt = mysqli_prepare($conn, $sql);
                                    mysqli_stmt_bind_param($stmt, "s", $username);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $orderId    = htmlspecialchars($row['order_number']);
                                        $orderDate  = $row['placed_at'] ? date("m/d/Y", strtotime($row['placed_at'])) : '-';
                                        $orderTotal = '$' . number_format($row['total_cents'], 2);
                                        $status     = ucfirst($row['status']);

                                        $badgeStyle = [
                                            'pending'   => 'background:#ffd32a20;color:#ffd32a',
                                            'paid'      => 'background:#2ed57320;color:#2ed573',
                                            'shipped'   => 'background:#1e90ff20;color:#1e90ff',
                                            'cancelled' => 'background:#ff475720;color:#ff4757',
                                        ];
                                        $style = $badgeStyle[strtolower($row['status'])] ?? 'background:#ccc20;color:#666';

                                        echo '
                                        <div class="order-item">
                                            <div class="order-info">
                                                <div class="order-id">'. $orderId .'</div>
                                                <div class="order-date">'. $orderDate .'</div>
                                            </div>
                                            <div class="order-details">
                                                <div class="order-items">';
                                        
                                        // Fetch product titles for this order
                                        $itemSql = "SELECT product_title, quantity FROM order_item WHERE order_id = ?";
                                        $itemStmt = mysqli_prepare($conn, $itemSql);
                                        mysqli_stmt_bind_param($itemStmt, "i", $row['id']);
                                        mysqli_stmt_execute($itemStmt);
                                        $itemRes = mysqli_stmt_get_result($itemStmt);

                                        $products = [];
                                        while ($itemRow = mysqli_fetch_assoc($itemRes)) {
                                            $products[] = htmlspecialchars($itemRow['product_title']) . 
                                                          ' (x' . intval($itemRow['quantity']) . ')';
                                        }
                                        mysqli_stmt_close($itemStmt);

                                        echo implode('<br>', $products) . '</div>
                                                <div class="order-total">'. $orderTotal .'</div>
                                            </div>
                                            <div class="order-status">
                                                <span class="status-badge" style="'. $style .'">'. $status .'</span>
                                            </div>
                                            <div class="order-actions">
                                                
                                                <!-- <button class="btn btn-outline btn-sm">View Details</button> -->
                                                
                                                <button class="btn btn-outline btn-sm">Track</button>
                                            </div>
                                        </div>';
                                    }
                                    ?>
                                   <!--  
                                    <?php 
                                        $sql = "SELECT o.id, o.order_number, o.status, o.total_cents, o.placed_at
                                        FROM orders o
                                        JOIN customer c ON o.customer_id = c.id
                                        WHERE c.username = ?";
                                    $stmt = mysqli_prepare($conn, $sql);
                                    mysqli_stmt_bind_param($stmt, "s", $username);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $orderId    = htmlspecialchars($row['order_number']);
                                    $orderDate  = $row['placed_at'] ? date("m/d/Y", strtotime($row['placed_at'])) : '-';
                                    $orderTotal = '$' . number_format($row['total_cents'] / 100, 2);
                                    $status     = ucfirst($row['status']);

                                    // Simple badge color logic
                                    $badgeStyle = [
                                        'pending'   => 'background:#ffd32a20;color:#ffd32a',
                                        'paid'      => 'background:#2ed57320;color:#2ed573',
                                        'shipped'   => 'background:#1e90ff20;color:#1e90ff',
                                        'cancelled' => 'background:#ff475720;color:#ff4757',
                                    ];
                                    $style = $badgeStyle[strtolower($row['status'])] ?? 'background:#ccc20;color:#666';

                                    echo '
                                    <div class="order-item">
                                        <div class="order-info">
                                            <div class="order-id">'. $orderId .'</div>
                                            <div class="order-date">'. $orderDate .'</div>
                                        </div>
                                        <div class="order-details">
                                            <div class="order-items">'; 

                                    // Count items for this order
                                    $itemSql = "SELECT COUNT(*) AS cnt FROM order_item WHERE order_id = ?";
                                    $itemStmt = mysqli_prepare($conn, $itemSql);
                                    mysqli_stmt_bind_param($itemStmt, "i", $row['id']);
                                    mysqli_stmt_execute($itemStmt);
                                    $itemRes = mysqli_stmt_get_result($itemStmt);
                                    $itemRow = mysqli_fetch_assoc($itemRes);
                                    mysqli_stmt_close($itemStmt);

                                    echo $itemRow['cnt'] .' items</div>
                                            <div class="order-total">'. $orderTotal .'</div>
                                        </div>
                                        <div class="order-status">
                                            <span class="status-badge" style="'. $style .'">'. $status .'</span>
                                        </div>
                                        <div class="order-actions">
                                            <a href="">
                                                <button class="btn btn-outline btn-sm">View Details</button>
                                            </a>
                                            <button class="btn btn-outline btn-sm">Track</button>
                                        </div>
                                    </div>';
                                }

                                    ?> -->
                                    
                                </div>
                            </div>



<!-- 
                            <div class="quick-actions">
                                <div class="card-header">
                                    <h3>Quick Actions</h3>
                                </div>
                                <div class="actions-grid">
                                    <button class="action-btn">
                                        <i class="fas fa-sync"></i>
                                        Track Order
                                    </button>
                                    <button class="action-btn">
                                        <i class="fas fa-undo"></i>
                                        Start Return
                                    </button>
                                    <button class="action-btn">
                                        <i class="fas fa-gift"></i>
                                        Gift Cards
                                    </button>
                                    <button class="action-btn">
                                        <i class="fas fa-headset"></i>
                                        Contact Support
                                    </button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="content-section" id="paymentSection">
                        <section class="payment-methods">
                                <div class="container">
                                    

                                    <div class="payment-layout">
                                        <!-- Saved Payment Methods -->
                                        <div class="saved-payments">
                                            <div class="section-header">
                                                <h2>Saved Payment Methods</h2>
                                                <p>Manage your payment options for faster checkout</p>
                                            </div>

                                            <div class="payment-cards" id="paymentCards">
                                                <!-- Credit Card 1 -->
                                                <div class="payment-card active" data-card-id="card-1">
                                                    <div class="card-header">
                                                        <div class="card-type">
                                                            <i class="fab fa-cc-visa"></i>
                                                            <span>Visa</span>
                                                        </div>
                                                        <div class="card-actions">
                                                            <button class="action-btn edit-card" data-card-id="card-1">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="action-btn delete-card" data-card-id="card-1">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-details">
                                                        <div class="card-number">•••• •••• •••• ••••</div>
                                                        <div class="card-info">
                                                            <span class="card-holder"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                                            <span class="card-expiry">Expires day/year</span>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="default-badge">
                                                            <i class="fas fa-check-circle"></i>
                                                            Default Payment Method
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Credit Card 2 -->
                                                <div class="payment-card" data-card-id="card-2">
                                                    <div class="card-header">
                                                        <div class="card-type">
                                                            <i class="fab fa-cc-mastercard"></i>
                                                            <span>Mastercard</span>
                                                        </div>
                                                        <div class="card-actions">
                                                            <button class="action-btn edit-card" data-card-id="card-2">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="action-btn delete-card" data-card-id="card-2">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-details">
                                                        <div class="card-number">•••• •••• •••• ••••</div>
                                                        <div class="card-info">
                                                            <span class="card-holder"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                                            <span class="card-expiry">Expires day/year</span>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button class="btn btn-outline btn-sm set-default" data-card-id="card-2">
                                                            Set as Default
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- PayPal -->
                                                <div class="payment-card" data-card-id="paypal-1">
                                                    <div class="card-header">
                                                        <div class="card-type">
                                                            <i class="fab fa-cc-paypal"></i>
                                                            <span>PayPal</span>
                                                        </div>
                                                        <div class="card-actions">
                                                            <button class="action-btn delete-card" data-card-id="paypal-1">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-details">
                                                        <div class="card-number"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                                                        <div class="card-info">
                                                            <span class="card-holder">Connected Account</span>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button class="btn btn-outline btn-sm set-default" data-card-id="paypal-1">
                                                            Set as Default
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Apple Pay -->
                                            <div class="digital-wallet-section">
                                                <h3>Digital Wallets</h3>
                                                <div class="wallet-options">
                                                    <div class="wallet-option">
                                                        <div class="wallet-info">
                                                            <i class="fas fa-wallet"></i>
                                                            <div>
                                                                <h4>Telebirr</h4>
                                                                <p>Fast and secure payments</p>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-outline connect-wallet" data-wallet="apple">
                                                            Connect
                                                        </button>
                                                    </div>
                                                    <div class="wallet-option">
                                                        <div class="wallet-info">
                                                            <i class="fab fa-apple-pay"></i>
                                                            <div>
                                                                <h4>Apple Pay</h4>
                                                                <p>Fast and secure payments with Face ID</p>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-outline connect-wallet" data-wallet="apple">
                                                            Connect
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="wallet-option">
                                                        <div class="wallet-info">
                                                            <i class="fab fa-google-pay"></i>
                                                            <div>
                                                                <h4>Google Pay</h4>
                                                                <p>Quick checkout on Android devices</p>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-outline connect-wallet" data-wallet="google">
                                                            Connect
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="add-payment-section">
                                            <div class="add-payment-card">
                                                <div class="card-header">
                                                    <h3>Add Payment Method</h3>
                                                </div>

                                                <div class="payment-tabs">
                                                    <button class="payment-tab active" data-tab="credit-card">
                                                        <i class="far fa-credit-card"></i>
                                                        Credit Card
                                                    </button>
                                                    <button class="payment-tab" data-tab="paypal">
                                                        <i class="fab fa-paypal"></i>
                                                        PayPal
                                                    </button>
                                                    <button class="payment-tab" data-tab="bank">
                                                        <i class="fas fa-university"></i>
                                                        Bank Transfer
                                                    </button>
                                                </div>

                                                <!-- Credit Card Form -->
                                                <form class="payment-form active" id="creditCardForm">
                                                    <div class="form-group">
                                                        <label for="cardNumber">Card Number</label>
                                                        <div class="input-with-icon">
                                                            <i class="far fa-credit-card"></i>
                                                            <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                                                        </div>
                                                        <div class="card-icons">
                                                            <i class="fab fa-cc-visa"></i>
                                                            <i class="fab fa-cc-mastercard"></i>
                                                            <i class="fab fa-cc-amex"></i>
                                                            <i class="fab fa-cc-discover"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label for="expiryDate">Expiry Date</label>
                                                            <input type="text" id="expiryDate" placeholder="MM/YY" maxlength="5">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cvv">CVV</label>
                                                            <div class="input-with-icon">
                                                                <input type="text" id="cvv" placeholder="123" maxlength="4">
                                                                <button type="button" class="cvv-help" title="3-digit code on back of card">
                                                                    <i class="fas fa-question-circle"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="cardholderName">Cardholder Name</label>
                                                        <input type="text" id="cardholderName" placeholder="As shown on card">
                                                    </div>

                                                    <div class="form-options">
                                                        <label class="checkbox">
                                                            <input type="checkbox" id="setAsDefault" checked>
                                                            <span class="checkmark"></span>
                                                            Set as default payment method
                                                        </label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" id="saveCard" checked>
                                                            <span class="checkmark"></span>
                                                            Save card for future purchases
                                                        </label>
                                                    </div>

                                                    <div class="form-security">
                                                        <div class="security-badge">
                                                            <i class="fas fa-lock"></i>
                                                            <span>Your payment info is secured with 256-bit encryption</span>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary btn-full">
                                                        <i class="fas fa-plus"></i>
                                                        Add Credit Card
                                                    </button>
                                                </form>

                                                <!-- PayPal Form -->
                                                <form class="payment-form" id="paypalForm">
                                                    <div class="paypal-info">
                                                        <div class="paypal-icon">
                                                            <i class="fab fa-paypal"></i>
                                                        </div>
                                                        <h4>Connect PayPal Account</h4>
                                                        <p>Link your PayPal account for fast and secure checkout. You'll be redirected to PayPal to complete the connection.</p>
                                                        
                                                        <div class="paypal-benefits">
                                                            <div class="benefit">
                                                                <i class="fas fa-shield-alt"></i>
                                                                <span>Buyer Protection on all purchases</span>
                                                            </div>
                                                            <div class="benefit">
                                                                <i class="fas fa-bolt"></i>
                                                                <span>Faster checkout experience</span>
                                                            </div>
                                                            <div class="benefit">
                                                                <i class="fas fa-globe"></i>
                                                                <span>Accepted worldwide</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-options">
                                                        <label class="checkbox">
                                                            <input type="checkbox" id="setPaypalDefault">
                                                            <span class="checkmark"></span>
                                                            Set as default payment method
                                                        </label>
                                                    </div>

                                                    <button type="button" class="btn btn-primary btn-full paypal-connect">
                                                        <i class="fab fa-paypal"></i>
                                                        Connect PayPal Account
                                                    </button>
                                                </form>

                                                <!-- Bank Transfer Form -->
                                                <form class="payment-form" id="bankForm">
                                                    <div class="form-group">
                                                        <label for="accountHolder">Account Holder Name</label>
                                                        <input type="text" id="accountHolder" placeholder="Full name as on bank account">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="accountNumber">Account Number</label>
                                                        <input type="text" id="accountNumber" placeholder="Enter account number">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="routingNumber">Routing Number</label>
                                                        <input type="text" id="routingNumber" placeholder="9-digit routing number">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="bankName">Bank Name</label>
                                                        <input type="text" id="bankName" placeholder="Name of your bank">
                                                    </div>

                                                    <div class="form-options">
                                                        <label class="checkbox">
                                                            <input type="checkbox" id="setBankDefault">
                                                            <span class="checkmark"></span>
                                                            Set as default payment method
                                                        </label>
                                                    </div>

                                                    <div class="form-security">
                                                        <div class="security-badge">
                                                            <i class="fas fa-shield-alt"></i>
                                                            <span>Bank details are encrypted and securely stored</span>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary btn-full">
                                                        <i class="fas fa-university"></i>
                                                        Add Bank Account
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- Security Info -->
                                            <div class="security-card">
                                                <div class="security-header">
                                                    <i class="fas fa-shield-alt"></i>
                                                    <h4>Payment Security</h4>
                                                </div>
                                                <div class="security-features">
                                                    <div class="security-feature">
                                                        <i class="fas fa-lock"></i>
                                                        <div>
                                                            <strong>Encryption</strong>
                                                            <span>Bank-level security for all transactions</span>
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="security-feature">
                                                        <i class="fas fa-bell"></i>
                                                        <div>
                                                            <strong>Fraud Monitoring</strong>
                                                            <span>24/7 suspicious activity detection</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        





                        <!-- </div> -->
                    </div>

                    
                    <!-- Orders Section -->
                    <div class="content-section" id="ordersSection">
                        <div class="section-header">
                            <h1>Order History</h1>
                            <p>Manage and track your orders</p>
                        </div>
                        <!-- Orders content will be here -->
                        <div class="orders-list">
                                    <?php 
                                        $sql = "SELECT o.id, o.order_number, o.status, o.total_cents, o.placed_at
                                        FROM orders o
                                        JOIN customer c ON o.customer_id = c.id
                                        WHERE c.username = ?";
                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "s", $username);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $orderId    = htmlspecialchars($row['order_number']);
                                    $orderDate  = $row['placed_at'] ? date("m/d/Y", strtotime($row['placed_at'])) : '-';
                                    $orderTotal = '$' . number_format($row['total_cents'], 2);
                                    $status     = ucfirst($row['status']);

                                    // Simple badge color logic
                                    $badgeStyle = [
                                        'pending'   => 'background:#ffd32a20;color:#ffd32a',
                                        'paid'      => 'background:#2ed57320;color:#2ed573',
                                        'shipped'   => 'background:#1e90ff20;color:#1e90ff',
                                        'cancelled' => 'background:#ff475720;color:#ff4757',
                                    ];
                                    $style = $badgeStyle[strtolower($row['status'])] ?? 'background:#ccc20;color:#666';

                                    echo '
                                    <div class="order-item">
                                        <div class="order-info">
                                            <div class="order-id">'. $orderId .'</div>
                                            <div class="order-date">'. $orderDate .'</div>
                                        </div>
                                        <div class="order-details">
                                            <div class="order-items">'; 

                                    // Count items for this order
                                    $itemSql = "SELECT COUNT(*) AS cnt FROM order_item WHERE order_id = ?";
                                    $itemStmt = mysqli_prepare($conn, $itemSql);
                                    mysqli_stmt_bind_param($itemStmt, "i", $row['id']);
                                    mysqli_stmt_execute($itemStmt);
                                    $itemRes = mysqli_stmt_get_result($itemStmt);
                                    $itemRow = mysqli_fetch_assoc($itemRes);
                                    mysqli_stmt_close($itemStmt);

                                    echo $itemRow['cnt'] .' items</div>
                                            <div class="order-total">'. $orderTotal .'</div>
                                        </div>
                                        <div class="order-status">
                                            <span class="status-badge" style="'. $style .'">'. $status .'</span>
                                        </div>
                                        <div class="order-actions">
                                          
                                            <button class="btn btn-outline btn-sm"  >Track</button>
                                        </div>
                                    </div>';
                                }

                                    ?>
                                  
                                </div>
                    </div>

                 
                </div>
            </div>
        </div>
    </section>
    <?php
        mysqli_stmt_close($stmt);

    ?>
    <script src="assets/js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();
            initializePaymentMethods();
        });


        function initializePaymentMethods() {
            // Payment Method Tabs
            const paymentTabs = document.querySelectorAll('.payment-tab');
            const paymentForms = document.querySelectorAll('.payment-form');

            paymentTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update active tab
                    paymentTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show corresponding form
                    paymentForms.forEach(form => {
                        form.classList.remove('active');
                        if (form.id === targetTab + 'Form') {
                            form.classList.add('active');
                        }
                    });
                });
            });

            // Card Number Formatting
            const cardNumberInput = document.getElementById('cardNumber');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    let matches = value.match(/\d{4,16}/g);
                    let match = matches && matches[0] || '';
                    let parts = [];
                    
                    for (let i = 0; i < match.length; i += 4) {
                        parts.push(match.substring(i, i + 4));
                    }
                    
                    if (parts.length) {
                        e.target.value = parts.join(' ');
                    } else {
                        e.target.value = value;
                    }
                });
            }

            // Expiry Date Formatting
            const expiryInput = document.getElementById('expiryDate');
            if (expiryInput) {
                expiryInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }

            // Set Default Payment Method
            const setDefaultBtns = document.querySelectorAll('.set-default');
            setDefaultBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const cardId = this.getAttribute('data-card-id');
                    setDefaultPaymentMethod(cardId);
                });
            });

            // Delete Payment Method
            const deleteBtns = document.querySelectorAll('.delete-card');
            const deleteModal = document.getElementById('deleteModal');
            const cancelDelete = document.getElementById('cancelDelete');
            const confirmDelete = document.getElementById('confirmDelete');
            const deleteModalClose = document.getElementById('deleteModalClose');
            let currentCardToDelete = null;

            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const cardId = this.getAttribute('data-card-id');
                    currentCardToDelete = cardId;
                    showDeleteConfirmation(cardId);
                });
            });

            cancelDelete.addEventListener('click', closeDeleteModal);
            deleteModalClose.addEventListener('click', closeDeleteModal);
            confirmDelete.addEventListener('click', handleDelete);

            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    closeDeleteModal();
                }
            });

            // Edit Payment Method
            const editBtns = document.querySelectorAll('.edit-card');
            const editModal = document.getElementById('editModal');
            const editModalClose = document.getElementById('editModalClose');

            editBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const cardId = this.getAttribute('data-card-id');
                    showEditModal(cardId);
                });
            });

            editModalClose.addEventListener('click', function() {
                editModal.style.display = 'none';
                document.body.style.overflow = '';
            });

            editModal.addEventListener('click', function(e) {
                if (e.target === editModal) {
                    editModal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });

            // Connect Digital Wallets
            const connectWalletBtns = document.querySelectorAll('.connect-wallet');
            connectWalletBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const wallet = this.getAttribute('data-wallet');
                    connectDigitalWallet(wallet);
                });
            });

            // Form Submissions
            const creditCardForm = document.getElementById('creditCardForm');
            const bankForm = document.getElementById('bankForm');

            if (creditCardForm) {
                creditCardForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    addCreditCard(this);
                });
            }

            if (bankForm) {
                bankForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    addBankAccount(this);
                });
            }

            // PayPal Connect
            const paypalConnect = document.querySelector('.paypal-connect');
            if (paypalConnect) {
                paypalConnect.addEventListener('click', function() {
                    connectPayPal();
                });
            }

            // CVV Help Tooltip
            const cvvHelp = document.querySelector('.cvv-help');
            if (cvvHelp) {
                cvvHelp.addEventListener('click', function() {
                    showNotification('CVV is the 3-digit code on the back of your card');
                });
            }
        }

        function setDefaultPaymentMethod(cardId) {
            // Remove default from all cards
            const paymentCards = document.querySelectorAll('.payment-card');
            paymentCards.forEach(card => {
                card.classList.remove('active');
                const defaultBadge = card.querySelector('.default-badge');
                const setDefaultBtn = card.querySelector('.set-default');
                
                if (defaultBadge) {
                    defaultBadge.style.display = 'none';
                }
                if (setDefaultBtn) {
                    setDefaultBtn.style.display = 'block';
                }
            });

            // Set new default
            const targetCard = document.querySelector(`[data-card-id="${cardId}"]`);
            if (targetCard) {
                targetCard.classList.add('active');
                const defaultBadge = targetCard.querySelector('.default-badge');
                const setDefaultBtn = targetCard.querySelector('.set-default');
                
                if (defaultBadge) {
                    defaultBadge.style.display = 'flex';
                }
                if (setDefaultBtn) {
                    setDefaultBtn.style.display = 'none';
                }
                
                showNotification('Default payment method updated');
            }
        }

        function showDeleteConfirmation(cardId) {
            const card = document.querySelector(`[data-card-id="${cardId}"]`);
            const cardPreview = document.getElementById('cardPreview');
            
            if (card && cardPreview) {
                const cardType = card.querySelector('.card-type span').textContent;
                const cardNumber = card.querySelector('.card-number').textContent;
                
                cardPreview.innerHTML = `
                    <div class="preview-card">
                        <i class="${card.querySelector('.card-type i').className}"></i>
                        <div>
                            <strong>${cardType}</strong>
                            <span>${cardNumber}</span>
                        </div>
                    </div>
                `;
            }
            
            deleteModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            deleteModal.style.display = 'none';
            document.body.style.overflow = '';
            currentCardToDelete = null;
        }

        function handleDelete() {
            if (currentCardToDelete) {
                const card = document.querySelector(`[data-card-id="${currentCardToDelete}"]`);
                if (card) {
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(-20px)';
                    
                    setTimeout(() => {
                        card.remove();
                        showNotification('Payment method removed');
                        closeDeleteModal();
                    }, 300);
                }
            }
        }

        function showEditModal(cardId) {
            const card = document.querySelector(`[data-card-id="${cardId}"]`);
            const modalBody = document.querySelector('#editModal .modal-body');
            
            if (card && modalBody) {
                const cardNumber = card.querySelector('.card-number').textContent;
                const expiry = card.querySelector('.card-expiry').textContent.replace('Expires ', '');
                
                modalBody.innerHTML = `
                    <form class="edit-card-form">
                        <div class="form-group">
                            <label>Card Number</label>
                            <input type="text" value="${cardNumber}" class="card-number-input" readonly>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input type="text" value="${expiry}" placeholder="MM/YY">
                            </div>
                            <div class="form-group">
                                <label>CVV</label>
                                <input type="text" placeholder="***" maxlength="4">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Cardholder Name</label>
                            <input type="text" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
                        </div>
                        
                        <div class="form-options">
                            <label class="checkbox">
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                                Set as default payment method
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-full">
                            <i class="fas fa-save"></i>
                            Update Card
                        </button>
                    </form>
                `;

                // Add form submission handler
                const editForm = modalBody.querySelector('.edit-card-form');
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    showNotification('Card details updated successfully');
                    editModal.style.display = 'none';
                    document.body.style.overflow = '';
                });
            }
            
            editModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function addCreditCard(form) {
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Simulate API call
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding Card...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                showNotification('Credit card added successfully');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                form.reset();
                
                // In a real app, you would add the new card to the saved payments list
            }, 2000);
        }

        function addBankAccount(form) {
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying Account...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                showNotification('Bank account added successfully');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                form.reset();
            }, 2000);
        }

        function connectDigitalWallet(wallet) {
            let walletName = wallet === 'apple' ? 'Apple Pay' : 'Google Pay';
            
            showNotification(`Connecting ${walletName}...`);
            
            // Simulate wallet connection
            setTimeout(() => {
                showNotification(`${walletName} connected successfully`);
                
                // Update button state
                const connectBtn = document.querySelector(`[data-wallet="${wallet}"]`);
                if (connectBtn) {
                    connectBtn.innerHTML = '<i class="fas fa-check"></i> Connected';
                    connectBtn.classList.remove('btn-outline');
                    connectBtn.classList.add('btn-primary');
                    connectBtn.disabled = true;
                }
            }, 1500);
        }

        function connectPayPal() {
            const connectBtn = document.querySelector('.paypal-connect');
            const originalText = connectBtn.innerHTML;
            
            connectBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Redirecting...';
            connectBtn.disabled = true;
            
            // Simulate PayPal connection flow
            setTimeout(() => {
                showNotification('PayPal account connected successfully');
                connectBtn.innerHTML = '<i class="fab fa-paypal"></i> Connected';
                connectBtn.disabled = true;
                
                // Update form options
                const setDefaultCheckbox = document.getElementById('setPaypalDefault');
                if (setDefaultCheckbox) {
                    setDefaultCheckbox.checked = false;
                    setDefaultCheckbox.disabled = true;
                }
            }, 2000);
        }

        function initializeDashboard() {
            // Navigation
            const navItems = document.querySelectorAll('.nav-item');
            const contentSections = document.querySelectorAll('.content-section');

            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Update active nav item
                    navItems.forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show corresponding section
                    const targetSection = this.getAttribute('data-section');
                    contentSections.forEach(section => {
                        section.classList.remove('active');
                        if (section.id === targetSection + 'Section') {
                            section.classList.add('active');
                        }
                    });
                });
            });

            // Load recent orders
            // loadRecentOrders();
        }

        // function loadRecentOrders() {
        //     const orders = [
        //         {
        //             id: 'LH-7842',
        //             date: '2023-12-15',
        //             items: 2,
        //             total: 1299,
        //             status: 'Delivered',
        //             statusColor: '#2ed573'
        //         },
        //         {
        //             id: 'LH-7791',
        //             date: '2023-12-08',
        //             items: 1,
        //             total: 899,
        //             status: 'Processing',
        //             statusColor: '#ffa502'
        //         },
        //         {
        //             id: 'LH-7654',
        //             date: '2023-11-28',
        //             items: 3,
        //             total: 2450,
        //             status: 'Shipped',
        //             statusColor: '#1e90ff'
        //         }
        //     ];

        //     const ordersList = document.querySelector('.orders-list');
            
        //     orders.forEach(order => {
        //         const orderElement = document.createElement('div');
        //         orderElement.className = 'order-item';
        //         orderElement.innerHTML = `
        //             <div class="order-info">
        //                 <div class="order-id">${order.id}</div>
        //                 <div class="order-date">${new Date(order.date).toLocaleDateString()}</div>
        //             </div>
        //             <div class="order-details">
        //                 <div class="order-items">${order.items} item${order.items > 1 ? 's' : ''}</div>
        //                 <div class="order-total">$${order.total}</div>
        //             </div>
        //             <div class="order-status">
        //                 <span class="status-badge" style="background: ${order.statusColor}20; color: ${order.statusColor}">
        //                     ${order.status}
        //                 </span>
        //             </div>
        //             <div class="order-actions">
        //                 <button class="btn btn-outline btn-sm">View Details</button>
        //                 <button class="btn btn-outline btn-sm">Track</button>
        //             </div>
        //         `;
        //         ordersList.appendChild(orderElement);
        //     });
        // }
    </script>
</body>
</html>
