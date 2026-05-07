<?php
// Minimal error page — no layout dependencies to avoid further errors
$savedTheme = $_COOKIE['vana_theme'] ?? 'light';
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo htmlspecialchars($savedTheme); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Server Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root { --primary:#2ec1ac; --bg-body:#f4f6f8; --text-primary:#1a1d23; --text-secondary:#5a6474; }
        [data-theme="dark"] { --bg-body:#0d0d1a; --text-primary:#e4e6eb; --text-secondary:#9aa3b0; }
        body { background:var(--bg-body); color:var(--text-primary); min-height:100vh; display:flex; align-items:center; justify-content:center; font-family:system-ui,sans-serif; }
    </style>
</head>
<body>
<div class="text-center px-4">
    <i class="fas fa-exclamation-triangle fa-4x mb-4" style="color:var(--primary);"></i>
    <h1 class="fw-800 display-4 mb-2">500</h1>
    <p style="color:var(--text-secondary); font-size:1.1rem;" class="mb-4">
        Something went wrong on our end. Please try again.
    </p>
    <a href="javascript:history.back()" class="btn me-2"
       style="background:var(--primary);color:#fff;border:none;">
        <i class="fas fa-arrow-left me-1"></i> Go Back
    </a>
    <a href="/" class="btn btn-outline-secondary">
        <i class="fas fa-home me-1"></i> Home
    </a>
    <?php if(isset($message) && ini_get('display_errors')): ?>
    <div class="mt-4 p-3 rounded text-start" style="background:rgba(220,53,69,.1);border:1px solid rgba(220,53,69,.3);font-size:.8rem;color:#b02a37;max-width:600px;margin:1rem auto 0;">
        <strong>Debug:</strong> <?php echo htmlspecialchars($message); ?>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
