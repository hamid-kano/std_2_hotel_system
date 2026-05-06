<!-- Scroll to Top Button -->
<button id="scroll-top" aria-label="Scroll to top" title="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>

<footer class="container-fluid bg-white mt-5 border-top">
    <div class="row py-4">
        <div class="col-lg-4 p-4">
            <h3 class="fw-bold fs-3 mb-2" style="color:var(--teal);">
                <i class="fas fa-hotel me-2"></i><?php echo htmlspecialchars($settings['site_title'] ?? APP_NAME); ?>
            </h3>
            <p class="text-muted"><?php echo htmlspecialchars($settings['site_about'] ?? ''); ?></p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3 fw-bold"><i class="fas fa-link me-2"></i>Quick Links</h5>
            <a href="<?php echo SITE_URL; ?>" class="d-block mb-2 text-dark text-decoration-none">
                <i class="fas fa-home me-2"></i><?php echo lang('home'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>rooms" class="d-block mb-2 text-dark text-decoration-none">
                <i class="fas fa-bed me-2"></i><?php echo lang('rooms'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>facilities" class="d-block mb-2 text-dark text-decoration-none">
                <i class="fas fa-concierge-bell me-2"></i><?php echo lang('facilities'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>contact" class="d-block mb-2 text-dark text-decoration-none">
                <i class="fas fa-envelope me-2"></i><?php echo lang('contact'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>about" class="d-block mb-2 text-dark text-decoration-none">
                <i class="fas fa-info-circle me-2"></i><?php echo lang('about'); ?>
            </a>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="fw-bold mb-3"><i class="fas fa-share-alt me-2"></i>Follow us</h5>
            <?php if(!empty($contact['tw'])): ?>
            <a href="<?php echo htmlspecialchars($contact['tw']); ?>" class="d-block mb-2 text-decoration-none text-dark" target="_blank" rel="noopener">
                <i class="fab fa-twitter me-2"></i>Twitter
            </a>
            <?php endif; ?>
            <?php if(!empty($contact['fb'])): ?>
            <a href="<?php echo htmlspecialchars($contact['fb']); ?>" class="d-block mb-2 text-decoration-none text-dark" target="_blank" rel="noopener">
                <i class="fab fa-facebook me-2"></i>Facebook
            </a>
            <?php endif; ?>
            <?php if(!empty($contact['insta'])): ?>
            <a href="<?php echo htmlspecialchars($contact['insta']); ?>" class="d-block mb-2 text-decoration-none text-dark" target="_blank" rel="noopener">
                <i class="fab fa-instagram me-2"></i>Instagram
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="text-center py-3 border-top small text-muted">
        <i class="fas fa-copyright me-1"></i><?php echo date('Y'); ?> <?php echo htmlspecialchars($settings['site_title'] ?? APP_NAME); ?>. All rights reserved.
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- App config passed to JS -->
<script>
    const APP = { siteUrl: '<?php echo SITE_URL; ?>' };
</script>

<!-- Custom JS -->
<script src="<?php echo ASSETS_URL; ?>js/main.js"></script>

</body>
</html>
