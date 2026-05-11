<?php
$lang  = Session::getLang();
$isRTL = $lang === 'ar';
$nights = (new DateTime($booking['check_in']))->diff(new DateTime($booking['check_out']))->days;
$statusLabel = lang('status_' . $booking['booking_status']);
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $isRTL ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo APP_NAME; ?> — <?php echo lang('booking_receipt'); ?> #<?php echo $booking['booking_id']; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; color: #333; direction: <?php echo $isRTL ? 'rtl' : 'ltr'; ?>; }

        .page { max-width: 700px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.1); }

        .header { background: linear-gradient(135deg, #2ec1ac, #1a9e8c); color: #fff; padding: 30px 40px; display: flex; justify-content: space-between; align-items: center; }
        .header-brand { font-size: 1.6rem; font-weight: 800; display: flex; align-items: center; gap: 10px; }
        .header-brand i { font-size: 1.8rem; }
        .header-right { text-align: <?php echo $isRTL ? 'left' : 'right'; ?>; }
        .header-right .receipt-title { font-size: 1.1rem; font-weight: 700; opacity: .9; }
        .header-right .receipt-id { font-size: .85rem; opacity: .75; margin-top: 4px; }

        .status-bar { background: #e8f9f6; border-bottom: 2px solid #2ec1ac; padding: 12px 40px; display: flex; align-items: center; gap: 8px; font-weight: 600; color: #1a9e8c; font-size: .9rem; }
        .status-bar i { font-size: 1rem; }

        .body { padding: 30px 40px; }

        .section-title { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #999; margin-bottom: 14px; margin-top: 24px; }
        .section-title:first-child { margin-top: 0; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .info-item { }
        .info-item .label { font-size: .78rem; color: #999; margin-bottom: 3px; }
        .info-item .value { font-size: .95rem; font-weight: 600; color: #333; }

        .divider { border: none; border-top: 1px solid #eee; margin: 20px 0; }

        .dates-grid { display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 10px; text-align: center; background: #f9f9f9; border-radius: 10px; padding: 18px; }
        .dates-grid .arrow { color: #2ec1ac; font-size: 1.2rem; }
        .dates-grid .date-label { font-size: .75rem; color: #999; margin-bottom: 4px; }
        .dates-grid .date-value { font-size: 1rem; font-weight: 700; color: #333; }
        .dates-grid .nights-badge { background: #2ec1ac; color: #fff; border-radius: 20px; padding: 4px 14px; font-size: .8rem; font-weight: 700; }

        .total-box { background: linear-gradient(135deg, #2ec1ac15, #1a9e8c10); border: 2px solid #2ec1ac40; border-radius: 10px; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; margin-top: 20px; }
        .total-box .label { font-size: .9rem; color: #555; font-weight: 600; }
        .total-box .value { font-size: 1.6rem; font-weight: 800; color: #2ec1ac; }

        .footer { background: #f9f9f9; border-top: 1px solid #eee; padding: 18px 40px; text-align: center; font-size: .78rem; color: #999; }

        .print-btn { display: block; width: fit-content; margin: 20px auto; padding: 10px 28px; background: #2ec1ac; color: #fff; border: none; border-radius: 8px; font-size: .95rem; font-weight: 600; cursor: pointer; border-radius: 50px; }

        @media print {
            body { background: #fff; }
            .page { box-shadow: none; margin: 0; border-radius: 0; }
            .print-btn { display: none; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<button class="print-btn" onclick="window.print()">
    <i class="fas fa-print"></i> <?php echo lang('pdf'); ?>
</button>

<div class="page">

    <div class="header">
        <div class="header-brand">
            <i class="fas fa-hotel"></i><?php echo APP_NAME; ?>
        </div>
        <div class="header-right">
            <div class="receipt-title"><?php echo lang('booking_receipt'); ?></div>
            <div class="receipt-id">#<?php echo htmlspecialchars($booking['order_id']); ?></div>
        </div>
    </div>

    <div class="status-bar">
        <i class="fas fa-check-circle"></i>
        <?php echo $statusLabel; ?> — <?php echo lang('order_id'); ?>: <strong><?php echo htmlspecialchars($booking['order_id']); ?></strong>
    </div>

    <div class="body">

        <div class="section-title"><?php echo lang('guest'); ?></div>
        <div class="info-grid">
            <div class="info-item">
                <div class="label"><?php echo lang('name'); ?></div>
                <div class="value"><?php echo htmlspecialchars($booking['user_name']); ?></div>
            </div>
            <div class="info-item">
                <div class="label"><?php echo lang('phone'); ?></div>
                <div class="value"><?php echo htmlspecialchars($booking['phonenum']); ?></div>
            </div>
            <div class="info-item">
                <div class="label"><?php echo lang('address'); ?></div>
                <div class="value"><?php echo htmlspecialchars($booking['address']); ?></div>
            </div>
            <div class="info-item">
                <div class="label"><?php echo lang('email'); ?></div>
                <div class="value"><?php echo htmlspecialchars($booking['email']); ?></div>
            </div>
        </div>

        <hr class="divider">

        <div class="section-title"><?php echo lang('rooms'); ?></div>
        <div class="info-grid">
            <div class="info-item">
                <div class="label"><?php echo lang('rooms'); ?></div>
                <div class="value"><?php echo htmlspecialchars($booking['room_name']); ?></div>
            </div>
            <div class="info-item">
                <div class="label"><?php echo lang('per_night'); ?></div>
                <div class="value"><?php echo number_format($booking['price'], 2); ?></div>
            </div>
        </div>

        <hr class="divider">

        <div class="section-title"><?php echo lang('check_in'); ?> / <?php echo lang('check_out'); ?></div>
        <div class="dates-grid">
            <div>
                <div class="date-label"><?php echo lang('check_in'); ?></div>
                <div class="date-value"><?php echo date('d M Y', strtotime($booking['check_in'])); ?></div>
            </div>
            <div>
                <div class="nights-badge"><?php echo $nights; ?> <?php echo lang('nights'); ?></div>
            </div>
            <div>
                <div class="date-label"><?php echo lang('check_out'); ?></div>
                <div class="date-value"><?php echo date('d M Y', strtotime($booking['check_out'])); ?></div>
            </div>
        </div>

        <div class="total-box">
            <span class="label"><i class="fas fa-dollar-sign"></i> <?php echo lang('total_paid'); ?></span>
            <span class="value"><?php echo number_format($booking['total_pay'], 2); ?></span>
        </div>

    </div>

    <div class="footer">
        <?php echo lang('present_confirmation'); ?> <strong><?php echo $booking['booking_id']; ?></strong>
        &nbsp;|&nbsp; <?php echo APP_NAME; ?> &copy; <?php echo date('Y'); ?>
    </div>

</div>

</body>
</html>
