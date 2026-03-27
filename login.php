<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id_user, jabatan, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['jabatan'] = $user['jabatan'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Username atau password salah!';
        }
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem UKMPC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="UKM PC Logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-wrapper" style="padding-top:120px; padding-bottom:120px;">

    <!-- Header -->
    <header class="page-header" style="max-width:420px; margin:0 auto 48px;">
        <div class="header-eyebrow" style="letter-spacing:0.3em;">UKMPC</div>
        <h1 class="page-title" style="font-size:2.8rem;">Login</h1>
        <p class="page-subtitle">Masuk ke sistem manajemen UKMPC.</p>
    </header>

    <!-- Login Card -->
    <section style="max-width:420px; margin:0 auto;">
        <div class="login-card">
            <?php if ($error): ?>
            <div style="background: rgba(248,113,113,0.2); border:1px solid rgba(248,113,113,0.4); border-radius:12px; padding:16px; margin-bottom:24px; color: var(--danger); font-size:14px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <form method="POST">
                <label class="form-label" for="username">Username</label>
                <input type="text" class="form-control mb-4" id="username" name="username" required autofocus>

                <label class="form-label" for="password">Password</label>
                <input type="password" class="form-control mb-6" id="password" name="password" required>

                <button type="submit" class="btn-modern primary w-100" style="margin-top:8px;">Masuk ke Sistem</button>
            </form>
        </div>

        <div style="text-align:center; margin-top:32px; color: var(--muted); font-size:13px;">
            Belum punya akun? Hubungi <strong>Administrator</strong>
        </div>
    </section>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

