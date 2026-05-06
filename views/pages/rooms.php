<?php $pageTitle = APP_NAME . ' — ' . lang('rooms'); ?>
<?php require BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container-fluid mt-5">
    <div class="row">

        <!-- Sidebar Filters -->
        <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-filter" class="text-primary-custom"></i>Filters
                    </h5>

                    <!-- Availability -->
                    <div class="border rounded-3 p-3 mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-calendar-alt"></i>Availability
                            </h6>
                            <button id="chk_avail_btn" onclick="chk_avail_clear()" class="btn btn-sm text-secondary shadow-none d-none">
                                <i class="fas fa-times"></i>Reset
                            </button>
                        </div>
                        <label class="form-label small text-muted">
                            <i class="fas fa-calendar-check"></i>Check-in
                        </label>
                        <input type="date" class="form-control shadow-none mb-3" id="checkin" onchange="chk_avail_filter()">
                        <label class="form-label small text-muted">
                            <i class="fas fa-calendar-times"></i>Check-out
                        </label>
                        <input type="date" class="form-control shadow-none" id="checkout" onchange="chk_avail_filter()">
                    </div>

                    <!-- Facilities -->
                    <div class="border rounded-3 p-3 mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-concierge-bell"></i>Facilities
                            </h6>
                            <button id="facilities_btn" onclick="facilities_clear()" class="btn btn-sm text-secondary shadow-none d-none">
                                <i class="fas fa-times"></i>Reset
                            </button>
                        </div>
                        <?php foreach($facilities_list as $fac): ?>
                        <div class="mb-2">
                            <input type="checkbox" onclick="fetch_rooms()" name="facilities"
                                   value="<?php echo $fac['id']; ?>" id="fac_<?php echo $fac['id']; ?>"
                                   class="form-check-input shadow-none me-2">
                            <label for="fac_<?php echo $fac['id']; ?>" class="form-check-label small">
                                <?php echo htmlspecialchars($fac['name']); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Guests -->
                    <div class="border rounded-3 p-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-users"></i>Guests
                            </h6>
                            <button id="guests_btn" onclick="guests_clear()" class="btn btn-sm text-secondary shadow-none d-none">
                                <i class="fas fa-times"></i>Reset
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label small text-muted">
                                    <i class="fas fa-user"></i>Adults
                                </label>
                                <input type="number" min="1" id="adults" oninput="guests_filter()" class="form-control shadow-none">
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">
                                    <i class="fas fa-child"></i>Children
                                </label>
                                <input type="number" min="0" id="children" oninput="guests_filter()" class="form-control shadow-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rooms List -->
        <div class="col-lg-9 col-md-12 px-4" id="rooms-data">
            <div class="text-center py-5">
                <div class="spinner-border text-info" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require BASE_PATH . '/views/layouts/footer.php'; ?>

<script>
const roomsData = document.getElementById('rooms-data');
const checkin   = document.getElementById('checkin');
const checkout  = document.getElementById('checkout');
const adults    = document.getElementById('adults');
const children  = document.getElementById('children');
const chkBtn    = document.getElementById('chk_avail_btn');
const guestsBtn = document.getElementById('guests_btn');
const facBtn    = document.getElementById('facilities_btn');

function fetch_rooms(){
    const chk_avail = JSON.stringify({checkin: checkin.value, checkout: checkout.value});
    const guests    = JSON.stringify({adults: adults.value || 0, children: children.value || 0});
    const facList   = {facilities:[]};

    document.querySelectorAll('[name="facilities"]:checked').forEach(f => facList.facilities.push(f.value));
    facBtn.classList.toggle('d-none', facList.facilities.length === 0);

    roomsData.innerHTML = `<div class="text-center py-5">
        <div class="spinner-border text-info" role="status"></div>
        <p class="text-muted mt-3"><i class="fas fa-search"></i>Searching rooms...</p>
    </div>`;

    fetch(`${APP.siteUrl}api/rooms/search?fetch_rooms&chk_avail=${encodeURIComponent(chk_avail)}&guests=${encodeURIComponent(guests)}&facility_list=${encodeURIComponent(JSON.stringify(facList))}`)
        .then(r => r.text())
        .then(html => { roomsData.innerHTML = html; })
        .catch(() => { roomsData.innerHTML = '<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Error loading rooms.</p></div>'; });
}

function chk_avail_filter(){
    const today = new Date().toISOString().split('T')[0];
    if(checkin.value && checkout.value){
        if(checkin.value < today){ alert('error','Check-in cannot be in the past!'); checkin.value=''; return; }
        if(checkout.value <= checkin.value){ alert('error','Check-out must be after check-in!'); checkout.value=''; return; }
        fetch_rooms();
        chkBtn.classList.remove('d-none');
    }
}
function chk_avail_clear(){ checkin.value=''; checkout.value=''; chkBtn.classList.add('d-none'); fetch_rooms(); }
function guests_filter(){ if(adults.value>0||children.value>0){ fetch_rooms(); guestsBtn.classList.remove('d-none'); } }
function guests_clear(){ adults.value=''; children.value=''; guestsBtn.classList.add('d-none'); fetch_rooms(); }
function facilities_clear(){
    document.querySelectorAll('[name="facilities"]:checked').forEach(f => f.checked=false);
    facBtn.classList.add('d-none');
    fetch_rooms();
}

window.onload = fetch_rooms;
</script>
