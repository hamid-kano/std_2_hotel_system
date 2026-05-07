<?php $pageTitle = 'Features & Facilities'; ?>

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

    <!-- Features -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-700 mb-0">
                        <i class="fas fa-list text-primary-custom"></i> Features
                    </h6>
                    <button class="btn btn-sm custom-bg" data-bs-toggle="modal" data-bs-target="#addFeatureModal">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>
                <table class="table table-sm">
                    <thead><tr><th>#</th><th>Name</th><th></th></tr></thead>
                    <tbody>
                    <?php if(empty($features)): ?>
                    <tr><td colspan="3" class="text-center text-secondary">No features yet</td></tr>
                    <?php else: ?>
                    <?php foreach($features as $i => $f): ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><?php echo htmlspecialchars($f['name']); ?></td>
                        <td>
                            <form method="POST" action="<?php echo SITE_URL; ?>admin/features/remove"
                                  onsubmit="return confirm('Delete this feature?')">
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

    <!-- Facilities -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-700 mb-0">
                        <i class="fas fa-concierge-bell text-primary-custom"></i> Facilities
                    </h6>
                    <button class="btn btn-sm custom-bg" data-bs-toggle="modal" data-bs-target="#addFacilityModal">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>
                <table class="table table-sm">
                    <thead><tr><th>#</th><th>Icon</th><th>Name</th><th>Desc</th><th></th></tr></thead>
                    <tbody>
                    <?php if(empty($facilities)): ?>
                    <tr><td colspan="5" class="text-center text-secondary">No facilities yet</td></tr>
                    <?php else: ?>
                    <?php foreach($facilities as $i => $f): ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><img src="<?php echo FACILITIES_IMG_PATH . htmlspecialchars($f['icon']); ?>" width="40" style="object-fit:contain;"></td>
                        <td><?php echo htmlspecialchars($f['name']); ?></td>
                        <td><small class="text-secondary"><?php echo htmlspecialchars($f['description'] ?? ''); ?></small></td>
                        <td>
                            <form method="POST" action="<?php echo SITE_URL; ?>admin/facilities/remove"
                                  onsubmit="return confirm('Delete this facility?')">
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
                    <h5 class="modal-title fw-700">Add Feature</h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Feature Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn custom-bg">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Facility Modal -->
<div class="modal fade" id="addFacilityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo SITE_URL; ?>admin/facilities/add" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title fw-700">Add Facility</h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="desc" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (SVG/PNG)</label>
                        <input type="file" name="icon" accept=".svg,.png" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn custom-bg">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
