<?php $pageTitle = APP_NAME . ' — ' . lang('contact'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-hero text-center">
    <h2 class="fw-800 d-flex align-items-center justify-content-center gap-2">
        <i class="fas fa-envelope text-primary-custom"></i><?php echo lang('contact_us'); ?>
    </h2>
    <div class="section-divider"></div>
</div>

<div class="container mb-5">
    <div class="row g-4">

        <!-- Map & Info -->
        <div class="col-lg-6">
            <div class="card p-4 h-100">
                <iframe src="<?php echo htmlspecialchars($contact['iframe'] ?? ''); ?>"
                        class="w-100 rounded-3 mb-4" height="240" title="Map" loading="lazy" style="border:none;"></iframe>

                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <p class="contact-info-label"><?php echo lang('address_label'); ?></p>
                        <a href="<?php echo htmlspecialchars($contact['gmap'] ?? '#'); ?>" target="_blank" class="contact-info-value">
                            <?php echo htmlspecialchars($contact['address'] ?? ''); ?>
                        </a>
                    </div>
                </div>

                <?php if(!empty($contact['pn1'])): ?>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-phone-alt"></i></div>
                    <div>
                        <p class="contact-info-label"><?php echo lang('call_us_label'); ?></p>
                        <a href="tel:+<?php echo htmlspecialchars($contact['pn1']); ?>" class="contact-info-value">
                            +<?php echo htmlspecialchars($contact['pn1']); ?>
                        </a>
                        <?php if(!empty($contact['pn2'])): ?>
                        <a href="tel:+<?php echo htmlspecialchars($contact['pn2']); ?>" class="contact-info-value d-block mt-1">
                            +<?php echo htmlspecialchars($contact['pn2']); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!empty($contact['email'])): ?>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <p class="contact-info-label"><?php echo lang('email_label'); ?></p>
                        <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="contact-info-value">
                            <?php echo htmlspecialchars($contact['email']); ?>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <div class="contact-info-item border-0 pb-0 mb-0">
                    <div class="contact-info-icon"><i class="fas fa-share-alt"></i></div>
                    <div>
                        <p class="contact-info-label"><?php echo lang('follow_us_label'); ?></p>
                        <div class="d-flex gap-2 mt-1">
                            <?php if(!empty($contact['fb'])): ?>
                            <a href="<?php echo htmlspecialchars($contact['fb']); ?>" target="_blank" class="social-icon" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <?php endif; ?>
                            <?php if(!empty($contact['insta'])): ?>
                            <a href="<?php echo htmlspecialchars($contact['insta']); ?>" target="_blank" class="social-icon" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <?php endif; ?>
                            <?php if(!empty($contact['tw'])): ?>
                            <a href="<?php echo htmlspecialchars($contact['tw']); ?>" target="_blank" class="social-icon" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-6">
            <div class="card p-4 h-100">
                <h5 class="fw-700 mb-4 d-flex align-items-center gap-2">
                    <i class="fas fa-paper-plane text-primary-custom"></i><?php echo lang('send_message'); ?>
                </h5>

                <?php if(Session::flash('contact_status') === 'success'): ?>
                <div class="alert alert-success d-flex align-items-center gap-2">
                    <i class="fas fa-check-circle"></i><?php echo lang('msg_sent'); ?>
                </div>
                <?php elseif(Session::flash('contact_status') === 'error'): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i><?php echo lang('msg_failed'); ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo SITE_URL; ?>contact">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user"></i><?php echo lang('name'); ?></label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope"></i><?php echo lang('email'); ?></label>
                        <input type="email" name="email" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-tag"></i><?php echo lang('subject'); ?></label>
                        <input type="text" name="subject" required class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-comment"></i><?php echo lang('message'); ?></label>
                        <textarea name="message" required class="form-control" rows="5" style="resize:none;"></textarea>
                    </div>
                    <button type="submit" name="send" class="btn custom-bg w-100">
                        <i class="fas fa-paper-plane"></i><?php echo lang('send_btn'); ?>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>
