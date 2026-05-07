<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label"><?php echo lang('admin_room_name'); ?></label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label"><?php echo lang('admin_area'); ?></label>
        <input type="number" min="1" name="area" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label"><?php echo lang('admin_price_night'); ?></label>
        <input type="number" min="1" name="price" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label"><?php echo lang('admin_quantity'); ?></label>
        <input type="number" min="1" name="quantity" class="form-control" required>
    </div>
    <div class="col-md-2">
        <label class="form-label"><?php echo lang('admin_adults_col'); ?></label>
        <input type="number" min="1" name="adult" class="form-control" required>
    </div>
    <div class="col-md-2">
        <label class="form-label"><?php echo lang('admin_children_col'); ?></label>
        <input type="number" min="0" name="children" class="form-control" required>
    </div>
    <div class="col-12">
        <label class="form-label"><?php echo lang('description'); ?></label>
        <textarea name="desc" rows="3" class="form-control" required></textarea>
    </div>
    <div class="col-12">
        <label class="form-label fw-600"><?php echo lang('features'); ?></label>
        <div class="row g-2">
            <?php foreach($features as $f): ?>
            <div class="col-md-3">
                <label class="d-flex align-items-center gap-2" style="font-size:var(--fs-sm); cursor:pointer;">
                    <input type="checkbox" name="features" value="<?php echo $f['id']; ?>" class="form-check-input">
                    <?php echo htmlspecialchars($f['name']); ?>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-12">
        <label class="form-label fw-600"><?php echo lang('facilities'); ?></label>
        <div class="row g-2">
            <?php foreach($facilities as $f): ?>
            <div class="col-md-3">
                <label class="d-flex align-items-center gap-2" style="font-size:var(--fs-sm); cursor:pointer;">
                    <input type="checkbox" name="facilities" value="<?php echo $f['id']; ?>" class="form-check-input">
                    <?php echo htmlspecialchars($f['name']); ?>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
