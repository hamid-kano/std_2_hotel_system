<?php $pageTitle = APP_NAME . ' — ' . lang('facilities'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-hero text-center">
    <h2 class="fw-800 d-flex align-items-center justify-content-center gap-2">
        <i class="fas fa-concierge-bell text-primary-custom"></i>
        <?php echo lang('facilities'); ?>
    </h2>
    <div class="section-divider"></div>
    <p class="text-secondary mx-auto" style="max-width:700px;">
        <?php echo lang('facilities_intro'); ?>
    </p>
</div>

<div class="container mb-5">
    <div class="row g-4">
        <?php if (!empty($facilities)): ?>
            <?php foreach($facilities as $facility): ?>
            <div class="col-lg-4 col-md-6">
                <div class="facility-card h-100 p-4 rounded-3 shadow-sm" style="background:var(--bg-card); border:1px solid var(--border-color); transition:transform 0.3s;">
                    <div class="text-center mb-3">
                        <?php if (!empty($facility['icon'])): ?>
                            <img src="<?php echo FACILITIES_IMG_PATH . htmlspecialchars($facility['icon']); ?>" 
                                 alt="<?php echo htmlspecialchars($facility['name']); ?>" 
                                 style="width:80px; height:80px; object-fit:contain;"
                                 loading="lazy">
                        <?php else: ?>
                            <i class="fas fa-concierge-bell fa-3x text-primary-custom"></i>
                        <?php endif; ?>
                    </div>
                    <h5 class="fw-700 text-center mb-3">
                        <?php echo getTranslation('facilities_translations', $facility['id'], 'name', $facility['name']); ?>
                    </h5>
                    <?php if (!empty($facility['description'])): ?>
                        <p class="text-secondary text-center mb-0">
                            <?php echo getTranslation('facilities_translations', $facility['id'], 'description', $facility['description']); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    <?php echo lang('no_facilities'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<style>
.facility-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}
</style>
