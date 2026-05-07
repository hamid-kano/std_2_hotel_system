<?php $pageTitle = lang('admin_new_bookings'); ?>

<?php if(!empty($flash)): ?>
<div class="alert alert-success alert-dismissible fade show mb-4">
    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($flash); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<form method="GET" action="<?php echo SITE_URL; ?>admin/bookings/new" class="mb-4">
    <div class="admin-search">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
               class="form-control" placeholder="<?php echo lang('search'); ?>…">
    </div>
</form>

<!-- Assign Modal -->
<div class="modal fade" id="assignModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo SITE_URL; ?>admin/bookings/assign">
                <div class="modal-header">
                    <h5 class="modal-title fw-700">
                        <i class="fas fa-check-square text-primary-custom"></i>
                        <?php echo lang('admin_assign_room'); ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">
                        <i class="fas fa-door-open"></i> <?php echo lang('admin_room_number'); ?>
                    </label>
                    <input type="text" name="room_no" class="form-control" required>
                    <input type="hidden" name="booking_id" id="assignBookingId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <?php echo lang('cancel'); ?>
                    </button>
                    <button type="submit" class="btn custom-bg">
                        <i class="fas fa-check"></i> <?php echo lang('admin_confirm_arrival'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="admin-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th><?php echo lang('admin_guest_order'); ?></th>
                <th><?php echo lang('admin_room_col'); ?></th>
                <th><?php echo lang('admin_dates_amount'); ?></th>
                <th><?php echo lang('admin_booked_on'); ?></th>
                <th><?php echo lang('admin_actions'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($bookings)): ?>
        <tr><td colspan="5" class="text-center text-secondary py-4">
            <i class="fas fa-calendar-check fa-2x mb-2 d-block text-primary-custom"></i>
            <?php echo lang('admin_no_new_bookings'); ?>
        </td></tr>
        <?php else: ?>
        <?php foreach($bookings as $b): ?>
        <tr>
            <td>
                <span class="badge bg-primary"><?php echo htmlspecialchars($b['order_id']); ?></span><br>
                <strong><?php echo htmlspecialchars($b['user_name']); ?></strong><br>
                <small class="text-secondary"><?php echo htmlspecialchars($b['phonenum']); ?></small>
            </td>
            <td>
                <strong><?php echo htmlspecialchars($b['room_name']); ?></strong><br>
                <small class="text-secondary"><?php echo $b['price']; ?>/<?php echo lang('per_night'); ?></small>
            </td>
            <td>
                <small><?php echo lang('check_in'); ?>: <?php echo date('d-m-Y', strtotime($b['check_in'])); ?></small><br>
                <small><?php echo lang('check_out'); ?>: <?php echo date('d-m-Y', strtotime($b['check_out'])); ?></small><br>
                <strong><?php echo $b['total_pay']; ?></strong>
            </td>
            <td><small class="text-secondary"><?php echo date('d-m-Y', strtotime($b['datentime'])); ?></small></td>
            <td>
                <button onclick="document.getElementById('assignBookingId').value=<?php echo $b['booking_id']; ?>"
                        class="btn btn-sm custom-bg mb-1"
                        data-bs-toggle="modal" data-bs-target="#assignModal">
                    <i class="fas fa-check-square"></i> <?php echo lang('admin_assign'); ?>
                </button>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/bookings/cancel"
                      onsubmit="return confirm('<?php echo lang('admin_confirm_cancel_bk'); ?>')" class="d-inline">
                    <input type="hidden" name="booking_id" value="<?php echo $b['booking_id']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-times"></i> <?php echo lang('admin_cancel_booking'); ?>
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
