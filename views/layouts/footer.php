<button id="scroll-top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
</button>

<footer class="mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <h4 class="fw-800 mb-3 text-primary-custom d-flex align-items-center gap-2">
                    <i class="fas fa-hotel"></i>
                    <?php echo htmlspecialchars($settings['site_title'] ?? APP_NAME); ?>
                </h4>
                <p class="footer-about"><?php echo htmlspecialchars($settings['site_about'] ?? ''); ?></p>
            </div>
            <div class="col-lg-4">
                <p class="footer-label"><?php echo lang('quick_links'); ?></p>
                <nav class="d-flex flex-column gap-2">
                    <a href="<?php echo SITE_URL; ?>"><i class="fas fa-home"></i><?php echo lang('home'); ?></a>
                    <a href="<?php echo SITE_URL; ?>rooms"><i class="fas fa-bed"></i><?php echo lang('rooms'); ?></a>
                    <a href="<?php echo SITE_URL; ?>facilities"><i class="fas fa-concierge-bell"></i><?php echo lang('facilities'); ?></a>
                    <a href="<?php echo SITE_URL; ?>contact"><i class="fas fa-envelope"></i><?php echo lang('contact'); ?></a>
                    <a href="<?php echo SITE_URL; ?>about"><i class="fas fa-info-circle"></i><?php echo lang('about'); ?></a>
                </nav>
            </div>
            <div class="col-lg-4">
                <p class="footer-label"><?php echo lang('follow_us'); ?></p>
                <div class="d-flex gap-3 mb-4">
                    <?php if(!empty($contact['fb'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['fb']); ?>" target="_blank" rel="noopener" class="social-icon" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <?php endif; ?>
                    <?php if(!empty($contact['insta'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['insta']); ?>" target="_blank" rel="noopener" class="social-icon" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <?php endif; ?>
                    <?php if(!empty($contact['tw'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['tw']); ?>" target="_blank" rel="noopener" class="social-icon" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <?php if(!empty($contact['email'])): ?>
                <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="footer-email">
                    <i class="fas fa-envelope text-primary-custom"></i>
                    <?php echo htmlspecialchars($contact['email']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <i class="fas fa-copyright"></i>
        <?php echo date('Y'); ?>
        <?php echo htmlspecialchars($settings['site_title'] ?? APP_NAME); ?> —
        <?php echo lang('all_rights_reserved'); ?>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>const APP = { siteUrl: '<?php echo SITE_URL; ?>' };</script>
<script src="<?php echo ASSETS_URL; ?>js/main.js"></script>
</body>
</html>
