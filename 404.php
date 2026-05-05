<?php
http_response_code(404);
require('inc/header1.php');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title>404 - <?php echo lang('not_found'); ?></title>
</head>
<body class="bg-light">
    <?php require('inc/header1.php'); ?>

    <div class="container text-center py-5 my-5">
        <div style="font-size:100px; line-height:1;">🏨</div>
        <h1 class="display-1 fw-bold" style="color:var(--teal);">404</h1>
        <h4 class="mb-3"><?php echo lang('not_found'); ?></h4>
        <p class="text-muted mb-4">The page you're looking for doesn't exist or has been moved.</p>
        <a href="hotel.php" class="btn text-white custom-bg shadow-none px-4">
            <i class="bi bi-house me-2"></i><?php echo lang('home'); ?>
        </a>
    </div>

    <?php require('inc/footer.php'); ?>
</body>
</html>
