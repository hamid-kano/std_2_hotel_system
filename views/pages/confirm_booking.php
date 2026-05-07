<?php $pageTitle = APP_NAME . ' — ' . lang('booking_confirm'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>"><i class="fas fa-home"></i><?php echo lang('home'); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>rooms"><i class="fas fa-bed"></i><?php echo lang('rooms'); ?></a></li>
            <li class="breadcrumb-item active"><?php echo lang('booking_confirm'); ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Room Preview -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm overflow-hidden">
                <img src="<?php echo $thumbnail; ?>" class="w-100" style="height:260px;object-fit:cover;"
                     alt="<?php echo htmlspecialchars($room['name']); ?>" loading="lazy">
                <div class="card-body p-4">
                    <h4 class="fw-700 mb-1"><?php echo htmlspecialchars($room['name']); ?></h4>
                    <p class="text-secondary mb-2" style="font-size:var(--fs-sm);">
                        <i class="fas fa-moon text-primary-custom"></i>
                        <strong><?php echo $room['price']; ?></strong> <?php echo lang('per_night'); ?>
                    </p>
                    <?php if($rating > 0): ?>
                    <div class="mb-2">
                        <?php for($i=0; $i<round($rating); $i++): ?>
                        <i class="fas fa-star text-warning"></i>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                    <div class="d-flex gap-2 flex-wrap mt-3">
                        <span class="badge bg-light">
                            <i class="fas fa-user"></i><?php echo $room['adult']; ?> <?php echo lang('adults'); ?>
                        </span>
                        <span class="badge bg-light">
                            <i class="fas fa-child"></i><?php echo $room['children']; ?> <?php echo lang('children'); ?>
                        </span>
                        <?php if(!empty($room['area'])): ?>
                        <span class="badge bg-light">
                            <i class="fas fa-expand-arrows-alt"></i><?php echo htmlspecialchars($room['area']); ?> m²
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-700 mb-4 d-flex align-items-center gap-2">
                        <span class="step-badge">1</span>
                        <?php echo lang('booking_confirm'); ?>
                    </h5>

                    <form action="<?php echo SITE_URL; ?>booking/pay" method="POST" id="booking_form">                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-user"></i><?php echo lang('name'); ?></label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"
                                       class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-phone"></i><?php echo lang('phone'); ?></label>
                                <input type="text" name="phonenum" value="<?php echo htmlspecialchars($user['phonenum']); ?>"
                                       class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label"><i class="fas fa-map-marker-alt"></i><?php echo lang('address'); ?></label>
                                <input name="address" value="<?php echo htmlspecialchars($user['address']); ?>"
                                       class="form-control" required>
                            </div>
                            <div class="col-12"><hr class="my-1"></div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-calendar-check"></i><?php echo lang('check_in'); ?></label>
                                <input type="date" name="checkin" id="checkin_input" onchange="check_availability()"
                                       class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-calendar-times"></i><?php echo lang('check_out'); ?></label>
                                <input type="date" name="checkout" id="checkout_input" onchange="check_availability()"
                                       class="form-control" required>
                            </div>

                            <div class="col-12">
                                <div id="avail_loader" class="d-none text-center py-2">
                                    <div class="spinner-border spinner-border-sm text-info" role="status"></div>
                                    <span class="ms-2 text-secondary" style="font-size:var(--fs-sm);"><?php echo lang('checking_avail'); ?></span>
                                </div>
                                <div id="avail_status" class="d-none rounded-3 p-3" style="font-size:var(--fs-sm);"></div>
                            </div>

                            <div class="col-12 d-none" id="summary_box">
                                <div class="summary-box">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-secondary" style="font-size:var(--fs-sm);">
                                            <i class="fas fa-moon"></i><?php echo lang('nights'); ?>
                                        </span>
                                        <strong id="summary_nights">—</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-secondary" style="font-size:var(--fs-sm);">
                                            <i class="fas fa-dollar-sign"></i><?php echo lang('total_price'); ?>
                                        </span>
                                        <strong id="summary_total" class="text-primary-custom">—</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <button name="pay_now" id="pay_btn" type="submit"
                                        class="btn w-100 custom-bg" disabled>
                                    <i class="fas fa-credit-card"></i><?php echo lang('booking_confirm'); ?>
                                </button>
                                <p class="text-secondary text-center mt-2 mb-0" style="font-size:var(--fs-xs);">
                                    <i class="fas fa-shield-alt"></i><?php echo lang('secure_booking'); ?>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<script>
const LANG = {
    avail_equal:     '<?php echo lang('avail_equal'); ?>',
    avail_out_earlier:'<?php echo lang('avail_out_earlier'); ?>',
    avail_in_past:   '<?php echo lang('avail_in_past'); ?>',
    unavailable:     '<?php echo lang('avail_unavailable'); ?>',
    try_other:       '<?php echo lang('avail_try_other'); ?>',
    room_available:  '<?php echo lang('room_available'); ?>',
    connection_error:'<?php echo lang('connection_error'); ?>',
    nights_label:    '<?php echo lang('nights'); ?>',
};

const ci = document.getElementById('checkin_input');
const co = document.getElementById('checkout_input');
const loader = document.getElementById('avail_loader');
const statusEl = document.getElementById('avail_status');
const summary = document.getElementById('summary_box');
const payBtn = document.getElementById('pay_btn');
const today = new Date().toISOString().split('T')[0];
ci.min = co.min = today;
ci.addEventListener('change', ()=>{ if(ci.value) co.min = ci.value; });

function setStatus(msg, type){
    const icons = {success:'fa-check-circle', danger:'fa-exclamation-circle', warning:'fa-exclamation-triangle'};
    statusEl.className = `alert alert-${type} rounded-3 p-3`;
    statusEl.style.fontSize = 'var(--fs-sm)';
    statusEl.innerHTML = `<i class="fas ${icons[type]||'fa-info-circle'}"></i> ${msg}`;
    statusEl.classList.remove('d-none');
}

function check_availability(){
    if(!ci.value || !co.value) return;
    if(ci.value >= co.value){ setStatus(LANG.avail_out_earlier,'danger'); return; }
    if(ci.value < today){ setStatus(LANG.avail_in_past,'danger'); return; }

    statusEl.classList.add('d-none');
    summary.classList.add('d-none');
    payBtn.disabled = true;
    loader.classList.remove('d-none');

    const data = new FormData();
    data.append('check_availability','');
    data.append('check_in', ci.value);
    data.append('check_out', co.value);

    fetch(APP.siteUrl + 'api/booking/check-availability', {method:'POST', body:data})
        .then(r=>r.json())
        .then(res=>{
            loader.classList.add('d-none');
            if(res.status==='available'){
                setStatus('<strong>' + LANG.room_available + '</strong>','success');
                document.getElementById('summary_nights').textContent = res.days + ' ' + LANG.nights_label;
                document.getElementById('summary_total').textContent = res.payment;
                summary.classList.remove('d-none');
                payBtn.disabled = false;
            } else {
                const msgs = {
                    check_in_out_equal: LANG.avail_equal,
                    check_out_earlier:  LANG.avail_out_earlier,
                    check_in_earlier:   LANG.avail_in_past,
                    unavailable:        LANG.unavailable,
                };
                setStatus(msgs[res.status] || LANG.try_other, 'danger');
            }
        })
        .catch(()=>{ loader.classList.add('d-none'); setStatus(LANG.connection_error,'danger'); });
}
</script>
