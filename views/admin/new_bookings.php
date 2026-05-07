<?php $pageTitle = 'New Bookings'; ?>

<?php if(!empty($flash)): ?>
<div class="alert alert-success alert-dismissible fade show mb-4">
    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($flash); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Search -->
<form method="GET" action="<?php echo SITE_URL; ?>admin/bookings/new" class="mb-4">
    <div class="admin-search">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
               class="form-control" placeholder="Search order, name, phone…">
    </div>
</form>

<!-- Assign Room Modal -->
<div class="modal fade" id="assignModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo SITE_URL; ?>admin/bookings/assign">
                <div class="modal-header">
                    <h5 class="modal-title fw-700">
                        <i class="fas fa-check-square text-primary-custom"></i> Assign Room Number
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label"><i class="fas fa-door-open"></i> Room Number</label>
                    <input type="text" name="room_no" class="form-control" placeholder="e.g. 101" required>
                    <input type="hidden" name="booking_id" id="assignBookingId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn custom-bg">
                        <i class="fas fa-check"></i> Confirm Arrival
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
                <th>Guest / Order</th>
                <th>Room</th>
                <th>Dates & Amount</th>
                <th>Booked On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($bookings)): ?>
        <tr><td colspan="5" class="text-center text-secondary py-4">
            <i class="fas fa-calendar-check fa-2x mb-2 d-block text-primary-custom"></i>
            No new bookings
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
                <small class="text-secondary"><?php echo $b['price']; ?>/night</small>
            </td>
            <td>
                <small>In: <?php echo date('d-m-Y', strtotime($b['check_in'])); ?></small><br>
                <small>Out: <?php echo date('d-m-Y', strtotime($b['check_out'])); ?></small><br>
                <strong><?php echo $b['total_pay']; ?></strong>
            </td>
            <td><small class="text-secondary"><?php echo date('d-m-Y', strtotime($b['datentime'])); ?></small></td>
            <td>
                <button onclick="document.getElementById('assignBookingId').value=<?php echo $b['booking_id']; ?>"
                        class="btn btn-sm custom-bg mb-1"
                        data-bs-toggle="modal" data-bs-target="#assignModal">
                    <i class="fas fa-check-square"></i> Assign
                </button>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/bookings/cancel"
                      onsubmit="return confirm('Cancel this booking?')" class="d-inline">
                    <input type="hidden" name="booking_id" value="<?php echo $b['booking_id']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
// Pre-fill booking_id when modal opens
document.getElementById('assignModal')?.addEventListener('show.bs.modal', function(){});
</script>
