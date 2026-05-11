<?php
$pageTitle = APP_NAME . ' — Secure Payment';
$lang  = Session::getLang();
$isRTL = $lang === 'ar';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $isRTL ? 'rtl' : 'ltr'; ?>">
<head>
    <?php require BASE_PATH . '/views/layouts/head.php'; ?>
    <title><?php echo $pageTitle; ?></title>
    <style>
        body { background: var(--bg-body); }

        .payment-layout {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Top bar ── */
        .payment-topbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: .75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .payment-brand {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-family: var(--font-heading);
            font-size: var(--fs-xl);
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
        }
        .payment-brand i { width: auto; }
        .payment-secure {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: var(--fs-xs);
            color: var(--text-secondary);
            background: rgba(40,167,69,.1);
            border: 1px solid rgba(40,167,69,.25);
            border-radius: var(--r-full);
            padding: .3rem .75rem;
        }
        .payment-secure i { color: #28a745; width: auto; }

        /* ── Main ── */
        .payment-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--sp-5) var(--sp-3);
        }
        .payment-wrap {
            width: 100%;
            max-width: 900px;
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: var(--sp-4);
        }
        @media (max-width: 768px) {
            .payment-wrap { grid-template-columns: 1fr; }
        }

        /* ── Order Summary ── */
        .order-summary {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--r-xl);
            padding: var(--sp-4);
        }
        .order-summary h5 {
            font-size: var(--fs-sm);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--text-muted);
            margin-bottom: var(--sp-3);
        }
        .order-room-name {
            font-size: var(--fs-xl);
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: var(--sp-1);
        }
        .order-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .5rem 0;
            border-bottom: 1px solid var(--border-light);
            font-size: var(--fs-sm);
        }
        .order-row:last-child { border-bottom: none; }
        .order-row .label { color: var(--text-secondary); }
        .order-row .value { font-weight: 600; color: var(--text-primary); }
        .order-total {
            background: var(--primary-light);
            border: 1px solid rgba(46,193,172,.2);
            border-radius: var(--r-lg);
            padding: var(--sp-2);
            margin-top: var(--sp-2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .order-total .label { font-weight: 600; color: var(--text-primary); }
        .order-total .value { font-size: var(--fs-2xl); font-weight: 800; color: var(--primary); }

        /* ── Card Form ── */
        .card-form {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--r-xl);
            padding: var(--sp-4);
        }
        .card-form h5 {
            font-size: var(--fs-sm);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--text-muted);
            margin-bottom: var(--sp-3);
        }

        /* Card type badges */
        .card-types {
            display: flex;
            gap: .5rem;
            margin-bottom: var(--sp-3);
        }
        .card-type-badge {
            padding: .3rem .75rem;
            border: 2px solid var(--border-color);
            border-radius: var(--r-md);
            font-size: var(--fs-xs);
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            transition: all var(--t-fast);
            user-select: none;
        }
        .card-type-badge.active { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }

        /* Card number input with icon */
        .card-input-wrap {
            position: relative;
        }
        .card-input-wrap .card-icon {
            position: absolute;
            right: .875rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: var(--text-muted);
            pointer-events: none;
        }
        [dir="rtl"] .card-input-wrap .card-icon { right: auto; left: .875rem; }
        .card-input-wrap input { padding-right: 2.5rem; }
        [dir="rtl"] .card-input-wrap input { padding-right: .875rem; padding-left: 2.5rem; }

        /* Test cards hint */
        .test-hint {
            background: rgba(255,193,7,.1);
            border: 1px solid rgba(255,193,7,.3);
            border-radius: var(--r-lg);
            padding: var(--sp-2);
            margin-bottom: var(--sp-3);
            font-size: var(--fs-xs);
        }
        .test-hint strong { color: #856404; }
        .test-card-row {
            display: flex;
            justify-content: space-between;
            margin-top: .25rem;
            color: var(--text-secondary);
        }
        .test-card-fill {
            cursor: pointer;
            color: var(--primary);
            font-weight: 600;
            text-decoration: underline;
            background: none;
            border: none;
            padding: 0;
            font-size: var(--fs-xs);
        }

        /* Processing overlay */
        .payment-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.6);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: var(--sp-3);
        }
        .payment-overlay.show { display: flex; }
        .payment-overlay-card {
            background: var(--bg-card);
            border-radius: var(--r-xl);
            padding: var(--sp-5) var(--sp-6);
            text-align: center;
            min-width: 280px;
            box-shadow: var(--shadow-xl);
        }
        .payment-spinner {
            width: 56px; height: 56px;
            border: 4px solid var(--border-color);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin .8s linear infinite;
            margin: 0 auto var(--sp-3);
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .payment-overlay-title { font-size: var(--fs-lg); font-weight: 700; color: var(--text-primary); margin-bottom: .5rem; }
        .payment-overlay-sub   { font-size: var(--fs-sm); color: var(--text-secondary); }

        /* Steps indicator */
        .payment-steps {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: var(--sp-4);
            font-size: var(--fs-xs);
        }
        .payment-step { display: flex; align-items: center; gap: .3rem; color: var(--text-muted); }
        .payment-step.done { color: #28a745; }
        .payment-step.active { color: var(--primary); font-weight: 600; }
        .payment-step-num {
            width: 20px; height: 20px;
            border-radius: 50%;
            background: var(--bg-hover);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 700;
        }
        .payment-step.done .payment-step-num { background: #28a745; color: #fff; }
        .payment-step.active .payment-step-num { background: var(--primary); color: #fff; }
        .payment-step-sep { color: var(--border-color); }
    </style>
</head>
<body>
<div class="payment-layout">

    <!-- Top bar -->
    <div class="payment-topbar">
        <a href="<?php echo SITE_URL; ?>" class="payment-brand">
            <i class="fas fa-hotel"></i><?php echo APP_NAME; ?>
        </a>
        <span class="payment-secure">
            <i class="fas fa-lock"></i> Secure Payment
        </span>
    </div>

    <!-- Main -->
    <div class="payment-main">
        <div class="payment-wrap">

            <!-- Order Summary -->
            <div class="order-summary">
                <!-- Steps -->
                <div class="payment-steps">
                    <div class="payment-step done">
                        <span class="payment-step-num"><i class="fas fa-check" style="font-size:8px;"></i></span>
                        Details
                    </div>
                    <span class="payment-step-sep">›</span>
                    <div class="payment-step done">
                        <span class="payment-step-num"><i class="fas fa-check" style="font-size:8px;"></i></span>
                        Availability
                    </div>
                    <span class="payment-step-sep">›</span>
                    <div class="payment-step active">
                        <span class="payment-step-num">3</span>
                        Payment
                    </div>
                </div>

                <h5><i class="fas fa-receipt"></i> Order Summary</h5>

                <p class="order-room-name"><?php echo htmlspecialchars($room['name']); ?></p>

                <div class="order-row">
                    <span class="label"><i class="fas fa-calendar-check"></i> Check-in</span>
                    <span class="value"><?php echo date('d M Y', strtotime($room['check_in'])); ?></span>
                </div>
                <div class="order-row">
                    <span class="label"><i class="fas fa-calendar-times"></i> Check-out</span>
                    <span class="value"><?php echo date('d M Y', strtotime($room['check_out'])); ?></span>
                </div>
                <?php
                    $nights = (new DateTime($room['check_in']))->diff(new DateTime($room['check_out']))->days;
                ?>
                <div class="order-row">
                    <span class="label"><i class="fas fa-moon"></i> Nights</span>
                    <span class="value"><?php echo $nights; ?></span>
                </div>
                <div class="order-row">
                    <span class="label"><i class="fas fa-user"></i> Guest</span>
                    <span class="value"><?php echo htmlspecialchars($guest['name']); ?></span>
                </div>
                <div class="order-row">
                    <span class="label"><i class="fas fa-tag"></i> Price/night</span>
                    <span class="value"><?php echo number_format($room['price'], 2); ?></span>
                </div>

                <div class="order-total">
                    <span class="label"><i class="fas fa-dollar-sign"></i> Total</span>
                    <span class="value"><?php echo number_format($room['payment'], 2); ?></span>
                </div>

                <p class="text-secondary mt-3 mb-0" style="font-size:var(--fs-xs);">
                    <i class="fas fa-shield-alt text-primary-custom"></i>
                    Free cancellation before check-in. Your data is encrypted and secure.
                </p>
            </div>

            <!-- Card Form -->
            <div class="card-form">
                <h5><i class="fas fa-credit-card"></i> Payment Details</h5>

                <!-- Card type selector -->
                <div class="card-types">
                    <div class="card-type-badge active" data-type="visa" onclick="selectCard(this)">
                        <i class="fab fa-cc-visa"></i> Visa
                    </div>
                    <div class="card-type-badge" data-type="mastercard" onclick="selectCard(this)">
                        <i class="fab fa-cc-mastercard"></i> Mastercard
                    </div>
                    <div class="card-type-badge" data-type="amex" onclick="selectCard(this)">
                        <i class="fab fa-cc-amex"></i> Amex
                    </div>
                </div>

                <button type="button" onclick="fillDemoCard()" style="width:100%;margin-bottom:1rem;padding:.5rem;border:1px dashed var(--primary);border-radius:var(--r-lg);background:var(--primary-light);color:var(--primary);font-size:var(--fs-sm);cursor:pointer;">
                    <i class="fas fa-magic"></i> تعبئة بيانات تجريبية
                </button>


                <!-- Alert -->
                <?php $payError = Session::flash('payment_error'); ?>
                <?php if ($payError): ?>
                <div class="mb-3" style="border-radius:var(--r-lg); padding:.75rem 1rem; font-size:var(--fs-sm); background:rgba(220,53,69,.12); border:1px solid rgba(220,53,69,.3); color:#b02a37;">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($payError); ?>
                </div>
                <?php endif; ?>
                <div id="pay-alert" class="d-none mb-3" style="border-radius:var(--r-lg); padding:.75rem 1rem; font-size:var(--fs-sm);"></div>

                <form id="payment-form" method="POST" action="<?php echo SITE_URL; ?>booking/process-payment">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user"></i> Cardholder Name</label>
                        <input type="text" id="card_name" name="card_name" class="form-control"
                               placeholder="Name on card" autocomplete="cc-name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-credit-card"></i> Card Number</label>
                        <div class="card-input-wrap">
                            <input type="text" id="card_number" name="card_number" class="form-control"
                                   placeholder="0000 0000 0000 0000" maxlength="19"
                                   autocomplete="cc-number" required>
                            <span class="card-icon" id="card-icon"><i class="fab fa-cc-visa"></i></span>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-7">
                            <label class="form-label"><i class="fas fa-calendar"></i> Expiry Date</label>
                            <input type="text" id="expiry" name="expiry" class="form-control"
                                   placeholder="MM / YY" maxlength="7"
                                   autocomplete="cc-exp" required>
                        </div>
                        <div class="col-5">
                            <label class="form-label"><i class="fas fa-lock"></i> CVV</label>
                            <input type="text" id="cvv" name="cvv" class="form-control"
                                   placeholder="•••" maxlength="4"
                                   autocomplete="cc-csc" required>
                        </div>
                    </div>

                    <button type="submit" class="btn custom-bg w-100 btn-lg" id="pay-btn">
                        <i class="fas fa-lock"></i>
                        Pay <?php echo number_format($room['payment'], 2); ?>
                    </button>

                    <a href="<?php echo SITE_URL; ?>booking/confirm?id=<?php echo $room['id']; ?>"
                       class="btn btn-outline-secondary w-100 mt-2">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Processing Overlay -->
<div class="payment-overlay" id="payOverlay">
    <div class="payment-overlay-card">
        <div class="payment-spinner"></div>
        <div class="payment-overlay-title" id="overlay-title">Processing Payment…</div>
        <div class="payment-overlay-sub" id="overlay-sub">Please do not close this window</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const APP = { siteUrl: '<?php echo SITE_URL; ?>' };

/* Dark mode */
(function(){
    const t = localStorage.getItem('vana_theme') || 'light';
    document.documentElement.setAttribute('data-theme', t);
})();

/* Fill demo card */
function fillDemoCard(){
    document.getElementById('card_name').value   = 'Ahmed Ali';
    document.getElementById('card_number').value = '4242 4242 4242 4242';
    document.getElementById('expiry').value      = '12 / 28';
    document.getElementById('cvv').value         = '123';
    document.querySelector('[data-type="visa"]').click();
}

/* Card type selector */
const cardIcons = { visa:'fab fa-cc-visa', mastercard:'fab fa-cc-mastercard', amex:'fab fa-cc-amex' };
let selectedType = 'visa';
function selectCard(el){
    document.querySelectorAll('.card-type-badge').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    selectedType = el.dataset.type;
    document.getElementById('card-icon').innerHTML = `<i class="${cardIcons[selectedType]}"></i>`;
}


/* Card number formatting */
document.getElementById('card_number').addEventListener('input', function(){
    let v = this.value.replace(/\D/g,'').substring(0,16);
    this.value = v.replace(/(.{4})/g,'$1 ').trim();
    // Auto-detect type
    if(v.startsWith('4'))      { document.querySelector('[data-type="visa"]').click(); }
    else if(v.startsWith('5')) { document.querySelector('[data-type="mastercard"]').click(); }
    else if(v.startsWith('3')) { document.querySelector('[data-type="amex"]').click(); }
});

/* Expiry formatting */
document.getElementById('expiry').addEventListener('input', function(){
    let v = this.value.replace(/\D/g,'').substring(0,4);
    if(v.length >= 2) v = v.substring(0,2) + ' / ' + v.substring(2);
    this.value = v;
});

/* CVV — numbers only */
document.getElementById('cvv').addEventListener('input', function(){
    this.value = this.value.replace(/\D/g,'').substring(0,4);
});

/* Alert helper */
function showAlert(msg, type){
    const el = document.getElementById('pay-alert');
    const icons = { success:'fa-check-circle', danger:'fa-exclamation-circle', warning:'fa-exclamation-triangle' };
    const colors = { success:'rgba(40,167,69,.12)', danger:'rgba(220,53,69,.12)', warning:'rgba(255,193,7,.12)' };
    const textColors = { success:'#1a7a35', danger:'#b02a37', warning:'#856404' };
    el.style.background = colors[type];
    el.style.border = `1px solid ${colors[type].replace('.12','.3')}`;
    el.style.color = textColors[type];
    el.innerHTML = `<i class="fas ${icons[type]} me-2"></i>${msg}`;
    el.classList.remove('d-none');
}

/* Submit — client-side validation only, then normal form submit */
document.getElementById('payment-form').addEventListener('submit', function(e){
    const num  = document.getElementById('card_number').value.trim();
    const exp  = document.getElementById('expiry').value.trim();
    const cvv  = document.getElementById('cvv').value.trim();
    const name = document.getElementById('card_name').value.trim();

    if(!name || !num || !exp || !cvv){
        e.preventDefault();
        showAlert('Please fill in all card details.', 'warning');
        return;
    }
    if(num.replace(/\s/g,'').length < 16){
        e.preventDefault();
        showAlert('Invalid card number.', 'danger');
        return;
    }

    // Show overlay while form submits
    document.getElementById('payOverlay').classList.add('show');
    document.getElementById('pay-btn').disabled = true;
});
</script>
</body>
</html>
