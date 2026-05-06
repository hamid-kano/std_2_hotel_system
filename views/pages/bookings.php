<?php $pageTitle = APP_NAME . ' — ' . lang('bookings'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5 px-4">
            <h2 class="fw-bold">
                <i class="fas fa-calendar-check me-2" style="color:var(--teal);"></i><?php echo lang('bookings'); ?>
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-decoration-none"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="breadcrumb-item active">Bookings</li>
                </ol>
            </nav>
            <hr>
        </div>

        <?php if(empty($bookings)): ?>
        <div class="col-12 empty-state">
            <i class="fas fa-calendar-times"></i>
            <p>No bookings found.</p>
            <a href="<?php echo SITE_URL; ?>rooms" class="btn custom-bg text-white shadow-none">
                <i class="fas fa-bed me-2"></i>Browse Rooms
            </a>
        </div>
        <?php else: ?>
        <?php foreach($bookings as $data): ?>
        <?php
            $statusBg = match($data['booking_status']){
                'booked'    => 'bg-success',
                'cancelled' => 'bg-danger',
                default     => 'bg-warning text-dark'
            };
            $btn = '';
            if($data['booking_status']==='booked'){
                if($data['arrival']==1){
                    $btn = "<a href='" . SITE_URL . "booking/pdf?id={$data['booking_id']}' class='btn btn-sm btn-dark shadow-none me-2'>
                                <i class='fas fa-file-pdf me-1'></i>PDF
                            </a>";
                    if($data['rate_review']==0){
                        $btn .= "<button type='button' onclick='review_room({$data['booking_id']},{$data['room_id']})'
                                    data-bs-toggle='modal' data-bs-target='#reviewModal'
                                    class='btn btn-sm btn-dark shadow-none'>
                                    <i class='fas fa-star me-1'></i>Rate & Review
                                 </button>";
                    }
                } else {
                    $btn = "<button type='button' onclick='cancel_booking({$data['booking_id']})'
                                class='btn btn-sm btn-danger shadow-none'>
                                <i class='fas fa-times me-1'></i>Cancel
                            </button>";
                }
            } elseif($data['booking_status']==='cancelled'){
                $btn = $data['refund']==0
                    ? "<span class='badge bg-primary'><i class='fas fa-clock me-1'></i>Refund in Process</span>"
                    : "<a href='" . SITE_URL . "booking/pdf?id={$data['booking_id']}' class='btn btn-sm btn-dark shadow-none'><i class='fas fa-file-pdf me-1'></i>PDF</a>";
            }
        ?>
        <div class="col-md-4 px-4 mb-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($data['room_name']); ?></h5>
                        <span class="badge <?php echo $statusBg; ?>">
                            <?php echo $data['booking_status']; ?>
                        </span>
                    </div>
                    <p class="text-muted small mb-3">
                        <i class="fas fa-moon me-1"></i><?php echo $data['price']; ?> per night
                    </p>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small"><i class="fas fa-calendar-check me-1"></i>Check-in</span>
                            <strong class="small"><?php echo date('d-m-Y', strtotime($data['check_in'])); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small"><i class="fas fa-calendar-times me-1"></i>Check-out</span>
                            <strong class="small"><?php echo date('d-m-Y', strtotime($data['check_out'])); ?></strong>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small"><i class="fas fa-dollar-sign me-1"></i>Amount</span>
                            <strong class="small"><?php echo $data['total_pay']; ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small"><i class="fas fa-hashtag me-1"></i>Order ID</span>
                            <strong class="small"><?php echo htmlspecialchars($data['order_id']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small"><i class="fas fa-clock me-1"></i>Date</span>
                            <strong class="small"><?php echo date('d-m-Y', strtotime($data['datentime'])); ?></strong>
                        </div>
                    </div>
                    <div class="mt-3"><?php echo $btn; ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Pagination -->
        <?php if($totalPages > 1): ?>
        <div class="col-12 px-4 mt-2 mb-4">
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for($i=1; $i<=$totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i==$page)?'active':''; ?>">
                        <a class="page-link shadow-none" href="<?php echo SITE_URL; ?>bookings?page=<?php echo $i; ?>"><?php echo $i; ?></a>
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
                        <i class="fas fa-star me-2" style="color:var(--teal);"></i>Rate & Review
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-star me-1"></i>Rating</label>
                        <select class="form-select shadow-none" name="rating">
                            <option value="5"><i class="fas fa-star"></i> Excellent</option>
                            <option value="4">Good</option>
                            <option value="3">Ok</option>
                            <option value="2">Poor</option>
                            <option value="1">Bad</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-comment me-1"></i>Review</label>
                        <textarea required name="review" rows="3" class="form-control shadow-none"></textarea>
                    </div>
                    <input type="hidden" name="booking_id">
                    <input type="hidden" name="room_id">
                    <div class="text-end">
                        <button type="submit" class="btn custom-bg text-white shadow-none">
                            <i class="fas fa-paper-plane me-1"></i>Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<script>
function cancel_booking(id){
    if(!confirm('Are you sure to cancel this booking?')) return;
    const data = new FormData();
    data.append('cancel_booking','');
    data.append('id', id);
    fetch(APP.siteUrl + 'api/booking/cancel', {method:'POST', body:data})
        .then(r=>r.text())
        .then(r=>{ if(r==1) window.location.reload(); else alert('error','Cancellation failed!'); });
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
                alert('error','Review failed!');
            }
        });
});
</script>
