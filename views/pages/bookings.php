<?php $pageTitle = APP_NAME . ' — ' . lang('bookings'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5 px-4">
            <h2 class="fw-700 d-flex align-items-center gap-2">
                <i class="fas fa-calendar-check text-primary-custom"></i><?php echo lang('bookings'); ?>
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>"><i class="fas fa-home"></i><?php echo lang('home'); ?></a></li>
                    <li class="breadcrumb-item active"><?php echo lang('bookings'); ?></li>
                </ol>
            </nav>
            <hr>
        </div>

        <?php if(empty($bookings)): ?>
        <div class="col-12 empty-state">
            <i class="fas fa-calendar-times"></i>
            <p><?php echo lang('no_bookings'); ?></p>
            <a href="<?php echo SITE_URL; ?>rooms" class="btn custom-bg">
                <i class="fas fa-bed"></i><?php echo lang('browse_rooms'); ?>
            </a>
        </div>
        <?php else: ?>
        <?php foreach($bookings as $data):
            $statusClass = match($data['booking_status']){
                'booked'    => 'status-booked',
                'cancelled' => 'status-cancelled',
                default     => 'status-failed'
            };
            $statusLabel = lang('status_' . $data['booking_status']) ?: $data['booking_status'];
            $btn = '';
            if($data['booking_status']==='booked'){
                if($data['arrival']==1){
                    $btn = "<a href='" . SITE_URL . "booking/pdf?id={$data['booking_id']}' class='btn btn-sm btn-outline-secondary me-2'>
                                <i class='fas fa-file-pdf'></i>" . lang('pdf') . "
                            </a>";
                    if($data['rate_review']==0){
                        $btn .= "<button type='button' onclick='review_room({$data['booking_id']},{$data['room_id']})'
                                    data-bs-toggle='modal' data-bs-target='#reviewModal'
                                    class='btn btn-sm btn-outline-secondary'>
                                    <i class='fas fa-star'></i>" . lang('rate_review') . "
                                 </button>";
                    }
                } else {
                    $btn = "<button type='button' onclick='cancel_booking({$data['booking_id']})'
                                class='btn btn-sm btn-outline-danger'>
                                <i class='fas fa-times'></i>" . lang('cancel') . "
                            </button>";
                }
            } elseif($data['booking_status']==='cancelled'){
                $btn = $data['refund']==0
                    ? "<span class='badge bg-primary'><i class='fas fa-clock'></i>" . lang('refund_process') . "</span>"
                    : "<a href='" . SITE_URL . "booking/pdf?id={$data['booking_id']}' class='btn btn-sm btn-outline-secondary'><i class='fas fa-file-pdf'></i>" . lang('pdf') . "</a>";
            }
        ?>
        <div class="col-md-4 px-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="fw-700 mb-0"><?php echo htmlspecialchars($data['room_name']); ?></h5>
                        <span class="badge <?php echo $statusClass; ?> rounded-pill"><?php echo $statusLabel; ?></span>
                    </div>
                    <p class="text-secondary mb-3" style="font-size:var(--fs-sm);">
                        <i class="fas fa-moon text-primary-custom"></i>
                        <?php echo $data['price']; ?> <?php echo lang('per_night'); ?>
                    </p>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-secondary" style="font-size:var(--fs-sm);">
                                <i class="fas fa-calendar-check"></i><?php echo lang('check_in'); ?>
                            </span>
                            <strong style="font-size:var(--fs-sm);"><?php echo date('d-m-Y', strtotime($data['check_in'])); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-secondary" style="font-size:var(--fs-sm);">
                                <i class="fas fa-calendar-times"></i><?php echo lang('check_out'); ?>
                            </span>
                            <strong style="font-size:var(--fs-sm);"><?php echo date('d-m-Y', strtotime($data['check_out'])); ?></strong>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-secondary" style="font-size:var(--fs-sm);">
                                <i class="fas fa-dollar-sign"></i><?php echo lang('amount'); ?>
                            </span>
                            <strong style="font-size:var(--fs-sm);"><?php echo $data['total_pay']; ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-secondary" style="font-size:var(--fs-sm);">
                                <i class="fas fa-hashtag"></i><?php echo lang('order_id'); ?>
                            </span>
                            <strong style="font-size:var(--fs-sm);"><?php echo htmlspecialchars($data['order_id']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-secondary" style="font-size:var(--fs-sm);">
                                <i class="fas fa-clock"></i><?php echo lang('date'); ?>
                            </span>
                            <strong style="font-size:var(--fs-sm);"><?php echo date('d-m-Y', strtotime($data['datentime'])); ?></strong>
                        </div>
                    </div>
                    <div class="mt-3"><?php echo $btn; ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if($totalPages > 1): ?>
        <div class="col-12 px-4 mt-2 mb-4">
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for($i=1; $i<=$totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i==$page)?'active':''; ?>">
                        <a class="page-link" href="<?php echo SITE_URL; ?>bookings?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="review-form">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-star text-primary-custom"></i><?php echo lang('rate_review'); ?>
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-star"></i><?php echo lang('rating'); ?></label>
                        <select class="form-select" name="rating">
                            <option value="5"><?php echo lang('rating_excellent'); ?></option>
                            <option value="4"><?php echo lang('rating_good'); ?></option>
                            <option value="3"><?php echo lang('rating_ok'); ?></option>
                            <option value="2"><?php echo lang('rating_poor'); ?></option>
                            <option value="1"><?php echo lang('rating_bad'); ?></option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-comment"></i><?php echo lang('review'); ?></label>
                        <textarea required name="review" rows="3" class="form-control"></textarea>
                    </div>
                    <input type="hidden" name="booking_id">
                    <input type="hidden" name="room_id">
                    <div class="text-end">
                        <button type="submit" class="btn custom-bg">
                            <i class="fas fa-paper-plane"></i><?php echo lang('submit'); ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<script>
const LANG = {
    confirm_cancel: '<?php echo lang('confirm_cancel'); ?>',
    cancel_failed:  '<?php echo lang('cancel_failed'); ?>',
    review_failed:  '<?php echo lang('review_failed'); ?>',
};

function cancel_booking(id){
    if(!confirm(LANG.confirm_cancel)) return;
    const data = new FormData();
    data.append('cancel_booking','');
    data.append('id', id);
    fetch(APP.siteUrl + 'api/booking/cancel', {method:'POST', body:data})
        .then(r=>r.text())
        .then(r=>{ if(r==1) window.location.reload(); else alert('error', LANG.cancel_failed); });
}

const reviewForm = document.getElementById('review-form');
function review_room(bid, rid){
    reviewForm.elements['booking_id'].value = bid;
    reviewForm.elements['room_id'].value = rid;
}
reviewForm.addEventListener('submit', function(e){
    e.preventDefault();
    const data = new FormData(this);
    data.append('review_form','');
    fetch(APP.siteUrl + 'api/booking/review', {method:'POST', body:data})
        .then(r=>r.text())
        .then(r=>{
            if(r==1){ window.location.reload(); }
            else{
                bootstrap.Modal.getInstance(document.getElementById('reviewModal'))?.hide();
                alert('error', LANG.review_failed);
            }
        });
});
</script>
