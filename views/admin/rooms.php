<?php $pageTitle = lang('rooms'); ?>

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

<div class="d-flex justify-content-end mb-4">
    <button class="btn custom-bg" data-bs-toggle="modal" data-bs-target="#addRoomModal">
        <i class="fas fa-plus"></i> <?php echo lang('admin_add_room'); ?>
    </button>
</div>

<div class="admin-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo lang('admin_room_name'); ?></th>
                <th><?php echo lang('admin_area'); ?></th>
                <th><?php echo lang('admin_guests_col'); ?></th>
                <th><?php echo lang('admin_price_col'); ?></th>
                <th><?php echo lang('admin_qty_col'); ?></th>
                <th><?php echo lang('admin_status_col'); ?></th>
                <th><?php echo lang('admin_actions'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($rooms)): ?>
        <tr><td colspan="8" class="text-center text-secondary py-4"><?php echo lang('admin_no_rooms'); ?></td></tr>
        <?php else: ?>
        <?php foreach($rooms as $i => $r): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($r['name']); ?></strong></td>
            <td><?php echo $r['area']; ?> m²</td>
            <td>
                <small><?php echo $r['adult']; ?> <?php echo lang('admin_adults_col'); ?> /
                <?php echo $r['children']; ?> <?php echo lang('admin_children_col'); ?></small>
            </td>
            <td><?php echo $r['price']; ?></td>
            <td><?php echo $r['quantity']; ?></td>
            <td>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/rooms/toggle" class="d-inline">
                    <input type="hidden" name="room_id" value="<?php echo $r['id']; ?>">
                    <input type="hidden" name="status" value="<?php echo $r['status']==1?0:1; ?>">
                    <button type="submit" class="btn btn-sm <?php echo $r['status']==1?'btn-success':'btn-warning'; ?>">
                        <?php echo $r['status']==1 ? lang('admin_status_active') : lang('admin_status_inactive'); ?>
                    </button>
                </form>
            </td>
            <td>
                <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($r)); ?>,
                    <?php echo htmlspecialchars(json_encode(Room::getFeatures($r['id']))); ?>,
                    <?php echo htmlspecialchars(json_encode(Room::getFacilities($r['id']))); ?>)"
                        class="btn btn-sm btn-primary me-1"
                        data-bs-toggle="modal" data-bs-target="#editRoomModal">
                    <i class="fas fa-edit"></i>
                </button>
                <a href="<?php echo SITE_URL; ?>admin/rooms/<?php echo $r['id']; ?>/images"
                   class="btn btn-sm btn-info me-1">
                    <i class="fas fa-images"></i>
                </a>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/rooms/remove"
                      class="d-inline" onsubmit="return confirm('<?php echo lang('admin_confirm_remove_room'); ?>')">
                    <input type="hidden" name="room_id" value="<?php echo $r['id']; ?>">
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

<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="<?php echo SITE_URL; ?>admin/rooms/add" id="addRoomForm">
                <div class="modal-header">
                    <h5 class="modal-title fw-700">
                        <i class="fas fa-plus text-primary-custom"></i> <?php echo lang('admin_add_room'); ?>
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php include BASE_PATH . '/views/admin/partials/room_form.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel'); ?></button>
                    <button type="submit" class="btn custom-bg"><?php echo lang('admin_add_room'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Room Modal -->
<div class="modal fade" id="editRoomModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="<?php echo SITE_URL; ?>admin/rooms/edit" id="editRoomForm">
                <div class="modal-header">
                    <h5 class="modal-title fw-700">
                        <i class="fas fa-edit text-primary-custom"></i> <?php echo lang('admin_edit_room'); ?>
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php include BASE_PATH . '/views/admin/partials/room_form.php'; ?>
                    <input type="hidden" name="room_id" id="editRoomId">
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel'); ?></button>
                    <button type="submit" class="btn custom-bg"><?php echo lang('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(room, features, facilities) {
    const f = document.getElementById('editRoomForm');
    f.elements['name'].value     = room.name;
    f.elements['area'].value     = room.area;
    f.elements['price'].value    = room.price;
    f.elements['quantity'].value = room.quantity;
    f.elements['adult'].value    = room.adult;
    f.elements['children'].value = room.children;
    f.elements['desc'].value     = room.description;
    document.getElementById('editRoomId').value = room.id;
    const featIds = features.map(f => String(f.id));
    const facIds  = facilities.map(f => String(f.id));
    f.querySelectorAll('[name="features"]').forEach(cb => cb.checked = featIds.includes(cb.value));
    f.querySelectorAll('[name="facilities"]').forEach(cb => cb.checked = facIds.includes(cb.value));
}
['addRoomForm','editRoomForm'].forEach(id => {
    document.getElementById(id)?.addEventListener('submit', function(){
        const feats = [...this.querySelectorAll('[name="features"]:checked')].map(c=>c.value);
        const facs  = [...this.querySelectorAll('[name="facilities"]:checked')].map(c=>c.value);
        let fi = this.querySelector('input[name="features_json"]');
        if(!fi){ fi = document.createElement('input'); fi.type='hidden'; fi.name='features'; this.appendChild(fi); }
        let faci = this.querySelector('input[name="facilities_json"]');
        if(!faci){ faci = document.createElement('input'); faci.type='hidden'; faci.name='facilities'; this.appendChild(faci); }
        fi.value   = JSON.stringify(feats);
        faci.value = JSON.stringify(facs);
        this.querySelectorAll('[name="features"],[name="facilities"]').forEach(c => c.disabled=true);
    });
});
</script>
