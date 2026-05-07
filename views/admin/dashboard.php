<?php $pageTitle = 'Dashboard'; ?>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <a href="<?php echo SITE_URL; ?>admin/bookings/new" class="admin-stat-card">
            <div class="admin-stat-icon" style="background:rgba(40,167,69,.12);">
                <i class="fas fa-calendar-plus" style="color:#28a745;"></i>
            </div>
            <div>
                <div class="admin-stat-value"><?php echo $pending['new_bookings'] ?? 0; ?></div>
                <div class="admin-stat-label">New Bookings</div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="<?php echo SITE_URL; ?>admin/bookings/refunds" class="admin-stat-card">
            <div class="admin-stat-icon" style="background:rgba(255,193,7,.12);">
                <i class="fas fa-undo" style="color:#d4a017;"></i>
            </div>
            <div>
                <div class="admin-stat-value"><?php echo $pending['refund_bookings'] ?? 0; ?></div>
                <div class="admin-stat-label">Pending Refunds</div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="<?php echo SITE_URL; ?>admin/queries" class="admin-stat-card">
            <div class="admin-stat-icon" style="background:rgba(23,162,184,.12);">
                <i class="fas fa-comments" style="color:#17a2b8;"></i>
            </div>
            <div>
                <div class="admin-stat-value"><?php echo $unreadQueries; ?></div>
                <div class="admin-stat-label">Unread Queries</div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="<?php echo SITE_URL; ?>admin/reviews" class="admin-stat-card">
            <div class="admin-stat-icon" style="background:var(--primary-light);">
                <i class="fas fa-star text-primary-custom"></i>
            </div>
            <div>
                <div class="admin-stat-value"><?php echo $unreadReviews; ?></div>
                <div class="admin-stat-label">New Reviews</div>
            </div>
        </a>
    </div>
</div>

<!-- Booking Analytics -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="fw-700 mb-0">
                <i class="fas fa-chart-bar text-primary-custom"></i> Booking Analytics
            </h6>
            <form method="POST" action="<?php echo SITE_URL; ?>admin/dashboard" class="d-flex align-items-center gap-2">
                <input type="hidden" name="type" value="booking">
                <select name="period" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                    <?php foreach([1=>'Past 30 Days',2=>'Past 90 Days',3=>'Past 1 Year',5=>'All Time'] as $v=>$l): ?>
                    <option value="<?php echo $v; ?>" <?php echo (($period??1)==$v)?'selected':''; ?>>
                        <?php echo $l; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-3 rounded-3" style="background:var(--bg-hover);">
                    <div class="admin-stat-label mb-1">Total Bookings</div>
                    <div class="fw-800" style="font-size:var(--fs-2xl); color:var(--text-primary);">
                        <?php echo $analytics['total_bookings'] ?? 0; ?>
                    </div>
                    <div class="fw-600 text-primary-custom"><?php echo $analytics['total_pay'] ?? 0; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 rounded-3" style="background:rgba(40,167,69,.08);">
                    <div class="admin-stat-label mb-1">Active Bookings</div>
                    <div class="fw-800" style="font-size:var(--fs-2xl); color:#28a745;">
                        <?php echo $analytics['active_bookings'] ?? 0; ?>
                    </div>
                    <div class="fw-600" style="color:#28a745;"><?php echo $analytics['active_amt'] ?? 0; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 rounded-3" style="background:rgba(220,53,69,.08);">
                    <div class="admin-stat-label mb-1">Cancelled</div>
                    <div class="fw-800" style="font-size:var(--fs-2xl); color:#dc3545;">
                        <?php echo $analytics['cancelled_bookings'] ?? 0; ?>
                    </div>
                    <div class="fw-600" style="color:#dc3545;"><?php echo $analytics['cancelled_amt'] ?? 0; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users & Activity -->
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="fw-700 mb-4">
                    <i class="fas fa-users text-primary-custom"></i> Users
                </h6>
                <div class="row g-3 text-center">
                    <div class="col-4">
                        <div class="fw-800" style="font-size:var(--fs-2xl); color:var(--text-primary);"><?php echo $users['total'] ?? 0; ?></div>
                        <div class="admin-stat-label">Total</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-800" style="font-size:var(--fs-2xl); color:#28a745;"><?php echo $users['active'] ?? 0; ?></div>
                        <div class="admin-stat-label">Active</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-800" style="font-size:var(--fs-2xl); color:#dc3545;"><?php echo $users['inactive'] ?? 0; ?></div>
                        <div class="admin-stat-label">Inactive</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-700 mb-0">
                        <i class="fas fa-chart-line text-primary-custom"></i> Activity
                    </h6>
                    <form method="POST" action="<?php echo SITE_URL; ?>admin/dashboard" class="d-flex align-items-center gap-2">
                        <input type="hidden" name="type" value="user">
                        <select name="period" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                            <?php foreach([1=>'Past 30 Days',2=>'Past 90 Days',3=>'Past 1 Year',5=>'All Time'] as $v=>$l): ?>
                            <option value="<?php echo $v; ?>" <?php echo (($period??1)==$v)?'selected':''; ?>>
                                <?php echo $l; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <div class="row g-3 text-center">
                    <div class="col-4">
                        <div class="fw-800" style="font-size:var(--fs-2xl); color:var(--text-primary);"><?php echo $activity['new_reg'] ?? 0; ?></div>
                        <div class="admin-stat-label">New Users</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-800" style="font-size:var(--fs-2xl); color:var(--text-primary);"><?php echo $activity['queries'] ?? 0; ?></div>
                        <div class="admin-stat-label">Queries</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-800" style="font-size:var(--fs-2xl); color:var(--text-primary);"><?php echo $activity['reviews'] ?? 0; ?></div>
                        <div class="admin-stat-label">Reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
