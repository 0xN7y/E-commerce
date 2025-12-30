<!DOCTYPE html>
<?php




require_once 'db.php';


$sqlFeatured = "
    SELECT id, title, brand, price_cents, currency, stock, img_location
    FROM product
    ORDER BY id DESC
    LIMIT 3
";
$resultFeatured = mysqli_query($conn, $sqlFeatured);

$sqlBest = "
    SELECT id, title, brand, price_cents, currency, stock, img_location, rating
    FROM product
    WHERE rating >= 4.5
    ORDER BY rating DESC
    LIMIT 4;
";
$resultBest = mysqli_query($conn, $sqlBest);



?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gr5 Ecommerce | Premium E-commerce</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
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

    <!-- Header Component -->
    <header class="header" id="header">
        <div class="header-container">
            <div class="header-left">
                <button class="menu-btn" id="menuBtn">
                    <span></span>
                    <span></span>
                </button>
                <a href="#" class="logo">Gr5 <span>Ecommerce</span></a>
            </div>
            
            <nav class="nav">
                <a href="index.php" class="nav-link">Home</a>
                <a href="loginReg.php" class="nav-link">Sgin/up</a>
                <a href="explore.php" class="nav-link">Explore</a>
            </nav>
            
            <div class="header-right">
                <div class="search-container">
                    <form action="search.php" method="GET" id="searchForm">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>

                        <div class="search-bar" id="searchBar">
                            <input 
                                type="text" 
                                name="q"
                                placeholder="Search Gr5 items..."
                                required
                            >

                            <button type="button" class="search-close" id="searchClose">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- <div class="search-container">
                    <button class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="search-bar" id="searchBar">
                        <input type="text" placeholder="Search Gr5 items...">
                        <button class="search-close" id="searchClose">
                            <i class="fas fa-times"></i>
                        </button>
                    </div> -->
                </div>
                <!-- 
                <button class="icon-btn" id="wishlistBtn">
                    <i class="far fa-heart"></i>
                    <span class="badge">2</span>
                </button> -->
                
               <!--  <button class="icon-btn" id="cartBtn">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="badge">3</span>
                </button> -->
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

                <!-- 
                <button class="icon-btn" id="accountBtn">
                   <a href="my.php"> <i class="far fa-user"></i></a>
                </button> -->
            </div>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav" id="mobileNav">
        <a href="index.php" class="mobile-nav-link active">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        
        <a href="explore.php" class="mobile-nav-link">
            <i class="fas fa-shopping-bag"></i>
            <span>Explore</span>
        </a>
        
        <a href="my.php" class="mobile-nav-link">
            <i class="far fa-user"></i>
            <span>Account</span>
        </a>
    </nav>


    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">NEW COLLECTION</div>
                <h1 class="hero-title">ELEVATE YOUR<br><span class="hero-accent">ESSENCE</span></h1>
                <p class="hero-description">Discover our exclusive Gr5 collection crafted with precision and timeless elegance.</p>
                <div class="hero-actions">
                    <a href="/explore.php">
                        <button class="btn btn-primary">Explore</button>
                    </a>
                     <?php if (!isset($_SESSION['username'])): ?>
                        <a href="loginReg.php">
                            <button class="btn btn-secondary">Join</button>
                        </a>
                    <?php else: ?>

                    <?php endif; ?>
                </div>
                <div class="hero-stats">
                    <?php
                        require_once 'db.php';

                        // Count total products
                        $sqlProducts = "SELECT COUNT(*) AS total_products FROM product";
                        $resProducts = mysqli_query($conn, $sqlProducts);
                        $totalProducts = 0;
                        if ($resProducts && $row = mysqli_fetch_assoc($resProducts)) {
                            $totalProducts = (int)$row['total_products'];
                        }

                        // Count distinct brands
                        $sqlBrands = "SELECT COUNT(DISTINCT brand) AS total_brands FROM product";
                        $resBrands = mysqli_query($conn, $sqlBrands);
                        $totalBrands = 0;
                        if ($resBrands && $row = mysqli_fetch_assoc($resBrands)) {
                            $totalBrands = (int)$row['total_brands'];
                        }

                        // Sanitize for output
                        $totalProductsSafe = htmlspecialchars($totalProducts, ENT_QUOTES, 'UTF-8');
                        $totalBrandsSafe   = htmlspecialchars($totalBrands, ENT_QUOTES, 'UTF-8'); 
                        ?>

                        <div class="stats">
                           
                            <div class="stat">
                                <div class="stat-number"><?php echo $totalProductsSafe; ?>+</div>
                                <div class="stat-label">Premium Products</div>
                            </div>
                        </div>

                        <?php mysqli_close($conn); ?>
                    <!-- <div class="stat">
                        <div class="stat-number">200+</div>
                        <div class="stat-label">Premium Brands</div>
                    </div> -->
                    <div class="stat">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Client Satisfaction</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Avillablity</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Gr5 Collection">
                </div>
                <div class="hero-glow"></div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
