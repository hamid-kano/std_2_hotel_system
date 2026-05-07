<?php $pageTitle = lang('admin_settings'); ?>

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
    <!-- General -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-700 mb-4">
                    <i class="fas fa-cog text-primary-custom"></i> <?php echo lang('admin_general'); ?>
                </h6>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/settings/general">
                    <div class="mb-3">
                        <label class="form-label"><?php echo lang('admin_site_title'); ?></label>
                        <input type="text" name="site_title" class="form-control" required
                               value="<?php echo htmlspecialchars($general['site_title'] ?? ''); ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label"><?php echo lang('admin_site_about'); ?></label>
                        <textarea name="site_about" rows="3" class="form-control"><?php echo htmlspecialchars($general['site_about'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="btn custom-bg">
                        <i class="fas fa-save"></i> <?php echo lang('save_changes'); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Contact -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-700 mb-4">
                    <i class="fas fa-address-book text-primary-custom"></i> <?php echo lang('admin_contact_details'); ?>
                </h6>
                <form method="POST" action="<?php echo SITE_URL; ?>admin/settings/contacts">
                    <div class="row g-3">
                        <?php
                        $fields = [
                            'address' => lang('address_label'),
                            'gmap'    => lang('admin_gmap_link'),
                            'pn1'     => lang('admin_phone1'),
                            'pn2'     => lang('admin_phone2'),
                            'email'   => lang('email_label'),
                            'fb'      => lang('admin_facebook'),
                            'insta'   => lang('admin_instagram'),
                            'tw'      => lang('admin_twitter'),
                            'iframe'  => lang('admin_iframe_src'),
                        ];
                        foreach($fields as $key => $label):
                            $cols = in_array($key, ['address','gmap','iframe']) ? 'col-12' : 'col-6';
                        ?>
                        <div class="<?php echo $cols; ?>">
                            <label class="form-label"><?php echo $label; ?></label>
                            <input type="text" name="<?php echo $key; ?>" class="form-control"
                                   value="<?php echo htmlspecialchars($contacts[$key] ?? ''); ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn custom-bg">
                            <i class="fas fa-save"></i> <?php echo lang('save_changes'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Team Members -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-700 mb-0">
                        <i class="fas fa-users text-primary-custom"></i> <?php echo lang('admin_mgmt_team'); ?>
                    </h6>
                    <button class="btn btn-sm custom-bg" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                        <i class="fas fa-plus"></i> <?php echo lang('admin_add_member'); ?>
                    </button>
                </div>
                <div class="row g-3">
                    <?php if(empty($members)): ?>
                    <div class="col-12 text-center text-secondary py-3"><?php echo lang('admin_no_members'); ?></div>
                    <?php else: ?>
                    <?php foreach($members as $m): ?>
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="card border-0 shadow-sm text-center p-3">
                            <img src="<?php echo ABOUT_IMG_PATH . htmlspecialchars($m['picture']); ?>"
                                 class="rounded-circle mx-auto mb-2"
                                 style="width:72px;height:72px;object-fit:cover;" loading="lazy">
                            <p class="fw-600 mb-2" style="font-size:var(--fs-sm);">
                                <?php echo htmlspecialchars($m['name']); ?>
                            </p>
                            <form method="POST" action="<?php echo SITE_URL; ?>admin/settings/member/remove"
                                  onsubmit="return confirm('<?php echo lang('admin_confirm_rem_member'); ?>')">
                                <input type="hidden" name="id" value="<?php echo $m['sr_no']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger w-100">
                                    <i class="fas fa-trash"></i> <?php echo lang('admin_remove_member'); ?>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo SITE_URL; ?>admin/settings/member/add" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title fw-700"><?php echo lang('admin_add_member'); ?></h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><?php echo lang('admin_member_name'); ?></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo lang('admin_member_photo'); ?></label>
                        <input type="file" name="picture" accept=".jpg,.png,.webp,.jpeg" class="form-control" required>
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
