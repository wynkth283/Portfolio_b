function showToast(type = 'info', message = 'Thông báo!', duration = 3500) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    const icons = { success: '✓', error: '✕', warning: '!', info: 'i' };
    toast.innerHTML = `
      <div class="toast-icon">${icons[type]}</div>
      <div>${message}</div>
      <div class="toast-close" onclick="closeToast(this)">&times;</div>
    `;
    container.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 50);
    const timer = setTimeout(() => closeToast(toast.querySelector('.toast-close')), duration);
    toast.onclick = () => { clearTimeout(timer); closeToast(toast.querySelector('.toast-close')); };
}
function closeToast(btn) {
    const toast = btn.parentElement;
    toast.style.transition = 'all .4s ease';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(50%) scale(0.9)';
    setTimeout(() => toast.remove(), 400);
}
window.showToast = showToast;
window.closeToast = closeToast;