<!--     <section class="featured-products">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Curated Selection</h2>
                <p class="section-subtitle">Handpicked Gr5 items for the discerning customer</p>
            </div>
            
            <div class="products-carousel" id="productsCarousel">
                <div class="carousel-container">
                    <div class="carousel-track" id="carouselTrack"> -->
                        <!-- Product cards will be loaded here dynamically -->
                  <!--   </div>
                </div>
                <button class="carousel-btn carousel-prev" id="carouselPrev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="carousel-btn carousel-next" id="carouselNext">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>  -->


<section class="featured-products">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Selection For You</h2>
            <p class="section-subtitle">Handpicked Gr5 Ecommarce collation items for the discerning customer</p>
        </div>

        <div class="products-carousel">
            <div class="carousel-track">

                <?php if ($resultFeatured && mysqli_num_rows($resultFeatured) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($resultFeatured)): ?>

                        <?php
                            $id       = (int)$row['id'];
                            $title    = htmlspecialchars($row['title']);
                            $brand    = htmlspecialchars($row['brand']);
                            $img      = htmlspecialchars($row['img_location']);
                            $currency = htmlspecialchars($row['currency']);

                            $priceRaw = $row['price_cents'];
                            $price    = number_format($priceRaw, 2);
                            $original = number_format($priceRaw * 1.2, 2);
                        ?>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="<?= $img ?>" alt="<?= $title ?>">

                                <?php if ($row['stock'] > 50): ?>
                                    <div class="product-badge">Bestseller</div>
                                <?php elseif ($row['stock'] <= 10): ?>
                                    <div class="product-badge">Limited</div>
                                <?php endif; ?>

                                <button class="product-wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>

                            <div class="product-info">
                                <div class="product-category"><?= $brand ?></div>
                                <h3 class="product-name"><?= $title ?></h3>

                                <div class="product-price">
                                    <span class="current-price"><?= $currency . " " . $price ?></span>
                                    <span class="original-price"><?= $currency . " " . $original ?></span>
                                </div>
                            </div>

                            <div class="product-actions">
                                <a href="pdp.php?id=<?= $id ?>">
                                    <button class="quick-view-btn">View</button>
                                </a>

                                <button class="add-to-cart-btn" data-product-id="<?= $id ?>">
                                    <i class="fas fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No featured products available.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>


    <!-- Best Sellers -->

