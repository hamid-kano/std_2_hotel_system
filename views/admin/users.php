<?php $pageTitle = lang('admin_users'); ?>

<?php if(!empty($flash)): ?>
<div class="alert alert-success alert-dismissible fade show mb-4">
    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($flash); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<form method="GET" action="<?php echo SITE_URL; ?>admin/users" class="mb-4 d-flex gap-2">
    <div class="admin-search">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
               class="form-control" placeholder="<?php echo lang('search'); ?>…">
    </div>
    <button type="submit" class="btn btn-outline-secondary">
        <i class="fas fa-search"></i>
    </button>
</form>

<div class="admin-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo lang('name'); ?></th>
                <th><?php echo lang('email'); ?></th>
                <th><?php echo lang('phone'); ?></th>
                <th><?php echo lang('address'); ?></th>
                <th><?php echo lang('admin_joined'); ?></th>
                <th><?php echo lang('admin_status_col'); ?></th>
                <th><?php echo lang('admin_actions'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($users)): ?>
        <tr><td colspan="8" class="text-center text-secondary py-4"><?php echo lang('admin_no_users'); ?></td></tr>
        <?php else: ?>
        <?php foreach($users as $i => $u): ?>
        <tr>
            <td><?php echo ($page-1)*20 + $i + 1; ?></td>
            <td><strong><?php echo htmlspecialchars($u['name']); ?></strong></td>
            <td><small><?php echo htmlspecialchars($u['email']); ?></small></td>
            <td><?php echo htmlspecialchars($u['phonenum']); ?></td>
            <td><small class="text-secondary"><?php echo htmlspecialchars($u['address']); ?></small></td>
            <td><small class="text-secondary"><?php echo date('d-m-Y', strtotime($u['datentime'])); ?></small></td>
            <td>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/users/toggle" class="d-inline">
                    <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                    <input type="hidden" name="status" value="<?php echo $u['status']==1?0:1; ?>">
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <input type="hidden" name="page" value="<?php echo $page; ?>">
                    <button type="submit" class="btn btn-sm <?php echo $u['status']==1?'btn-success':'btn-danger'; ?>">
                        <?php echo $u['status']==1 ? lang('admin_status_active') : lang('admin_status_inactive'); ?>
                    </button>
                </form>
            </td>
            <td>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/users/remove"
                      class="d-inline" onsubmit="return confirm('<?php echo lang('admin_confirm_del_user'); ?>')">
                    <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if($totalPages > 1): ?>
<nav class="mt-4">
    <ul class="pagination justify-content-center">
        <?php for($i=1; $i<=$totalPages; $i++): ?>
        <li class="page-item <?php echo ($i==$page)?'active':''; ?>">
            <a class="page-link" href="<?php echo SITE_URL; ?>admin/users?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                <?php echo $i; ?>
            </a>
        </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>
