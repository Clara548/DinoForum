// ==================== GESTIÓN DE COOKIES ====================
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = name + "=" + value + ";expires=" + d.toUTCString() + ";path=/";
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

function acceptCookies() {
    setCookie('cookies_accepted', 'true', 365);
    document.getElementById('cookieBanner').style.display = 'none';
}

function declineCookies() {
    setCookie('cookies_accepted', 'false', 365);
    document.getElementById('cookieBanner').style.display = 'none';
    // Eliminar cookies no esenciales
    document.cookie.split(";").forEach(function(c) {
        document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
    });
}

function configureCookies() {
    document.getElementById('cookieSettings').style.display = 'flex';
}

function saveCookieSettings() {
    const analytics = document.getElementById('cookieAnalytics').checked;
    const marketing = document.getElementById('cookieMarketing').checked;
    setCookie('cookies_analytics', analytics, 365);
    setCookie('cookies_marketing', marketing, 365);
    setCookie('cookies_accepted', 'true', 365);
    document.getElementById('cookieSettings').style.display = 'none';
    document.getElementById('cookieBanner').style.display = 'none';
}

// Mostrar banner si no hay consentimiento
document.addEventListener('DOMContentLoaded', () => {
    const accepted = getCookie('cookies_accepted');
    if (!accepted) {
        document.getElementById('cookieBanner').style.display = 'flex';
    }
});