<section class="best-sellers">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Best Sellers</h2>
            <p class="section-subtitle">Most coveted pieces from our collection</p>
        </div>

        <div class="product-grid">

            <?php if ($resultBest && mysqli_num_rows($resultBest) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($resultBest)): ?>

                    <?php
                        $id       = (int)$row['id'];
                        $title    = htmlspecialchars($row['title']);
                        $brand    = htmlspecialchars($row['brand']);
                        $img      = htmlspecialchars($row['img_location']);
                        $currency = htmlspecialchars($row['currency']);

                        $priceRaw = $row['price_cents'];
                        $price    = number_format($priceRaw, 2);
                        $original = number_format($priceRaw * 1.2, 2);
                        $rating   = number_format((float)$row['rating'], 1);
                    ?>

                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?= $img ?>" alt="<?= $title ?>">
                            <div class="product-badge">Bestseller</div>
                        </div>

                        <div class="product-info">
                            <div class="product-category"><?= $brand ?></div>
                            <h3 class="product-name"><?= $title ?></h3>

                            <div class="product-price">
                                <span class="current-price"><?= $currency . " " . $price ?></span>
                                <span class="original-price"><?= $currency . " " . $original ?></span>
                            </div>

                            <div class="product-rating">⭐ <?= $rating ?></div>
                        </div>

                        <div class="product-actions">
                            <a href="pdp.php?id=<?= $id ?>">
                                <button class="quick-view-btn">Quick View</button>
                            </a>

                            <button class="add-to-cart-btn" data-product-id="<?= $id ?>">
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


    <!-- <section class="best-sellers">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Best Sellers</h2>
                <p class="section-subtitle">Most coveted pieces from our collection</p>
            </div>
            <div class="product-grid" id="productGrid"> -->

                <!-- Product grid will be loaded here dynamically -->
            <!-- </div>
        </div>
    </section> -->

    <!-- Editorial Section -->
    <section class="editorial">
        <div class="container">
            <div class="editorial-grid">
                <div class="editorial-content">
                    <h2 class="editorial-title">The Art of Gr5 Ecommarce </h2>
                    <p class="editorial-text">Each piece in our collection tells a story of craftsmanship, heritage, and timeless elegance. We partner with artisans who share our commitment to excellence.</p>
                    <p class="editorial-text">From the finest materials to the meticulous attention to detail, every item is a testament to the pursuit of perfection.</p>
                    <button class="btn btn-outline">Our Story</button>
                </div>
                <div class="editorial-image">
                    <img src="https://images.unsplash.com/photo-1584917865442-de89df76afd3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1035&q=80" alt="Craftsmanship">
                    <div class="image-overlay"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Client Testimonials</h2>
                <p class="section-subtitle">What our discerning clients say</p>
            </div>
            
            <div class="testimonials-slider" id="testimonialsSlider">
                <div class="testimonial active">
                    <div class="testimonial-content">
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"The attention to detail and quality of materials is exceptional. My purchase exceeded all expectations."</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="Sarah Johnson">
                            </div>
                            <div class="author-info">
                                <h4 class="author-name">Sarah Johnson</h4>
                                <p class="author-title">Verified Customer</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial">
                    <div class="testimonial-content">
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Outstanding service and impeccable taste. The personal styling consultation was worth every penny."</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Michael Chen">
                            </div>
                            <div class="author-info">
                                <h4 class="author-name">Michael Chen</h4>
                                <p class="author-title">VIP Client</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial">
                    <div class="testimonial-content">
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-text">"The packaging alone was a Gr5 experience. I've never been more impressed with an online purchase."</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Elena Rodriguez">
                            </div>
                            <div class="author-info">
                                <h4 class="author-name">Elena Rodriguez</h4>
                                <p class="author-title">Loyal Customer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-dots">
                <span class="dot active" data-index="0"></span>
                <span class="dot" data-index="1"></span>
                <span class="dot" data-index="2"></span>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <div class="newsletter-box">
                <div class="newsletter-content">
                    <h2 class="newsletter-title">Join Our Inner Circle</h2>
                    <p class="newsletter-text">Receive exclusive access to new collections, private sales, and styling advice from our experts.</p>
                    <form class="newsletter-form">
                        <div class="input-group">
                            <input type="email" placeholder="Your email address" required>
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </div>
                        <p class="newsletter-note">By subscribing, you agree to our Privacy Policy</p>
                    </form>
                </div>
                <div class="newsletter-visual">
                    <div class="newsletter-glow"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3 class="footer-title">Gr5 <span>Ecommerce</span></h3>
                    <p class="footer-text">Curating the world's finest Gr5 goods for the discerning customer.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-pinterest"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4 class="footer-subtitle">Shop</h4>
                    <ul class="footer-links">
                        <li><a href="#">New Arrivals</a></li>
                        <li><a href="#">Best Sellers</a></li>
                        <li><a href="#">Collections</a></li>
                        <li><a href="#">Sale</a></li>
                        <li><a href="#">Lookbook</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4 class="footer-subtitle">Information</h4>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Care Guide</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4 class="footer-subtitle">Services</h4>
                    <ul class="footer-links">
                        <li><a href="#">Personal Styling</a></li>
                        <li><a href="#">Gift Services</a></li>
                        <li><a href="#">Corporate Gifting</a></li>
                        <li><a href="#">VIP Program</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy;  Gr5 Ecommerce. All rights reserved.</p>
                <div class="payment-methods">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-amex"></i>
                    <i class="fab fa-cc-paypal"></i>
                    <i class="fab fa-apple-pay"></i>
                </div>
            </div>
        </div>
    </footer>

    
    <!-- Notification Toast -->
    <div class="notification-toast" id="notificationToast">
        <div class="toast-content">
            <i class="fas fa-check-circle"></i>
            <span class="toast-message">Done</span>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>
