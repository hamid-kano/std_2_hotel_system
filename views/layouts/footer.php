<!-- Scroll to Top -->
<button id="scroll-top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
</button>

<footer class="mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <h4 class="fw-800 mb-3" class="text-primary-custom">
                    <i class="fas fa-hotel me-2"></i><?php echo htmlspecialchars($settings['site_title'] ?? APP_NAME); ?>
                </h4>
                <p style="color:var(--text-secondary); font-size:var(--text-sm); line-height:1.7;">
                    <?php echo htmlspecialchars($settings['site_about'] ?? ''); ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h6 class="fw-700 mb-3 text-uppercase" style="font-size:var(--text-xs); letter-spacing:1px; color:var(--text-muted);">
                    Quick Links
                </h6>
                <nav class="d-flex flex-column gap-2">
                    <a href="<?php echo SITE_URL; ?>" class="text-decoration-none d-flex align-items-center gap-2" style="font-size:var(--text-sm);">
                        <i class="fas fa-home" style="color:var(--primary); width:16px;"></i><?php echo lang('home'); ?>
                    </a>
                    <a href="<?php echo SITE_URL; ?>rooms" class="text-decoration-none d-flex align-items-center gap-2" style="font-size:var(--text-sm);">
                        <i class="fas fa-bed" style="color:var(--primary); width:16px;"></i><?php echo lang('rooms'); ?>
                    </a>
                    <a href="<?php echo SITE_URL; ?>facilities" class="text-decoration-none d-flex align-items-center gap-2" style="font-size:var(--text-sm);">
                        <i class="fas fa-concierge-bell" style="color:var(--primary); width:16px;"></i><?php echo lang('facilities'); ?>
                    </a>
                    <a href="<?php echo SITE_URL; ?>contact" class="text-decoration-none d-flex align-items-center gap-2" style="font-size:var(--text-sm);">
                        <i class="fas fa-envelope" style="color:var(--primary); width:16px;"></i><?php echo lang('contact'); ?>
                    </a>
                    <a href="<?php echo SITE_URL; ?>about" class="text-decoration-none d-flex align-items-center gap-2" style="font-size:var(--text-sm);">
                        <i class="fas fa-info-circle" style="color:var(--primary); width:16px;"></i><?php echo lang('about'); ?>
                    </a>
                </nav>
            </div>
            <div class="col-lg-4">
                <h6 class="fw-700 mb-3 text-uppercase" style="font-size:var(--text-xs); letter-spacing:1px; color:var(--text-muted);">
                    Follow Us
                </h6>
                <div class="d-flex gap-3 mb-4">
                    <?php if(!empty($contact['fb'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['fb']); ?>" target="_blank" rel="noopener"
                       class="social-icon" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <?php endif; ?>
                    <?php if(!empty($contact['insta'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['insta']); ?>" target="_blank" rel="noopener"
                       class="social-icon" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <?php endif; ?>
                    <?php if(!empty($contact['tw'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['tw']); ?>" target="_blank" rel="noopener"
                       class="social-icon" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <?php if(!empty($contact['email'])): ?>
                <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>"
                   class="text-decoration-none d-flex align-items-center gap-2" style="font-size:var(--text-sm);">
                    <i class="fas fa-envelope" class="text-primary-custom"></i>
                    <?php echo htmlspecialchars($contact['email']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="border-top py-3 text-center" style="font-size:var(--text-xs); color:var(--text-muted);">
        <i class="fas fa-copyright me-1"></i><?php echo date('Y'); ?>
        <?php echo htmlspecialchars($settings['site_title'] ?? APP_NAME); ?> — All rights reserved.
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- App config -->
<script>const APP = { siteUrl: '<?php echo SITE_URL; ?>' };</script>
<!-- Main JS -->
<script src="<?php echo ASSETS_URL; ?>js/main.js"></script>

</body>
</html>
