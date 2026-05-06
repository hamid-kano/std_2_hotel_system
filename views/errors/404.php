<?php $pageTitle = '404 — Page Not Found'; ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container text-center py-5 my-5">
    <i class="fas fa-exclamation-triangle fa-5x mb-4" class="text-primary-custom"></i>
    <h1 class="fw-bold display-4">404</h1>
    <p class="text-muted fs-5 mb-4">Oops! The page you're looking for doesn't exist.</p>
    <a href="<?php echo SITE_URL; ?>" class="btn text-white custom-bg shadow-none">
        <i class="fas fa-home me-2"></i>Back to Home
    </a>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>
