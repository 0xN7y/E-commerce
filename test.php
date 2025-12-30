<header>    
<link rel="stylesheet" type="text/css" href="styles.css">
</header>

<?php

require_once 'db.php';

$sql = "SELECT id, title, description, brand, price_cents, currency, stock, img_location, rating, created_at, updated_at 
        FROM product";
$result = mysqli_query($conn, $sql);
?>

<section class="featured-products">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Curated Selection</h2>
            <p class="section-subtitle">Handpicked luxury items for the discerning customer</p>
        </div>
        
        <div class="products-carousel" id="productsCarousel">
            <div class="carousel-container">
                <div class="carousel-track" id="carouselTrack">
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <?php
                                // Sanitize all output
                                $id          = (int)$row['id'];
                                $title       = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                                $brand       = htmlspecialchars($row['brand'], ENT_QUOTES, 'UTF-8');
                                $img         = htmlspecialchars($row['img_location'], ENT_QUOTES, 'UTF-8');
                                $currency    = htmlspecialchars($row['currency'], ENT_QUOTES, 'UTF-8');
                                $price       = number_format($row['price_cents']/100, 2);
                            ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
                                    <?php if ($row['stock'] > 50): ?>
                                        <div class="product-badge">Bestseller</div>
                                    <?php elseif ($row['stock'] > 0 && $row['stock'] <= 10): ?>
                                        <div class="product-badge">Limited</div>
                                    <?php endif; ?>
                                    <button class="product-wishlist">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="product-info">
                                    <div class="product-category"><?php echo $brand; ?></div>
                                    <h3 class="product-name"><?php echo $title; ?></h3>
                                    <div class="product-price">
                                        <span class="current-price"><?php echo $currency . " " . $price; ?></span>
                                        <span class="original-price"><?php echo $currency . " " . number_format($price * 1.2, 2); ?></span>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <button class="quick-view-btn">Quick View</button>
                                    <button class="add-to-cart-btn" data-product-id="<?php echo $id; ?>">
                                        <i class="fas fa-shopping-bag"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No products available.</p>
                    <?php endif; ?>
                </div>
            </div>
            <button class="carousel-btn carousel-prev" id="carouselPrev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-btn carousel-next" id="carouselNext">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>


<?php
require_once 'db.php';

// Query top-rated products (example: rating >= 4.5)
$sql = "SELECT id, title, description, brand, price_cents, currency, stock, img_location, rating 
        FROM product 
        WHERE rating >= 4.7 
        ORDER BY rating DESC 
        LIMIT 8";
$result = mysqli_query($conn, $sql);
?>

<section class="best-sellers">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Best Sellers</h2>
            <p class="section-subtitle">Most coveted pieces from our collection</p>
        </div>
        
        <div class="product-grid" id="productGrid">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                        $id       = (int)$row['id'];
                        $title    = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                        $brand    = htmlspecialchars($row['brand'], ENT_QUOTES, 'UTF-8');
                        $img      = htmlspecialchars($row['img_location'], ENT_QUOTES, 'UTF-8');
                        $currency = htmlspecialchars($row['currency'], ENT_QUOTES, 'UTF-8');
                        $price    = number_format($row['price_cents']/100, 2);
                        $rating   = number_format((float)$row['rating'], 1);
                    ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>">
                            <div class="product-badge">Bestseller</div>
                            <button class="product-wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <div class="product-info">
                            <div class="product-category"><?php echo $brand; ?></div>
                            <h3 class="product-name"><?php echo $title; ?></h3>
                            <div class="product-price">
                                <span class="current-price"><?php echo $currency . " " . $price; ?></span>
                                <span class="original-price"><?php echo $currency . " " . number_format($price * 1.2, 2); ?></span>
                            </div>
                            <div class="product-rating">
                                ⭐ <?php echo $rating; ?>
                            </div>
                        </div>
                        <div class="product-actions">
                            <button class="quick-view-btn">Quick View</button>
                            <button class="add-to-cart-btn" data-product-id="<?php echo $id; ?>">
                                <i class="fas fa-shopping-bag"></i>
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No best sellers available.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php mysqli_close($conn); ?>

<?php mysqli_close($conn); ?>