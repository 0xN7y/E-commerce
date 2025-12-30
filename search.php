<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - Gr5 Ecommarce</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<?php


require_once 'db.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : 'car';


if ($search !== '') {

    $sql = "
        SELECT id, title, brand, price_cents, currency, stock, img_location, rating
        FROM product
        WHERE title LIKE ? OR brand LIKE ?
        ORDER BY rating DESC
        LIMIT 20
    ";

    $stmt = mysqli_prepare($conn, $sql);
    $like = '%' . $search . '%';

    mysqli_stmt_bind_param($stmt, "ss", $like, $like);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

} else {
    $result = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <a href="#" class="logo">Gr5 <span>Ecommarce</span></a>
            </div>
            
            <nav class="nav">
                <a href="index.php" class="nav-link">Home</a>
                <a href="loginReg.php" class="nav-link">Sgin/up</a>
                <a href="explore.php" class="nav-link">Explore</a>
            </nav>
            
            <div class="header-right">
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

<section class="best-sellers">
    <div class="container">

        <div class="section-header">
            <h2 class="section-title">
                Search Results for “<?= htmlspecialchars($search) ?>”
            </h2>
        </div>

        <div class="product-grid">

            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>

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
                            <?php if ($row['rating'] >= 4.7): ?>
                                <div class="product-badge">Top Rated</div>
                            <?php endif; ?>
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
                                <button class="quick-view-btn">View</button>
                            </a>

                            <button class="add-to-cart-btn" data-product-id="<?= $id ?>">
                                <i class="fas fa-shopping-bag"></i>
                            </button>
                        </div>
                    </div>

                <?php endwhile; ?>

            <?php elseif ($search !== ''): ?>
                <p>No results found for <strong><?= htmlspecialchars($search) ?></strong>.</p>

            <?php else: ?>
                <p>Please enter a search term.</p>
            <?php endif; ?>

        </div>
    </div>
</section>
 <script src="assets/js/app.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>