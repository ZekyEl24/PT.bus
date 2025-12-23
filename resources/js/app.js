import './bootstrap';
import './admin/user-modal';


/**
 * Menampilkan pop-up notifikasi sukses.
 * @param {string} type - Tipe operasi: 'buat', 'simpan', atau 'hapus'.
 * @param {number} duration - Durasi tampilan (ms). Default 3000ms.
 */
window.showNotification = function(type, duration = 3000) {
    const notification = document.getElementById('successNotification');
    const iconContainer = document.getElementById('notificationIcon');
    const messageElement = document.getElementById('notificationMessage');
    const content = document.getElementById('notificationContent');

    if (!notification || !iconContainer || !messageElement) return;

    let message = "";
    let iconSvg = "";

    // 1. Menentukan Pesan dan Icon
    switch (type.toLowerCase()) {
        case 'buat':
            message = "Data Berhasil Dibuat!";
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17L4 12"/>
                       </svg>`;
            break;
        case 'simpan':
        case 'edit': // Tambahkan alias untuk edit
            message = "Data Berhasil Disimpan!";
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                       </svg>`;
            break;
        case 'hapus':
            message = "Data Berhasil Dihapus!";
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6M10 11v6M14 11v6"/>
                            <path d="M15 6V4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v2"/>
                       </svg>`;
            break;
        default:
            return;
    }

    // 2. Mengisi konten
    iconContainer.innerHTML = iconSvg;
    messageElement.textContent = message;

    // 3. Menampilkan modal dengan transisi
    notification.classList.replace('hidden', 'flex');
    setTimeout(() => {
        notification.style.opacity = '1';
        content.classList.replace('scale-90', 'scale-100');
    }, 10);

    // 4. Otomatis menutup
    setTimeout(() => {
        window.hideNotification();
    }, duration);
}

/**
 * Menyembunyikan notifikasi.
 */
window.hideNotification = function() {
    const notification = document.getElementById('successNotification');
    const content = document.getElementById('notificationContent');

    if (!notification || !content) return;

    notification.style.opacity = '0';
    content.classList.replace('scale-100', 'scale-90');

    setTimeout(() => {
        notification.classList.replace('flex', 'hidden');
    }, 300);
}


// =================================================================
// LOGIKA PENGGUNAAN UNIVERSAL MELALUI SESSION FLASH (setelah redirect)
// =================================================================

document.addEventListener('DOMContentLoaded', function() {
    // Pengecekan dilakukan di sini.
    // Variabel ini harus didefinisikan secara global di Blade jika menggunakan session.

    // Asumsi Anda menggunakan variabel `session('success_type')` dari Controller.
    const successType = document.querySelector('meta[name="success-type"]');

    if (successType && successType.content) {
        window.showNotification(successType.content);
    }
});
