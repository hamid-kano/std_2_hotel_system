<?php $pageTitle = 'Refund Bookings'; ?>

<?php if(!empty($flash)): ?>
<div class="alert alert-success alert-dismissible fade show mb-4">
    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($flash); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<form method="GET" action="<?php echo SITE_URL; ?>admin/bookings/refunds" class="mb-4">
    <div class="admin-search">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
               class="form-control" placeholder="Search order, name, phone…">
    </div>
</form>

<div class="admin-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Guest / Order</th>
                <th>Room & Dates</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($bookings)): ?>
        <tr><td colspan="5" class="text-center text-secondary py-4">
            <i class="fas fa-undo fa-2x mb-2 d-block text-primary-custom"></i>
            No pending refunds
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
                <small>In: <?php echo date('d-m-Y', strtotime($b['check_in'])); ?></small><br>
                <small>Out: <?php echo date('d-m-Y', strtotime($b['check_out'])); ?></small>
            </td>
            <td><strong><?php echo $b['total_pay']; ?></strong></td>
            <td><small class="text-secondary"><?php echo date('d-m-Y', strtotime($b['datentime'])); ?></small></td>
            <td>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/bookings/refund"
                      onsubmit="return confirm('Process refund for this booking?')">
                    <input type="hidden" name="booking_id" value="<?php echo $b['booking_id']; ?>">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fas fa-undo"></i> Refund
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
