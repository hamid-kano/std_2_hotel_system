<?php $pageTitle = 'Reviews & Ratings'; ?>

<?php if(!empty($flash)): ?>
<div class="alert alert-success alert-dismissible fade show mb-4">
    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($flash); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="admin-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Guest</th><th>Rating</th><th>Review</th><th>Date</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($reviews)): ?>
        <tr><td colspan="5" class="text-center text-secondary py-4">No reviews yet</td></tr>
        <?php else: ?>
        <?php foreach($reviews as $r): ?>
        <tr>
            <td>
                <strong><?php echo htmlspecialchars($r['uname']); ?></strong>
                <?php if(!$r['seen']): ?>
                <span class="badge bg-danger ms-1" style="font-size:var(--fs-xs);">New</span>
                <?php endif; ?>
            </td>
            <td>
                <?php for($i=0; $i<(int)$r['rating']; $i++): ?>
                <i class="fas fa-star text-warning"></i>
                <?php endfor; ?>
            </td>
            <td><small><?php echo htmlspecialchars($r['review']); ?></small></td>
            <td><small class="text-secondary"><?php echo date('d-m-Y', strtotime($r['datentime'] ?? 'now')); ?></small></td>
            <td>
                <?php if(!$r['seen']): ?>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/reviews/seen">
                    <input type="hidden" name="id" value="<?php echo $r['sr_no']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-check"></i> Mark Seen
                    </button>
                </form>
                <?php else: ?>
                <span class="text-secondary" style="font-size:var(--fs-xs);">Seen</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
