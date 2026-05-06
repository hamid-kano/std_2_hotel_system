/* ===== ALERT ===== */
function alert(type, msg){
    const cls = (type==="success") ? 'alert-success' : 'alert-danger';
    const icon = (type==="success") ? 'fa-check-circle' : 'fa-exclamation-circle';
    const el = document.createElement('div');
    el.innerHTML = `
      <div class="alert ${cls} alert-dismissible fade show custom-alert" role="alert">
        <i class="fas ${icon} me-2"></i><strong>${msg}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>`;
    document.body.append(el);
    setTimeout(()=>{ el.querySelector('.alert')?.remove(); }, 5000);
}

/* ===== DARK MODE ===== */
(function(){
    const saved = localStorage.getItem('vana_theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    _applyDarkToggleIcon(saved);
})();

function _applyDarkToggleIcon(theme) {
    const btn = document.getElementById('darkToggle');
    if (!btn) return;
    const icon = btn.querySelector('i');
    if (icon) {
        icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    }
}

document.getElementById('darkToggle')?.addEventListener('click', function(){
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('vana_theme', next);
    _applyDarkToggleIcon(next);
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
                if(img.dataset.src) img.src = img.dataset.src;
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
    const path = window.location.pathname.split('/').pop() || 'home';
    navbar.querySelectorAll('a').forEach(a=>{
        if(a.href.includes(path)) a.classList.add('active');
    });
}

/* ===== REGISTER FORM ===== */
const register_form = document.getElementById('register-form');
if(register_form){
    register_form.addEventListener('submit', (e)=>{
        e.preventDefault();
        const btn = register_form.querySelector('[type=submit]');
        btn.classList.add('btn-loading');

        const data = new FormData();
        ['name','email','phonenum','address','pincode','dob','pass','cpass'].forEach(k=>{
            data.append(k, register_form.elements[k].value);
        });
        data.append('register','');

        bootstrap.Modal.getInstance(document.getElementById('RegisterModal'))?.hide();

        fetch(APP.siteUrl + 'api/auth/register', {
            method: 'POST',
            body: data
        })
        .then(r => r.text())
        .then(r => {
            btn.classList.remove('btn-loading');
            if(r==='pass_mismatch') alert('error','Password Mismatch');
            else if(r==='email_already') alert('error','Email already registered!');
            else if(r==='phone_already') alert('error','Phone already registered!');
            else if(r==='ins_failed') alert('error','Registration failed!');
            else{ alert('success','Registration successful!'); register_form.reset(); }
        })
        .catch(()=>{ btn.classList.remove('btn-loading'); alert('error','Connection error'); });
    });
}

/* ===== LOGIN FORM ===== */
const login_form = document.getElementById('login-form');
if(login_form){
    login_form.addEventListener('submit', (e)=>{
        e.preventDefault();
        const btn = login_form.querySelector('[type=submit]');
        btn.classList.add('btn-loading');

        const data = new FormData();
        data.append('email_mob', login_form.elements['email_mob'].value);
        data.append('pass', login_form.elements['pass'].value);
        data.append('login','');

        bootstrap.Modal.getInstance(document.getElementById('LoginModal'))?.hide();

        fetch(APP.siteUrl + 'api/auth/login', {
            method: 'POST',
            body: data
        })
        .then(r => r.text())
        .then(r => {
            btn.classList.remove('btn-loading');
            if(r==="inv_email_mob") alert("error","Invalid Email or Mobile!");
            else if(r==="inactive") alert("error","Account Suspended!");
            else if(r==="invalid_pass") alert("error","Incorrect Password!");
            else if(r==="rate_limit") alert("error","Too many attempts. Wait 10 minutes.");
            else{ window.location.reload(); }
        })
        .catch(()=>{ btn.classList.remove('btn-loading'); alert('error','Connection error'); });
    });
}

/* ===== BOOK ROOM ===== */
function checkLoginToBook(status, room_id){
    if(status){
        window.location.href = APP.siteUrl + 'booking/confirm?id=' + room_id;
    } else {
        alert('error','Please login to book a room!');
    }
}

setActive();
