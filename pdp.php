<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gr5 Ecommarce</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Notch -->
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

    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <a href="explore.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <a href="index.php" class="logo">Gr5<span>Ecommarce</span></a>
            </div>
            
            <div class="header-right">
                <?php if (isset($_SESSION['username'])): ?>
                    <button class="icon-btn" id="accountBtn">
                        <a href="my.php"><i class="far fa-user"></i></a>
                    </button>
                <?php else: ?>
                    <!-- Not logged in: show login button -->
                    <button class="icon-btn" id="loginBtn">
                        <a href="loginReg.php"><i class="fas fa-sign-in-alt"></i></a>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <?php
        require_once 'db.php';

        $demoSql = "SELECT value FROM app_settings WHERE setting_name = 'Price Demo Mode' LIMIT 1";
        $demoResult = mysqli_query($conn, $demoSql);
        $demoRow = mysqli_fetch_assoc($demoResult);
        $demoEnabled = (int)$demoRow['value'];

        if (isset($_POST['buy_now'])) {
            $productId = (int)$_POST['product_id'];
            $customerId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

            if ($demoEnabled) {
                $sql = "SELECT id, title, price_cents, currency FROM product WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $productId);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($product = mysqli_fetch_assoc($result)) {
                    $orderNumber = "ORD-" . time();
                    $subtotal    = (int)$product['price_cents'];
                    $currency    = $product['currency'];

                    // insert order
                    $orderSql = "INSERT INTO orders (order_number, customer_id, status, subtotal_cents, total_cents, placed_at)
                                 VALUES (?, ?, 'pending', ?, ?, NOW())";
                    $orderStmt = mysqli_prepare($conn, $orderSql);
                    mysqli_stmt_bind_param($orderStmt, "siii", $orderNumber, $customerId, $subtotal, $subtotal);
                    mysqli_stmt_execute($orderStmt);
                    $orderId = mysqli_insert_id($conn);

                    // insert order item
                    $itemSql = "INSERT INTO order_item (order_id, product_id, product_title, quantity, unit_price_cents, currency, total_cents)
                                VALUES (?, ?, ?, 1, ?, ?, ?)";
                    $itemStmt = mysqli_prepare($conn, $itemSql);
                    mysqli_stmt_bind_param(
                        $itemStmt,
                        "iisisi",
                        $orderId,
                        $product['id'],
                        $product['title'],
                        $product['price_cents'],
                        $currency,
                        $subtotal
                    );
                    mysqli_stmt_execute($itemStmt);

                    header("Location: /my.php");
                    exit;
                }
            } else {
                header("Location: /payment.php");
                exit;
            }
        }







        // Get product ID from query string, e.g. product.php?id=1
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 7;

        $sql = "SELECT id, title, description, brand, price_cents, currency, stock, img_location, rating 
                FROM product 
                WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $title       = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
            $description = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
            $brand       = htmlspecialchars($row['brand'], ENT_QUOTES, 'UTF-8');
            $img         = htmlspecialchars($row['img_location'], ENT_QUOTES, 'UTF-8');
            $currency    = htmlspecialchars($row['currency'], ENT_QUOTES, 'UTF-8');

            // keep raw numeric value separate
            $priceRaw = (float)$row['price_cents'];
            $price    = number_format($priceRaw, 2);        // formatted string for display
            $original = number_format($priceRaw * 1.2, 2);  // original/discounted price
            $discount = number_format($priceRaw * 0.2, 2);  // amount saved
            $rating   = number_format((float)$row['rating'], 1);
            $idAttr   = (int)$row['id'];
        ?>
        <!-- Product Detail Section -->
        <section class="product-detail">
            <div class="container">
                <div class="breadcrumb-nav">
                    <a href="index.php">Home</a>
                    <span>/</span>
                    <a href="#"><?php echo $brand; ?></a>
                    <span>/</span>
                    <span class="current"><?php echo $title; ?></span>
                </div>

                <div class="pdp-layout">
                    <!-- Product Gallery -->
                    <div class="pdp-gallery">
                        <div class="gallery-main">
                            <div class="main-image">
                                <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" id="mainImage">
                                <button class="zoom-btn" id="zoomBtn">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <div class="image-badge">New Arrival</div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="pdp-info">
                        <div class="product-header">
                            <div class="product-breadcrumb"><?php echo $brand; ?> / Collection</div>
                            <h1 class="product-title"><?php echo $title; ?></h1>
                            <div class="product-rating">
                                <div class="stars">
                                    <?php
                                    $fullStars = floor($rating);
                                    $halfStar  = ($rating - $fullStars >= 0.5);
                                    for ($i=0; $i<$fullStars; $i++) {
                                        echo '<i class="fas fa-star"></i>';
                                    }
                                    if ($halfStar) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    }
                                    ?>
                                </div>
                                <span class="rating-value"><?php echo $rating; ?></span>
                                <span class="review-count">(<?php echo 50 * $rating; ?> reviews)</span>
                                <a href="#reviews" class="see-reviews">See all reviews</a>
                            </div>
                        </div>

                        <div class="product-pricing">
                            <div class="price-container">
                                <span class="current-price"><?php echo $currency . " " . $price; ?></span>
                                <span class="original-price"><?php echo $currency . " " . $original; ?></span>
                                <span class="discount-badge">Save <?php echo $currency . " " . $discount; ?></span>
                            </div>
                            <div class="price-note">Including VAT. Free shipping worldwide.</div>
                        </div>

                        <div class="product-actions">
                            <div class="quantity-selector">
                                <label>Quantity</label>
                                <div class="quantity-controls">
                                    <button class="qty-btn minus"><i class="fas fa-minus"></i></button>
                                    <input type="number" value="1" min="1" max="<?php echo (int)$row['stock']; ?>" class="qty-input">
                                    <button class="qty-btn plus"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>

                            <div class="action-buttons">
                                <form method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $idAttr; ?>">
                                    <button type="submit" name="buy_now" class="btn btn-primary btn-large add-to-cart" data-product-id="<?php echo $idAttr; ?>">
                                        <i class="fas fa-shopping-bag"></i>
                                        Buy Now - <?php echo $currency . " " . $price; ?>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>





            <!-- Product Details Tabs -->
            <div class="product-tabs">
                <div class="tab-nav">
                    <button class="tab-btn active" data-tab="description">Description</button>
                    <button class="tab-btn" data-tab="shipping">Shipping & Returns</button>
                    
                </div>

                <div class="tab-content">
                    <!-- Description Tab -->
                    <div class="tab-pane active" id="description">
                        <div class="description-content">
                            <h3><?php echo $title; ?></h3>
                            <p><?php echo $description; ?></p>
                            
                            

                            
                        </div>
                    </div>

                   

                    <!-- Shipping Tab -->
                    <div class="tab-pane" id="shipping">
                        <div class="shipping-info">
                            <h3>Shipping Information</h3>
                            <div class="shipping-options">
                                <div class="shipping-option">
                                    <i class="fas fa-shipping-fast"></i>
                                    <div>
                                        <strong>Express Shipping</strong>
                                        <span>1-2 business days - $25</span>
                                    </div>
                                </div>
                                <div class="shipping-option">
                                    <i class="fas fa-truck"></i>
                                    <div>
                                        <strong>Standard Shipping</strong>
                                        <span>3-5 business days - FREE</span>
                                    </div>
                                </div>
                                <div class="shipping-option">
                                    <i class="fas fa-globe"></i>
                                    <div>
                                        <strong>International</strong>
                                        <span>5-10 business days - $45</span>
                                    </div>
                                </div>
                            </div>

                            <h3>Return Policy</h3>
                            <p>We offer a 30-day return policy for all unused items in original packaging. Return shipping is free for customers in the United States.</p>
                            
                            <div class="return-features">
                                <div class="return-feature">
                                    <i class="fas fa-undo"></i>
                                    <span>30-Day Returns</span>
                                </div>
                                <div class="return-feature">
                                    <i class="fas fa-shipping-fast"></i>
                                    <span>Free Returns</span>
                                </div>
                                <div class="return-feature">
                                    <i class="fas fa-headset"></i>
                                    <span>Dedicated Support</span>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </div>

           
           
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div class="lightbox" id="lightbox">
        <div class="lightbox-content">
            <button class="lightbox-close" id="lightboxClose">
                <i class="fas fa-times"></i>
            </button>
            <div class="lightbox-image">
                <img src="<?php echo $img; ?>" alt="" id="lightboxImg">
            </div>
        </div>
    </div>

  
    <?php
        } else {
            echo "<p>Product not found.</p>";
        }
        
    ?>
    <script src="assets/js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializePDP();
        });

        function initializePDP() {
            // Image Gallery
  
            const mainImage = document.getElementById('mainImage');
            const zoomBtn = document.getElementById('zoomBtn');
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightboxImg');
            const lightboxClose = document.getElementById('lightboxClose');

           
           
            // Zoom functionality
            zoomBtn.addEventListener('click', function() {
                lightbox.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            lightboxClose.addEventListener('click', function() {
                lightbox.style.display = 'none';
                document.body.style.overflow = '';
            });

            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    lightbox.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });

      




            // Quantity Selector
            const minusBtn = document.querySelector('.qty-btn.minus');
            const plusBtn = document.querySelector('.qty-btn.plus');
            const qtyInput = document.querySelector('.qty-input');

            minusBtn.addEventListener('click', function() {
                let currentVal = parseInt(qtyInput.value);
                if (currentVal > 1) {
                    qtyInput.value = currentVal - 1;
                    updatebutton();
                }
            });

            plusBtn.addEventListener('click', function() {
                let currentVal = parseInt(qtyInput.value);
                if (currentVal < 10) {
                    qtyInput.value = currentVal + 1;
                    updatebutton();
                }
            });

            qtyInput.addEventListener('change', function() {
                let val = parseInt(this.value);
                if (val < 1) this.value = 1;
                if (val > 10) this.value = 10;
                updatebutton();
            });

            // Tab Navigation
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update active tab button
                    tabBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show corresponding tab pane
                    tabPanes.forEach(pane => {
                        pane.classList.remove('active');
                        if (pane.id === targetTab) {
                            pane.classList.add('active');
                        }
                    });
                });
            });

           

           
            
            
        }

        
        function updatebutton() {
            const quantity = parseInt(document.querySelector('.qty-input').value);
            const price = <?php echo $priceRaw ?>;
            const total = (price * quantity).toLocaleString();
            
            const addToCartBtn = document.querySelector('.add-to-cart');
            addToCartBtn.innerHTML = `<i class="fas fa-shopping-bag"></i> Buy Now - $${total}.00`;
        }

      
    </script>
    <?php mysqli_close($conn);?>
</body>
</html>