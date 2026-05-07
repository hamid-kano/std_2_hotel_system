<?php $pageTitle = lang('admin_queries'); ?>

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
                <th><?php echo lang('admin_name_email'); ?></th>
                <th><?php echo lang('admin_subject_col'); ?></th>
                <th><?php echo lang('admin_message_col'); ?></th>
                <th><?php echo lang('admin_date_col'); ?></th>
                <th><?php echo lang('admin_actions'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($queries)): ?>
        <tr><td colspan="5" class="text-center text-secondary py-4"><?php echo lang('admin_no_queries'); ?></td></tr>
        <?php else: ?>
        <?php foreach($queries as $q): ?>
        <tr>
            <td>
                <strong><?php echo htmlspecialchars($q['name']); ?></strong>
                <?php if(!$q['seen']): ?>
                <span class="badge bg-danger ms-1" style="font-size:var(--fs-xs);"><?php echo lang('admin_new_badge'); ?></span>
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
                        <i class="fas fa-check"></i> <?php echo lang('admin_mark_seen'); ?>
                    </button>
                </form>
                <?php else: ?>
                <span class="text-secondary" style="font-size:var(--fs-xs);"><?php echo lang('admin_seen'); ?></span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
