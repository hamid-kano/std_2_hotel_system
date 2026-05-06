<?php $pageTitle = APP_NAME . ' — ' . lang('contact'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="my-5 px-4 text-center">
    <h2 class="fw-bold">
        <i class="fas fa-envelope me-2" style="color:var(--teal);"></i>Contact Us
    </h2>
    <hr class="mx-auto" style="width:80px;border-color:var(--teal);border-width:3px;">
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Map & Info -->
        <div class="col-lg-6 mb-5 px-4">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <iframe src="<?php echo htmlspecialchars($contact['iframe'] ?? ''); ?>"
                        class="w-100 rounded-3 mb-4" height="280" title="Map" loading="lazy"></iframe>

                <h5 class="fw-bold mb-3">
                    <i class="fas fa-map-marker-alt me-2" style="color:var(--teal);"></i>Address
                </h5>
                <a href="<?php echo htmlspecialchars($contact['gmap'] ?? '#'); ?>" target="_blank"
                   class="d-block text-decoration-none text-dark mb-4">
                    <?php echo htmlspecialchars($contact['address'] ?? ''); ?>
                </a>

                <h5 class="fw-bold mb-3">
                    <i class="fas fa-phone me-2" style="color:var(--teal);"></i>Call Us
                </h5>
                <?php if(!empty($contact['pn1'])): ?>
                <a href="tel:+<?php echo htmlspecialchars($contact['pn1']); ?>"
                   class="d-block mb-2 text-decoration-none text-dark">
                    <i class="fas fa-phone-alt me-2"></i>+<?php echo htmlspecialchars($contact['pn1']); ?>
                </a>
                <?php endif; ?>
                <?php if(!empty($contact['pn2'])): ?>
                <a href="tel:+<?php echo htmlspecialchars($contact['pn2']); ?>"
                   class="d-block mb-2 text-decoration-none text-dark">
                    <i class="fas fa-phone-alt me-2"></i>+<?php echo htmlspecialchars($contact['pn2']); ?>
                </a>
                <?php endif; ?>

                <?php if(!empty($contact['email'])): ?>
                <h5 class="fw-bold mt-3 mb-3">
                    <i class="fas fa-envelope me-2" style="color:var(--teal);"></i>Email
                </h5>
                <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>"
                   class="d-block mb-2 text-decoration-none text-dark">
                    <i class="fas fa-at me-2"></i><?php echo htmlspecialchars($contact['email']); ?>
                </a>
                <?php endif; ?>

                <h5 class="fw-bold mt-3 mb-3">
                    <i class="fas fa-share-alt me-2" style="color:var(--teal);"></i>Follow Us
                </h5>
                <div class="d-flex gap-3">
                    <?php if(!empty($contact['fb'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['fb']); ?>" target="_blank" class="text-dark fs-5">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <?php endif; ?>
                    <?php if(!empty($contact['insta'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['insta']); ?>" target="_blank" class="text-dark fs-5">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <?php endif; ?>
                    <?php if(!empty($contact['tw'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['tw']); ?>" target="_blank" class="text-dark fs-5">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-6 px-4">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-paper-plane me-2" style="color:var(--teal);"></i>Send a Message
                </h5>
                <?php if(Session::flash('contact_status') === 'success'): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>Message sent successfully!</div>
                <?php elseif(Session::flash('contact_status') === 'error'): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>Failed to send. Try again.</div>
                <?php endif; ?>
                <form method="POST" action="<?php echo SITE_URL; ?>contact">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user me-1"></i>Name</label>
                        <input type="text" name="name" required class="form-control shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope me-1"></i>Email</label>
                        <input type="email" name="email" required class="form-control shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-tag me-1"></i>Subject</label>
                        <input type="text" name="subject" required class="form-control shadow-none">
                    </div>
                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-comment me-1"></i>Message</label>
                        <textarea name="message" required class="form-control shadow-none" rows="5" style="resize:none;"></textarea>
                    </div>
                    <button type="submit" name="send" class="btn text-white custom-bg shadow-none w-100">
                        <i class="fas fa-paper-plane me-2"></i>Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>
