<?php $pageTitle = APP_NAME . ' — ' . lang('booking_confirm'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-decoration-none"><i class="fas fa-home me-1"></i>Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>rooms" class="text-decoration-none"><i class="fas fa-bed me-1"></i>Rooms</a></li>
            <li class="breadcrumb-item active"><?php echo lang('booking_confirm'); ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Room Preview -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <img src="<?php echo $thumbnail; ?>" class="w-100" style="height:260px;object-fit:cover;"
                     alt="<?php echo htmlspecialchars($room['name']); ?>" loading="lazy">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-1"><?php echo htmlspecialchars($room['name']); ?></h4>
                    <p class="text-muted mb-2">
                        <i class="fas fa-moon me-1"></i>
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
                        <span class="badge bg-light text-dark border">
                            <i class="fas fa-user me-1"></i><?php echo $room['adult']; ?> Adults
                        </span>
                        <span class="badge bg-light text-dark border">
                            <i class="fas fa-child me-1"></i><?php echo $room['children']; ?> Children
                        </span>
                        <?php if(!empty($room['area'])): ?>
                        <span class="badge bg-light text-dark border">
                            <i class="fas fa-expand-arrows-alt me-1"></i><?php echo htmlspecialchars($room['area']); ?> m²
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <span class="badge rounded-circle me-2 text-white" style="background:var(--teal);width:28px;height:28px;line-height:28px;">1</span>
                        <?php echo lang('booking_confirm'); ?>
                    </h5>

                    <form action="<?php echo SITE_URL; ?>booking/pay" method="POST" id="booking_form">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-user me-1"></i><?php echo lang('name'); ?></label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"
                                       class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-phone me-1"></i><?php echo lang('phone'); ?></label>
                                <input type="text" name="phonenum" value="<?php echo htmlspecialchars($user['phonenum']); ?>"
                                       class="form-control shadow-none" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Address</label>
                                <input name="address" value="<?php echo htmlspecialchars($user['address']); ?>"
                                       class="form-control shadow-none" required>
                            </div>
                            <div class="col-12"><hr class="my-1"></div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-calendar-check me-1"></i><?php echo lang('check_in'); ?></label>
                                <input type="date" name="checkin" id="checkin_input" onchange="check_availability()"
                                       class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-calendar-times me-1"></i><?php echo lang('check_out'); ?></label>
                                <input type="date" name="checkout" id="checkout_input" onchange="check_availability()"
                                       class="form-control shadow-none" required>
                            </div>

                            <!-- Availability Status -->
                            <div class="col-12">
                                <div id="avail_loader" class="d-none text-center py-2">
                                    <div class="spinner-border spinner-border-sm text-info" role="status"></div>
                                    <span class="ms-2 text-muted small">Checking availability...</span>
                                </div>
                                <div id="avail_status" class="d-none rounded-3 p-3 small"></div>
                            </div>

                            <!-- Summary -->
                            <div class="col-12 d-none" id="summary_box">
                                <div class="p-3 rounded-3 border" style="background:rgba(46,193,172,.08);">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted small"><i class="fas fa-moon me-1"></i>Nights</span>
                                        <strong id="summary_nights">—</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small"><i class="fas fa-dollar-sign me-1"></i><?php echo lang('total_price'); ?></span>
                                        <strong id="summary_total" style="color:var(--teal);">—</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <button name="pay_now" id="pay_btn" type="submit"
                                        class="btn w-100 text-white custom-bg shadow-none" disabled>
                                    <i class="fas fa-credit-card me-2"></i><?php echo lang('booking_confirm'); ?>
                                </button>
                                <p class="text-muted small text-center mt-2 mb-0">
                                    <i class="fas fa-shield-alt me-1"></i>Secure booking
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
const ci = document.getElementById('checkin_input');
const co = document.getElementById('checkout_input');
const loader = document.getElementById('avail_loader');
const status = document.getElementById('avail_status');
const summary = document.getElementById('summary_box');
const payBtn = document.getElementById('pay_btn');
const today = new Date().toISOString().split('T')[0];
ci.min = co.min = today;
ci.addEventListener('change', ()=>{ if(ci.value) co.min = ci.value; });

function setStatus(msg, type){
    const icons = {success:'fa-check-circle', danger:'fa-exclamation-circle', warning:'fa-exclamation-triangle'};
    status.className = `alert alert-${type} rounded-3 p-3 small`;
    status.innerHTML = `<i class="fas ${icons[type]||'fa-info-circle'} me-2"></i>${msg}`;
    status.classList.remove('d-none');
}

function check_availability(){
    if(!ci.value || !co.value) return;
    if(ci.value >= co.value){ setStatus('Check-out must be after check-in.','danger'); return; }
    if(ci.value < today){ setStatus('Check-in cannot be in the past.','danger'); return; }

    status.classList.add('d-none');
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
                setStatus('<strong>Room is available!</strong>','success');
                document.getElementById('summary_nights').textContent = res.days + ' night(s)';
                document.getElementById('summary_total').textContent = res.payment;
                summary.classList.remove('d-none');
                payBtn.disabled = false;
            } else {
                const msgs = {
                    check_in_out_equal:'Check-in and check-out cannot be the same day.',
                    check_out_earlier:'Check-out must be after check-in.',
                    check_in_earlier:'Check-in cannot be in the past.',
                    unavailable:'Room is not available for these dates.'
                };
                setStatus(msgs[res.status]||'Please try different dates.','danger');
            }
        })
        .catch(()=>{ loader.classList.add('d-none'); setStatus('Connection error.','danger'); });
}
</script>
