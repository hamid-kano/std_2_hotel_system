<?php $pageTitle = lang('404_title') . ' — ' . APP_NAME; ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container text-center py-5 my-5">
    <i class="fas fa-exclamation-triangle fa-5x mb-4 text-primary-custom"></i>
    <h1 class="fw-800 display-4"><?php echo lang('404_title'); ?></h1>
    <p class="text-secondary mb-4" style="font-size:var(--fs-lg);"><?php echo lang('404_msg'); ?></p>
    <a href="<?php echo SITE_URL; ?>" class="btn custom-bg">
        <i class="fas fa-home"></i><?php echo lang('back_home'); ?>
    </a>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>
