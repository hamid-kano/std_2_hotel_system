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
    // Sync icon with current theme (already set on <html> by PHP via cookie)
    _applyDarkToggleIcon(document.documentElement.getAttribute('data-theme') || 'light');
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
    // Also set cookie so PHP can read it server-side (prevents theme flash)
    document.cookie = `vana_theme=${next};path=/;max-age=31536000`;
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

/* ===== BOOK ROOM ===== */
function checkLoginToBook(status, room_id){
    if(status){
        window.location.href = APP.siteUrl + 'booking/confirm?id=' + room_id;
    } else {
        window.location.href = APP.siteUrl + 'login';
    }
}

setActive();
