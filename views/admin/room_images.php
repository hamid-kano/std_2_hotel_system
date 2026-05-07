<?php $pageTitle = lang('admin_room_images') . ' — ' . htmlspecialchars($room['name']); ?>

<?php if(!empty($flash)): ?>
<div class="alert alert-success alert-dismissible fade show mb-4">
    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($flash); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if(!empty($error)): ?>
<div class="alert alert-danger alert-dismissible fade show mb-4">
    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?php echo SITE_URL; ?>admin/rooms" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> <?php echo lang('admin_back_to_rooms'); ?>
    </a>
    <h5 class="fw-700 mb-0"><?php echo htmlspecialchars($room['name']); ?></h5>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <h6 class="fw-700 mb-3">
            <i class="fas fa-upload text-primary-custom"></i> <?php echo lang('admin_add_image'); ?>
        </h6>
        <form method="POST" action="<?php echo SITE_URL; ?>admin/rooms/<?php echo $room['id']; ?>/images/add"
              enctype="multipart/form-data" class="d-flex gap-3 align-items-end">
            <div class="flex-fill">
                <input type="file" name="image" accept=".jpg,.png,.webp,.jpeg" class="form-control" required>
            </div>
            <button type="submit" class="btn custom-bg flex-shrink-0">
                <i class="fas fa-upload"></i> <?php echo lang('admin_upload'); ?>
            </button>
        </form>
    </div>
</div>

<div class="row g-3">
<?php if(empty($images)): ?>
<div class="col-12 empty-state">
    <i class="fas fa-images"></i>
    <p><?php echo lang('admin_no_images'); ?></p>
</div>
<?php else: ?>
<?php foreach($images as $img): ?>
<div class="col-md-3 col-sm-4 col-6">
    <div class="card border-0 shadow-sm overflow-hidden">
        <img src="<?php echo ROOMS_IMG_PATH . htmlspecialchars($img['image']); ?>"
             class="w-100" style="height:160px; object-fit:cover;" loading="lazy">
        <div class="card-body p-2 d-flex gap-2">
            <?php if($img['thumb']): ?>
            <span class="badge bg-success flex-fill text-center py-2">
                <i class="fas fa-check"></i> <?php echo lang('admin_thumbnail'); ?>
            </span>
            <?php else: ?>
            <form method="POST" action="<?php echo SITE_URL; ?>admin/rooms/<?php echo $room['id']; ?>/images/thumb" class="flex-fill">
                <input type="hidden" name="image_id" value="<?php echo $img['sr_no']; ?>">
                <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="fas fa-image"></i> <?php echo lang('admin_set_thumb'); ?>
                </button>
            </form>
            <?php endif; ?>
            <form method="POST" action="<?php echo SITE_URL; ?>admin/rooms/<?php echo $room['id']; ?>/images/remove"
                  onsubmit="return confirm('<?php echo lang('admin_confirm_del_img'); ?>')">
                <input type="hidden" name="image_id" value="<?php echo $img['sr_no']; ?>">
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
