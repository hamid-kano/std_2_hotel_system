<?php $pageTitle = lang('admin_features_fac'); ?>

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

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-700 mb-0">
                        <i class="fas fa-list text-primary-custom"></i> <?php echo lang('admin_features'); ?>
                    </h6>
                    <button class="btn btn-sm custom-bg" data-bs-toggle="modal" data-bs-target="#addFeatureModal">
                        <i class="fas fa-plus"></i> <?php echo lang('admin_add_feature'); ?>
                    </button>
                </div>
                <table class="table table-sm table-hover admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo lang('name'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($features)): ?>
                    <tr><td colspan="3" class="text-center text-secondary"><?php echo lang('admin_no_features'); ?></td></tr>
                    <?php else: ?>
                    <?php foreach($features as $i => $f): ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><?php echo htmlspecialchars(getTranslation('features_translations', $f['id'], 'name', $f['name'])); ?></td>
                        <td>
                            <form method="POST" action="<?php echo SITE_URL; ?>admin/features/remove"
                                  onsubmit="return confirm('<?php echo lang('admin_confirm_del_feat'); ?>')">
                                <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
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
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-700 mb-0">
                        <i class="fas fa-concierge-bell text-primary-custom"></i> <?php echo lang('admin_facilities_col'); ?>
                    </h6>
                    <button class="btn btn-sm custom-bg" data-bs-toggle="modal" data-bs-target="#addFacilityModal">
                        <i class="fas fa-plus"></i> <?php echo lang('admin_add_facility'); ?>
                    </button>
                </div>
                <table class="table table-sm table-hover admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo lang('admin_facility_icon'); ?></th>
                            <th><?php echo lang('admin_facility_name'); ?></th>
                            <th><?php echo lang('admin_facility_desc'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($facilities)): ?>
                    <tr><td colspan="5" class="text-center text-secondary"><?php echo lang('admin_no_facilities'); ?></td></tr>
                    <?php else: ?>
                    <?php foreach($facilities as $i => $f): ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><img src="<?php echo FACILITIES_IMG_PATH . htmlspecialchars($f['icon']); ?>" width="40" style="object-fit:contain;"></td>
                        <td><?php echo htmlspecialchars(getTranslation('facilities_translations', $f['id'], 'name', $f['name'])); ?></td>
                        <td><small class="text-secondary"><?php echo htmlspecialchars(getTranslation('facilities_translations', $f['id'], 'description', $f['description'] ?? '')); ?></small></td>
                        <td>
                            <form method="POST" action="<?php echo SITE_URL; ?>admin/facilities/remove"
                                  onsubmit="return confirm('<?php echo lang('admin_confirm_del_fac'); ?>')">
                                <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
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
        </div>
    </div>
</div>

<!-- Add Feature Modal -->
<div class="modal fade" id="addFeatureModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo SITE_URL; ?>admin/features/add">
                <div class="modal-header">
                    <h5 class="modal-title fw-700"><?php echo lang('admin_add_feature'); ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><?php echo lang('admin_feature_name'); ?> (<?php echo lang('arabic'); ?>)</label>
                        <input type="text" name="name_ar" class="form-control" required placeholder="مثال: واي فاي مجاني">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo lang('admin_feature_name'); ?> (<?php echo lang('english'); ?>)</label>
                        <input type="text" name="name_en" class="form-control" required placeholder="Example: Free WiFi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo lang('admin_feature_name'); ?> (<?php echo lang('kurdish'); ?>)</label>
                        <input type="text" name="name_ku" class="form-control" required placeholder="Mînak: WiFi belaş">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel'); ?></button>
                    <button type="submit" class="btn custom-bg"><?php echo lang('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Facility Modal -->
<div class="modal fade" id="addFacilityModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="<?php echo SITE_URL; ?>admin/facilities/add" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title fw-700"><?php echo lang('admin_add_facility'); ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><?php echo lang('admin_facility_name'); ?> (<?php echo lang('arabic'); ?>)</label>
                            <input type="text" name="name_ar" class="form-control" required placeholder="مثال: مسبح">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><?php echo lang('admin_facility_name'); ?> (<?php echo lang('english'); ?>)</label>
                            <input type="text" name="name_en" class="form-control" required placeholder="Example: Swimming Pool">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><?php echo lang('admin_facility_name'); ?> (<?php echo lang('kurdish'); ?>)</label>
                            <input type="text" name="name_ku" class="form-control" required placeholder="Mînak: Hewza avê">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><?php echo lang('admin_facility_desc'); ?> (<?php echo lang('arabic'); ?>)</label>
                            <textarea name="desc_ar" class="form-control" rows="2" placeholder="وصف المرفق بالعربية"></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><?php echo lang('admin_facility_desc'); ?> (<?php echo lang('english'); ?>)</label>
                            <textarea name="desc_en" class="form-control" rows="2" placeholder="Facility description in English"></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><?php echo lang('admin_facility_desc'); ?> (<?php echo lang('kurdish'); ?>)</label>
                            <textarea name="desc_ku" class="form-control" rows="2" placeholder="Danasîna tesîsê bi Kurmancî"></textarea>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo lang('admin_facility_icon'); ?></label>
                        <input type="file" name="icon" accept=".svg,.png" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel'); ?></button>
                    <button type="submit" class="btn custom-bg"><?php echo lang('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
