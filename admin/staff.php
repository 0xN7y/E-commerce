<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login – Gr5 Ecommarce</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary:#0a0a0a;
    --secondary:#1a1a1a;
    --accent:#d4af37;
    --text:#f5f5f5;
    --text-secondary:#a0a0a0;
    --glass:rgba(255,255,255,.08);
    --glass-border:rgba(255,255,255,.15);
    --transition:.3s ease;
}

*{box-sizing:border-box;margin:0;padding:0}

body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:radial-gradient(circle,#1a1a1a,#0a0a0a);
    font-family:Inter,system-ui;
    color:var(--text);
}

/* ---------- LOGIN CARD ---------- */
.login-wrapper{
    width:100%;
    padding:20px;
}

.login-card{
    max-width:420px;
    margin:auto;
    padding:40px;
    background:var(--glass);
    border:1px solid var(--glass-border);
    border-radius:24px;
    backdrop-filter:blur(20px);
}


.login-header{
    text-align:center;
    margin-bottom:30px;
}

.login-header i{
    font-size:42px;
    color:var(--accent);
    margin-bottom:12px;
}

.login-header h1{
    font-size:26px;
}

.login-header p{
    color:var(--text-secondary);
    font-size:14px;
}

/* ---------- FORM ---------- */
.login-form{
    display:flex;
    flex-direction:column;
    gap:18px;
}

.input-group{
    position:relative;
}

.input-group i{
    position:absolute;
    left:16px;
    top:50%;
    transform:translateY(-50%);
    color:var(--text-secondary);
}

.input-group input{
    width:100%;
    padding:14px 16px 14px 44px;
    border-radius:14px;
    border:1px solid var(--glass-border);
    background:var(--secondary);
    color:var(--text);
    font-size:14px;
}

.input-group input:focus{
    outline:none;
    border-color:var(--accent);
}

/* ---------- BUTTON ---------- */
.login-btn{
    margin-top:10px;
    padding:14px;
    border-radius:14px;
    border:none;
    background:linear-gradient(135deg,var(--accent),#b8962e);
    color:#000;
    font-weight:600;
    font-size:15px;
    cursor:pointer;
    transition:var(--transition);
}

.login-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 30px rgba(212,175,55,.25);
}


.login-footer{
    margin-top:20px;
    text-align:center;
    font-size:13px;
    color:var(--text-secondary);
}

/* ---------- MOBILE ---------- */
@media(max-width:480px){
    .login-card{
        padding:30px 24px;
    }
}
</style>
</head>
<?php
require '../db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Look up admin by email
    $sql  = "SELECT id, name, email, password_hash, role, is_active FROM admin WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify password using password_verify
        if (password_verify($password, $row['password_hash'])) {
            if ($row['is_active']) {
                // Set session variables
                $_SESSION['admin_id']   = $row['id'];
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_role'] = $row['role'];
                $_SESSION['mail'] = $row['email'];

                // Redirect to admin.php
                header("Location: /admin/admin.php");
                exit;
            } else {
                $error = "Account inactive.";
            }
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Admin not found.";
    }
    mysqli_stmt_close($stmt);
}
?>

<body>

<div class="login-wrapper">
    <div class="login-card">

        <div class="login-header">
            <i class="fas fa-shield-halved"></i>
            <h1>Admin Login</h1>
            <p>Gr5 Ecommarce Control Panel</p>
        </div>

        <form class="login-form" method="POST">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Admin Email" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button class="login-btn">
                <i class="fas fa-right-to-bracket"></i> Sign In
            </button>
        </form>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" style="color: red; margin-left: 100px"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="login-footer">
            Authorized personnel only
        </div>
    </div>
</div>

</body>
</html>
