<header>    
<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</header>
<?php
require_once 'db.php';

$sql = "SELECT id, title, description, brand, price_cents, currency, stock, img_location, rating 
        FROM product 
        WHERE rating >= 1
        ORDER BY rating DESC ";
$result = mysqli_query($conn, $sql);
?>
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
       
                
                <?php if (isset($_SESSION['username'])): ?>
                    <button class="icon-btn" id="accountBtn">
                        <a href="my.php"><i class="far fa-user"></i></a>
                    </button>
                <?php else: ?>
                    <button class="icon-btn" id="loginBtn">
                        <a href="loginReg.php"><i class="fas fa-sign-in-alt"></i></a>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav" id="mobileNav">
        <a href="#" class="mobile-nav-link active">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="search.php?q=watch" class="mobile-nav-link">
            <i class="fas fa-search"></i>
            <span>Search</span>
        </a>

        </a>
        <a href="#" class="mobile-nav-link">
            <i class="far fa-user"></i>
            <span>Account</span>
        </a>
    </nav>

<section class="best-sellers">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Explore Products</h2>
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

                        // keep raw numeric value separate
                        $priceRaw = (float)$row['price_cents'];   
                        $price    = number_format($priceRaw, 2);        // formatted for display
                        $original = number_format($priceRaw * 1.2, 2);  // discount/original price calculation
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
                                <span class="original-price"><?php echo $currency . " " . $original; ?></span>
                            </div>
                            <div class="product-rating">
                                ⭐ <?php echo $rating; ?>
                            </div>
                        </div>
                        <div class="product-actions">
                            <a href="pdp.php?id=<?php echo $id ?>">
                                <button class="quick-view-btn">Quick View</button>
                            </a>
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


<script src="assets/js/app.js"></script>