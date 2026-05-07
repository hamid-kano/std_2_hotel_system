<?php $pageTitle = APP_NAME . ' — Booking Confirmed'; ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <!-- Success Card -->
            <div class="card border-0 shadow-lg text-center p-5 mb-4" style="border-radius:var(--r-2xl);">
                <!-- Animated checkmark -->
                <div class="success-icon mx-auto mb-4">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2 class="fw-800 mb-2">Booking Confirmed!</h2>
                <p class="text-secondary mb-4">
                    Your reservation has been successfully placed. A summary is shown below.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="<?php echo SITE_URL; ?>bookings" class="btn custom-bg">
                        <i class="fas fa-calendar-check"></i><?php echo lang('bookings'); ?>
                    </a>
                    <a href="<?php echo SITE_URL; ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-home"></i><?php echo lang('home'); ?>
                    </a>
                </div>
            </div>

            <!-- Booking Receipt -->
            <div class="card border-0 shadow-sm" style="border-radius:var(--r-xl);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-700 mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-receipt text-primary-custom"></i>Booking Receipt
                        </h5>
                        <span class="badge status-booked rounded-pill px-3 py-2">
                            <i class="fas fa-check-circle"></i> Confirmed
                        </span>
                    </div>

                    <div class="receipt-grid">
                        <div class="receipt-row">
                            <span class="receipt-label"><i class="fas fa-hashtag"></i>Order ID</span>
                            <span class="receipt-value fw-700 text-primary-custom"><?php echo htmlspecialchars($booking['order_id']); ?></span>
                        </div>
                        <div class="receipt-row">
                            <span class="receipt-label"><i class="fas fa-bed"></i>Room</span>
                            <span class="receipt-value"><?php echo htmlspecialchars($booking['room_name']); ?></span>
                        </div>
                        <div class="receipt-row">
                            <span class="receipt-label"><i class="fas fa-user"></i>Guest</span>
                            <span class="receipt-value"><?php echo htmlspecialchars($booking['user_name']); ?></span>
                        </div>
                        <div class="receipt-row">
                            <span class="receipt-label"><i class="fas fa-phone"></i>Phone</span>
                            <span class="receipt-value"><?php echo htmlspecialchars($booking['phonenum']); ?></span>
                        </div>
                        <div class="receipt-row">
                            <span class="receipt-label"><i class="fas fa-calendar-check"></i>Check-in</span>
                            <span class="receipt-value"><?php echo date('d M Y', strtotime($booking['check_in'])); ?></span>
                        </div>
                        <div class="receipt-row">
                            <span class="receipt-label"><i class="fas fa-calendar-times"></i>Check-out</span>
                            <span class="receipt-value"><?php echo date('d M Y', strtotime($booking['check_out'])); ?></span>
                        </div>
                        <div class="receipt-row">
                            <span class="receipt-label"><i class="fas fa-moon"></i>Nights</span>
                            <span class="receipt-value">
                                <?php echo (new DateTime($booking['check_in']))->diff(new DateTime($booking['check_out']))->days; ?>
                            </span>
                        </div>
                        <div class="receipt-row receipt-row--total">
                            <span class="receipt-label fw-700"><i class="fas fa-dollar-sign"></i>Total Paid</span>
                            <span class="receipt-value fw-800" style="font-size:var(--fs-xl); color:var(--primary);">
                                <?php echo number_format($booking['total_pay'], 2); ?>
                            </span>
                        </div>
                    </div>

                    <p class="text-secondary text-center mt-4 mb-0" style="font-size:var(--fs-xs);">
                        <i class="fas fa-info-circle text-primary-custom"></i>
                        Please present this confirmation at check-in. Booking ID: <strong><?php echo $booking['booking_id']; ?></strong>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<style>
.success-icon {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: rgba(40,167,69,.12);
    display: flex; align-items: center; justify-content: center;
    animation: popIn .5s cubic-bezier(.175,.885,.32,1.275);
}
.success-icon i {
    font-size: 2.5rem;
    color: #28a745;
    width: auto;
}
@keyframes popIn {
    from { transform: scale(0); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}

.receipt-grid { display: flex; flex-direction: column; gap: 0; }
.receipt-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .625rem 0;
    border-bottom: 1px solid var(--border-light);
    font-size: var(--fs-sm);
}
.receipt-row:last-child { border-bottom: none; }
.receipt-row--total {
    background: var(--primary-light);
    border: 1px solid rgba(46,193,172,.2);
    border-radius: var(--r-lg);
    padding: .75rem 1rem;
    margin-top: .5rem;
}
.receipt-label {
    display: inline-flex; align-items: center; gap: var(--icon-gap);
    color: var(--text-secondary);
}
.receipt-label i { width: 1em; text-align: center; flex-shrink: 0; }
.receipt-value { font-weight: 500; color: var(--text-primary); }
</style>
