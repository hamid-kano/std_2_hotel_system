<?php
  // footer.php — Vana Hotel
?>

<!-- Scroll to Top Button -->
<button id="scroll-top" aria-label="Scroll to top" title="Back to top">
  <i class="bi bi-arrow-up"></i>
</button>

<footer class="container-fluid bg-white mt-5 border-top">
    <div class="row py-4">
        <div class="col-lg-4 p-4">
            <h3 class="fw-bold fs-3 mb-2" style="color:var(--teal);">
              <?php echo htmlspecialchars($settings_r['site_title'] ?? 'Vana Hotel'); ?>
            </h3>
            <p class="text-muted"><?php echo htmlspecialchars($settings_r['site_about'] ?? ''); ?></p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3 fw-bold"><?php echo lang('home'); ?> &amp; Links</h5>
            <a href="hotel.php"     class="d-block mb-2 text-dark text-decoration-none"><?php echo lang('home'); ?></a>
            <a href="rooms.php"     class="d-block mb-2 text-dark text-decoration-none"><?php echo lang('rooms'); ?></a>
            <a href="facalites.php" class="d-block mb-2 text-dark text-decoration-none"><?php echo lang('facilities'); ?></a>
            <a href="contact.php"   class="d-block mb-2 text-dark text-decoration-none"><?php echo lang('contact'); ?></a>
            <a href="about.php"     class="d-block mb-2 text-dark text-decoration-none"><?php echo lang('about'); ?></a>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="fw-bold mb-3">Follow us</h5>
            <?php if(!empty($contact_r['tw'])): ?>
            <a href="<?php echo htmlspecialchars($contact_r['tw']); ?>"
               class="d-block mb-2 text-decoration-none text-dark" target="_blank" rel="noopener">
              <i class="bi bi-twitter me-1"></i> Twitter
            </a>
            <?php endif; ?>
            <?php if(!empty($contact_r['fb'])): ?>
            <a href="<?php echo htmlspecialchars($contact_r['fb']); ?>"
               class="d-block mb-2 text-decoration-none text-dark" target="_blank" rel="noopener">
              <i class="bi bi-facebook me-1"></i> Facebook
            </a>
            <?php endif; ?>
            <?php if(!empty($contact_r['insta'])): ?>
            <a href="<?php echo htmlspecialchars($contact_r['insta']); ?>"
               class="d-block mb-2 text-decoration-none text-dark" target="_blank" rel="noopener">
              <i class="bi bi-instagram me-1"></i> Instagram
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="text-center py-3 border-top small text-muted">
        &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($settings_r['site_title'] ?? 'Vana Hotel'); ?>.
        All rights reserved.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script>
/* ===== ALERT ===== */
function alert(type, msg){
    let cls = (type==="success") ? 'alert-success' : 'alert-danger';
    let el  = document.createElement('div');
    el.innerHTML = `
      <div class="alert ${cls} alert-dismissible fade show custom-alert" role="alert">
        <strong>${msg}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>`;
    document.body.append(el);
    setTimeout(()=>{ el.querySelector('.alert')?.remove(); }, 5000);
}

/* ===== DARK MODE ===== */
(function(){
    const saved = localStorage.getItem('vana_theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    const btn = document.getElementById('darkToggle');
    if(btn) btn.textContent = saved==='dark' ? '☀️' : '🌙';
})();
document.getElementById('darkToggle')?.addEventListener('click', function(){
    const current = document.documentElement.getAttribute('data-theme');
    const next    = current==='dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('vana_theme', next);
    this.textContent = next==='dark' ? '☀️' : '🌙';
});

/* ===== SCROLL TO TOP ===== */
const scrollBtn = document.getElementById('scroll-top');
window.addEventListener('scroll', ()=>{
    scrollBtn?.classList.toggle('show', window.scrollY > 300);
});
scrollBtn?.addEventListener('click', ()=> window.scrollTo({top:0, behavior:'smooth'}));

/* ===== LAZY LOADING ===== */
if('IntersectionObserver' in window){
    const io = new IntersectionObserver((entries)=>{
        entries.forEach(e=>{
            if(e.isIntersecting){
                const img = e.target;
                if(img.dataset.src){ img.src = img.dataset.src; }
                img.classList.add('loaded');
                io.unobserve(img);
            }
        });
    },{rootMargin:'100px'});
    document.querySelectorAll('img.lazy').forEach(img=> io.observe(img));
}

/* ===== ACTIVE NAV ===== */
function setActive(){
    const navbar = document.getElementById('nav-bar');
    if(!navbar) return;
    navbar.querySelectorAll('a').forEach(a=>{
        const file = a.href.split('/').pop().split('?')[0].split('.')[0];
        if(file && document.location.href.indexOf(file) >= 0){
            a.classList.add('active');
        }
    });
}

/* ===== REGISTER FORM ===== */
const register_form = document.getElementById('register-form');
if(register_form){
    register_form.addEventListener('submit', (e)=>{
        e.preventDefault();
        const btn = register_form.querySelector('[type=submit]');
        btn.classList.add('btn-loading');

        let data = new FormData();
        ['name','email','phonenum','address','pincode','dob','pass','cpass'].forEach(k=>{
            data.append(k, register_form.elements[k].value);
        });
        data.append('register','');

        bootstrap.Modal.getInstance(document.getElementById('RegisterModal'))?.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/login_register.php",true);
        xhr.onload = function(){
            btn.classList.remove('btn-loading');
            const r = this.responseText;
            if(r==='pass_mismatch')      alert('error','Password Mismatch');
            else if(r==='email_already') alert('error','Email already registered!');
            else if(r==='phone_already') alert('error','Phone number already registered!');
            else if(r==='ins_failed')    alert('error','Registration failed! Server error.');
            else                         alert('success','Registration successful!');
        };
        xhr.send(data);
    });
}

/* ===== LOGIN FORM ===== */
const login_form = document.getElementById('login-form');
if(login_form){
    login_form.addEventListener('submit', (e)=>{
        e.preventDefault();
        const btn = login_form.querySelector('[type=submit]');
        btn.classList.add('btn-loading');

        let data = new FormData();
        data.append('email_mob', login_form.elements['email_mob'].value);
        data.append('pass',      login_form.elements['pass'].value);
        data.append('login','');

        bootstrap.Modal.getInstance(document.getElementById('LoginModal'))?.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/login_register.php",true);
        xhr.onload = function(){
            btn.classList.remove('btn-loading');
            const r = this.responseText;
            if(r==="inv_email_mob")  alert("error","Invalid Email or Mobile Number!");
            else if(r==="inactive")  alert("error","Account Suspended! Contact Admin.");
            else if(r==="invalid_pass") alert("error","Incorrect Password!");
            else if(r==="rate_limit")   alert("error","Too many attempts. Wait 10 minutes.");
            else{
                const file = window.location.href.split('/').pop().split('?')[0];
                window.location = (file==='room_details.php') ? window.location.href : window.location.pathname;
            }
        };
        xhr.send(data);
    });
}

/* ===== BOOK ROOM ===== */
function checkLoginToBook(status, room_id){
    if(status){
        window.location.href = 'confirm_booking.php?id=' + room_id;
    } else {
        alert('error','Please login to book a room!');
    }
}

setActive();
</script>
