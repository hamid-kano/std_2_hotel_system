<?php $pageTitle = 'User Queries'; ?>

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
                <th>Name / Email</th><th>Subject</th><th>Message</th><th>Date</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($queries)): ?>
        <tr><td colspan="5" class="text-center text-secondary py-4">No queries yet</td></tr>
        <?php else: ?>
        <?php foreach($queries as $q): ?>
        <tr>
            <td>
                <strong><?php echo htmlspecialchars($q['name']); ?></strong>
                <?php if(!$q['seen']): ?>
                <span class="badge bg-danger ms-1" style="font-size:var(--fs-xs);">New</span>
                <?php endif; ?>
                <br>
                <small class="text-secondary"><?php echo htmlspecialchars($q['email']); ?></small>
            </td>
            <td><?php echo htmlspecialchars($q['subject']); ?></td>
            <td><small><?php echo htmlspecialchars($q['message']); ?></small></td>
            <td><small class="text-secondary"><?php echo date('d-m-Y', strtotime($q['datentime'] ?? 'now')); ?></small></td>
            <td>
                <?php if(!$q['seen']): ?>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/queries/seen">
                    <input type="hidden" name="id" value="<?php echo $q['sr_no']; ?>">
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
