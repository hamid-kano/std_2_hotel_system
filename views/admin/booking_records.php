<?php $pageTitle = 'Booking Records'; ?>

<form method="GET" action="<?php echo SITE_URL; ?>admin/bookings/records" class="mb-4 d-flex gap-2">
    <div class="admin-search">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
               class="form-control" placeholder="Search order, name, phone…">
    </div>
    <button type="submit" class="btn btn-outline-secondary">
        <i class="fas fa-search"></i>
    </button>
</form>

<div class="admin-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Guest / Order</th>
                <th>Room</th>
                <th>Amount & Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($bookings)): ?>
        <tr><td colspan="4" class="text-center text-secondary py-4">No records found</td></tr>
        <?php else: ?>
        <?php foreach($bookings as $b):
            $statusClass = match($b['booking_status']){
                'booked'    => 'status-booked',
                'cancelled' => 'status-cancelled',
                default     => 'status-failed'
            };
        ?>
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
                <strong><?php echo $b['total_pay']; ?></strong><br>
                <small class="text-secondary"><?php echo date('d-m-Y', strtotime($b['datentime'])); ?></small>
            </td>
            <td>
                <span class="badge <?php echo $statusClass; ?> rounded-pill px-3">
                    <?php echo $b['booking_status']; ?>
                </span>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<?php if($totalPages > 1): ?>
<nav class="mt-4">
    <ul class="pagination justify-content-center">
        <?php for($i=1; $i<=$totalPages; $i++): ?>
        <li class="page-item <?php echo ($i==$page)?'active':''; ?>">
            <a class="page-link" href="<?php echo SITE_URL; ?>admin/bookings/records?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                <?php echo $i; ?>
            </a>
        </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>
