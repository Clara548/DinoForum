// ==================== TRADUCCIONES ====================
const translations = {
    es: {
        // Navegación
        nav_home: "🏠 Inicio",
        nav_dinosaurs: "🦕 Dinosaurios",
        nav_news: "📰 Noticias",
        
        // Títulos
        home_subtitle: "Descubre las últimas novedades del mundo jurásico",
        new_section: "🆕 NUEVO",
        new_subtitle: "Todo el contenido recién añadido",
        dinosaurs_subtitle: "Explora el mundo perdido de los gigantes prehistóricos",
        news_subtitle: "Últimas novedades del mundo jurásico",
        
        // Búsqueda y filtros
        search_dinosaur: "Buscar dinosaurio...",
        search_news: "Buscar por título...",
        all_periods: "📅 Todos los períodos",
        all_diets: "🍽️ Todas las dietas",
        reset: "Restablecer",
        filter_date: "Filtrar por fecha",
        
        // Contenido
        loading: "Cargando contenido...",
        no_content: "No hay contenido nuevo aún. ¡Añade dinosaurios o noticias desde el panel de administración!",
        no_dinosaurs: "No hay dinosaurios. ¡Añade uno desde el panel de administración!",
        no_news: "No hay noticias. ¡Añade una desde el panel de administración!",
        
        // Modal dinosaurios
        scientific_name: "Nombre científico:",
        discovery_year: "Año de descubrimiento:",
        period: "Período:",
        diet: "Dieta:",
        size: "Tamaño:",
        weight: "Peso:",
        description: "Descripción:",
        not_registered: "No registrado",
        
        // Modal noticias
        publication_date: "Fecha de publicación:",
        author: "Autor:",
        read_more: "Leer más →",
        
        // Paginación
        previous: "← Anterior",
        next: "Siguiente →",
        page: "Página",
        of: "de",
        
        // Footer
        footer_description: "La enciclopedia más completa de dinosaurios",
        quick_links: "Enlaces rápidos",
        privacy: "Política de privacidad",
        terms: "Términos de uso",
        cookies: "Política de cookies",
        follow_us: "Síguenos",
        support: "Apoya DinoForum",
        support_text: "Si te gusta el proyecto, invita a un café ☕",
        donate: "Donar con PayPal",
        footer_bottom: "Un viaje al pasado jurásico",
        
        // Badges
        dinosaur: "🦕 Dinosaurio",
        news: "📰 Noticia",
        
        // Botones
        previous_btn: "Anterior",
        next_btn: "Siguiente"
    },
    en: {
        // Navigation
        nav_home: "🏠 Home",
        nav_dinosaurs: "🦕 Dinosaurs",
        nav_news: "📰 News",
        
        // Titles
        home_subtitle: "Discover the latest news from the Jurassic world",
        new_section: "🆕 NEW",
        new_subtitle: "All recently added content",
        dinosaurs_subtitle: "Explore the lost world of prehistoric giants",
        news_subtitle: "Latest news from the Jurassic world",
        
        // Search and filters
        search_dinosaur: "Search dinosaur...",
        search_news: "Search by title...",
        all_periods: "📅 All periods",
        all_diets: "🍽️ All diets",
        reset: "Reset",
        filter_date: "Filter by date",
        
        // Content
        loading: "Loading content...",
        no_content: "No new content yet. Add dinosaurs or news from the admin panel!",
        no_dinosaurs: "No dinosaurs. Add one from the admin panel!",
        no_news: "No news. Add one from the admin panel!",
        
        // Modal dinosaurs
        scientific_name: "Scientific name:",
        discovery_year: "Year of discovery:",
        period: "Period:",
        diet: "Diet:",
        size: "Size:",
        weight: "Weight:",
        description: "Description:",
        not_registered: "Not registered",
        
        // Modal news
        publication_date: "Publication date:",
        author: "Author:",
        read_more: "Read more →",
        
        // Pagination
        previous: "← Previous",
        next: "Next →",
        page: "Page",
        of: "of",
        
        // Footer
        footer_description: "The most complete dinosaur encyclopedia",
        quick_links: "Quick links",
        privacy: "Privacy policy",
        terms: "Terms of use",
        cookies: "Cookie policy",
        follow_us: "Follow us",
        support: "Support DinoForum",
        support_text: "If you like the project, buy me a coffee ☕",
        donate: "Donate with PayPal",
        footer_bottom: "A journey to the Jurassic past",
        
        // Badges
        dinosaur: "🦕 Dinosaur",
        news: "📰 News",
        
        // Buttons
        previous_btn: "Previous",
        next_btn: "Next"
    }
};

// Idioma actual
let currentLang = 'es';

// Función para obtener texto traducido
function t(key) {
    return translations[currentLang][key] || key;
}

// Función para aplicar traducciones a elementos estáticos
function applyTranslations() {
    // Traducir elementos con data-i18n
    document.querySelectorAll('[data-i18n]').forEach(element => {
        const key = element.getAttribute('data-i18n');
        if (translations[currentLang][key]) {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.placeholder = translations[currentLang][key];
            } else {
                element.innerHTML = translations[currentLang][key];
            }
        }
    });
    
    // Traducir placeholders específicos
    document.querySelectorAll('[data-i18n-placeholder]').forEach(element => {
        const key = element.getAttribute('data-i18n-placeholder');
        if (translations[currentLang][key]) {
            element.placeholder = translations[currentLang][key];
        }
    });
    
    // Traducir opciones de select
    document.querySelectorAll('option[data-i18n]').forEach(option => {
        const key = option.getAttribute('data-i18n');
        if (translations[currentLang][key]) {
            option.textContent = translations[currentLang][key];
        }
    });
    
    // Actualizar clase activa en botones de idioma
    document.querySelectorAll('.lang-btn').forEach(btn => {
        if (btn.getAttribute('data-lang') === currentLang) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
    
    // Actualizar botones de paginación si existen
    updatePaginationButtons();
    
    // Guardar preferencia en localStorage
    localStorage.setItem('dinoforum_lang', currentLang);
}

// Función para actualizar textos de paginación
function updatePaginationButtons() {
    document.querySelectorAll('.pagination-controls button').forEach(btn => {
        if (btn.textContent.includes('Anterior') || btn.textContent.includes('Previous')) {
            btn.textContent = t('previous_btn');
        }
        if (btn.textContent.includes('Siguiente') || btn.textContent.includes('Next')) {
            btn.textContent = t('next_btn');
        }
    });
}

// Función para cambiar idioma
function setLanguage(lang) {
    if (translations[lang]) {
        currentLang = lang;
        applyTranslations();
        
        // Recargar contenido dinámico para actualizar textos del modal y paginación
        if (typeof cargarInicio === 'function') {
            cargarInicio();
        }
        if (typeof cargarDinosaurios === 'function' && window.paginaDinos) {
            cargarDinosaurios(window.paginaDinos || 1);
        }
        if (typeof cargarNoticias === 'function' && window.paginaNoticias) {
            cargarNoticias(window.paginaNoticias || 1);
        }
    }
}

// Inicializar selector de idioma
document.addEventListener('DOMContentLoaded', () => {
    // Cargar idioma guardado
    const savedLang = localStorage.getItem('dinoforum_lang');
    if (savedLang && translations[savedLang]) {
        currentLang = savedLang;
    }
    
    // Aplicar traducciones iniciales
    applyTranslations();
    
    // Configurar botones de idioma
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const lang = btn.getAttribute('data-lang');
            setLanguage(lang);
        });
    });
});