<?php $pageTitle = lang('admin_carousel'); ?>

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

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <h6 class="fw-700 mb-3">
            <i class="fas fa-upload text-primary-custom"></i> <?php echo lang('admin_add_image_btn'); ?>
        </h6>
        <form method="POST" action="<?php echo SITE_URL; ?>admin/carousel/add" enctype="multipart/form-data">
            <div class="d-flex gap-3 align-items-end">
                <div class="flex-fill">
                    <input type="file" name="picture" accept=".jpg,.png,.webp,.jpeg" class="form-control" required>
                </div>
                <button type="submit" class="btn custom-bg flex-shrink-0">
                    <i class="fas fa-upload"></i> <?php echo lang('admin_upload'); ?>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3">
<?php if(empty($images)): ?>
<div class="col-12 empty-state">
    <i class="fas fa-images"></i>
    <p><?php echo lang('admin_no_carousel'); ?></p>
</div>
<?php else: ?>
<?php foreach($images as $img): ?>
<div class="col-md-4 col-sm-6">
    <div class="card border-0 shadow-sm overflow-hidden">
        <img src="<?php echo CAROUSEL_IMG_PATH . htmlspecialchars($img['image']); ?>"
             class="w-100" style="height:180px; object-fit:cover;" loading="lazy">
        <div class="card-body p-2 text-center">
            <form method="POST" action="<?php echo SITE_URL; ?>admin/carousel/remove"
                  onsubmit="return confirm('<?php echo lang('admin_confirm_del_img_c'); ?>')">
                <input type="hidden" name="id" value="<?php echo $img['sr_no']; ?>">
                <button type="submit" class="btn btn-sm btn-danger w-100">
                    <i class="fas fa-trash"></i> <?php echo lang('admin_delete'); ?>
                </button>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
