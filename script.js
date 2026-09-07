// ==================== VARIABLES ====================
let currentLang = 'es';
let paginaDinos = 1;
let paginaNoticias = 1;
let totalPaginasDinos = 1;
let totalPaginasNoticias = 1;
let totalDinosauriosGlobal = 0;

// ==================== FUNCIONES AUXILIARES ====================
function escapeHtml(texto) {
    if (!texto) return '';
    const div = document.createElement('div');
    div.textContent = texto;
    return div.innerHTML;
}

function stripHtml(html) {
    if (!html) return '';
    const tmp = document.createElement('div');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '';
}

function getImagenUrl(imagen) {
    if (imagen && imagen !== '' && imagen !== null) {
        return `img/${imagen}`;
    }
    return 'img/garra.png';
}

// ==================== FUNCIONES DE IDIOMA ====================
function getNombreDino(dino) {
    if (currentLang === 'es') {
        return dino.nombre || 'Sin nombre';
    } else {
        return dino.nombre_en || dino.nombre || 'No name';
    }
}

function getPeriodoDino(dino) {
    if (currentLang === 'es') {
        return dino.periodo || '?';
    } else {
        return dino.periodo_en || dino.periodo || '?';
    }
}

function getDietaDino(dino) {
    if (currentLang === 'es') {
        return dino.dieta || '?';
    } else {
        return dino.dieta_en || dino.dieta || '?';
    }
}

function getTamanoDino(dino) {
    if (currentLang === 'es') {
        return dino.tamano || 'No especificado';
    } else {
        return dino.tamano_en || dino.tamano || 'Not specified';
    }
}

function getPesoDino(dino) {
    if (currentLang === 'es') {
        return dino.peso || 'No especificado';
    } else {
        return dino.peso_en || dino.peso || 'Not specified';
    }
}

function getDescripcionDino(dino) {
    if (currentLang === 'es') {
        return dino.descripcion || 'No hay descripción.';
    } else {
        return dino.descripcion_en || dino.descripcion || 'No description.';
    }
}

function getTituloNoticia(noticia) {
    if (currentLang === 'es') {
        return noticia.titulo || 'Sin título';
    } else {
        return noticia.titulo_en || noticia.titulo || 'No title';
    }
}

function getContenidoNoticia(noticia) {
    if (currentLang === 'es') {
        return noticia.contenido || 'Sin contenido.';
    } else {
        return noticia.contenido_en || noticia.contenido || 'No content.';
    }
}

// ==================== TRADUCCIONES ====================
const textos = {
    es: {
        nav_home: "🏠 Inicio", nav_dinosaurs: "🦕 Dinosaurios", nav_news: "📰 Noticias",
        home_subtitle: "Descubre las últimas novedades del mundo jurásico", new_section: "🆕 NUEVO", new_subtitle: "Todo el contenido recién añadido",
        dinosaurs_subtitle: "Explora el mundo perdido de los gigantes prehistóricos", news_subtitle: "Últimas novedades del mundo jurásico",
        search_dinosaur: "Buscar dinosaurio...", search_news: "Buscar por título...", all_periods: "📅 Todos los períodos", all_diets: "🍽️ Todas las dietas",
        reset: "Restablecer", loading: "Cargando contenido...", footer_description: "La enciclopedia más completa de dinosaurios",
        quick_links: "Enlaces rápidos", privacy: "Política de privacidad", terms: "Términos de uso", cookies: "Política de cookies",
        follow_us: "Síguenos", support: "Apoya DinoForum", support_text: "Si te gusta el proyecto, invita a un café ☕", donate: "Donar con PayPal",
        footer_bottom: "Un viaje al pasado jurásico", prev: "← Anterior", next: "Siguiente →", page: "Página", of: "de",
        read_more: "Leer más →", scientific_name: "Nombre científico:", discovery_year: "Año de descubrimiento:", period: "Período:",
        diet: "Dieta:", size: "Tamaño:", weight: "Peso:", description: "Descripción:", publication_date: "Fecha de publicación:",
        author: "Autor:", not_registered: "No registrado", dinosaur: "🦕 Dinosaurio", news: "📰 Noticia",
        dinosaurs_total: "dinosaurios en total", showing: "mostrando"
    },
    en: {
        nav_home: "🏠 Home", nav_dinosaurs: "🦕 Dinosaurs", nav_news: "📰 News",
        home_subtitle: "Discover the latest news from the Jurassic world", new_section: "🆕 NEW", new_subtitle: "All recently added content",
        dinosaurs_subtitle: "Explore the lost world of prehistoric giants", news_subtitle: "Latest news from the Jurassic world",
        search_dinosaur: "Search dinosaur...", search_news: "Search by title...", all_periods: "📅 All periods", all_diets: "🍽️ All diets",
        reset: "Reset", loading: "Loading content...", footer_description: "The most complete dinosaur encyclopedia",
        quick_links: "Quick links", privacy: "Privacy policy", terms: "Terms of use", cookies: "Cookie policy",
        follow_us: "Follow us", support: "Support DinoForum", support_text: "If you like the project, buy me a coffee ☕", donate: "Donate with PayPal",
        footer_bottom: "A journey to the Jurassic past", prev: "← Previous", next: "Next →", page: "Page", of: "of",
        read_more: "Read more →", scientific_name: "Scientific name:", discovery_year: "Year of discovery:", period: "Period:",
        diet: "Diet:", size: "Size:", weight: "Weight:", description: "Description:", publication_date: "Publication date:",
        author: "Author:", not_registered: "Not registered", dinosaur: "🦕 Dinosaur", news: "📰 News",
        dinosaurs_total: "dinosaurs total", showing: "showing"
    }
};

function aplicarTraducciones() {
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (textos[currentLang][key]) {
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                el.placeholder = textos[currentLang][key];
            } else {
                el.innerHTML = textos[currentLang][key];
            }
        }
    });
    document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
        const key = el.getAttribute('data-i18n-placeholder');
        if (textos[currentLang][key]) {
            el.placeholder = textos[currentLang][key];
        }
    });
    document.querySelectorAll('option[data-i18n]').forEach(opt => {
        const key = opt.getAttribute('data-i18n');
        if (textos[currentLang][key]) {
            opt.textContent = textos[currentLang][key];
        }
    });
}

// ==================== CAMBIO DE IDIOMA ====================
function setLanguage(lang) {
    if (lang !== 'es' && lang !== 'en') return;
    currentLang = lang;
    localStorage.setItem('dinoforum_lang', lang);
    
    document.querySelectorAll('.lang-btn').forEach(btn => {
        if (btn.getAttribute('data-lang') === lang) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
    
    aplicarTraducciones();
    
    cargarInicio();
    cargarDinosaurios(paginaDinos);
    cargarNoticias(paginaNoticias);
}

// ==================== MENÚ HAMBURGUESA ====================
document.addEventListener('DOMContentLoaded', () => {
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const sidebarNav = document.getElementById('sidebarNav');
    const body = document.body;
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', (e) => {
            e.stopPropagation();
            hamburgerMenu.classList.toggle('open');
            sidebarNav.classList.toggle('open');
            body.classList.toggle('menu-open');
        });
    }
    document.addEventListener('click', (e) => {
        if (sidebarNav && sidebarNav.classList.contains('open') && 
            !sidebarNav.contains(e.target) && 
            !hamburgerMenu.contains(e.target)) {
            hamburgerMenu.classList.remove('open');
            sidebarNav.classList.remove('open');
            body.classList.remove('menu-open');
        }
    });
    
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const sectionId = link.getAttribute('data-section');
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active-section'));
            document.getElementById(sectionId).classList.add('active-section');
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            link.classList.add('active');
            hamburgerMenu.classList.remove('open');
            sidebarNav.classList.remove('open');
            body.classList.remove('menu-open');
            if (sectionId === 'dinosaurios') cargarDinosaurios(1);
            if (sectionId === 'noticias') cargarNoticias(1);
            if (sectionId === 'inicio') cargarInicio();
        });
    });
    
    const savedLang = localStorage.getItem('dinoforum_lang');
    if (savedLang === 'es' || savedLang === 'en') {
        currentLang = savedLang;
    }
    
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            setLanguage(btn.getAttribute('data-lang'));
        });
        if (btn.getAttribute('data-lang') === currentLang) {
            btn.classList.add('active');
        }
    });
    
    aplicarTraducciones();
    cargarInicio();
    cargarDinosaurios(1);
    cargarNoticias(1);
    
    document.querySelector('.close-modal')?.addEventListener('click', () => {
        document.getElementById('modal').style.display = 'none';
    });
    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('modal')) {
            document.getElementById('modal').style.display = 'none';
        }
    });
});

// ==================== INICIO ====================
async function cargarInicio() {
    const grid = document.getElementById('inicioGrid');
    if (!grid) return;
    grid.innerHTML = '<div class="loading"><div class="dino-loader"></div><p>' + textos[currentLang].loading + '</p></div>';
    try {
        const res = await fetch('obtener_inicio.php');
        const data = await res.json();
        if (data.success && data.items && data.items.length > 0) {
            grid.innerHTML = data.items.map(item => {
                const esDino = item.tipo === 'dinosaurio';
                let nombreMostrar;
                let periodoTxt;
                let dietaTxt;
                let descripcionPreview;
                
                if (esDino) {
                    nombreMostrar = getNombreDino(item);
                    periodoTxt = getPeriodoDino(item);
                    dietaTxt = getDietaDino(item);
                    descripcionPreview = stripHtml(getDescripcionDino(item)).substring(0, 100);
                } else {
                    nombreMostrar = getTituloNoticia(item);
                    descripcionPreview = stripHtml(getContenidoNoticia(item)).substring(0, 100);
                }
                
                const fecha = new Date(item.fecha).toLocaleDateString(currentLang === 'es' ? 'es-ES' : 'en-US', {
                    year: 'numeric', month: 'long', day: 'numeric'
                });
                const badge = esDino ? textos[currentLang].dinosaur : textos[currentLang].news;
                const imagenUrl = getImagenUrl(item.imagen);
                
                return `<div class="inicio-card" onclick="${esDino ? `verDetalleDino(${item.id})` : `verDetalleNoticia(${item.id})`}">
                    <div class="inicio-card-badge ${item.tipo}">${badge}</div>
                    <div class="inicio-card-icon"><img src="${imagenUrl}" style="width:60px" onerror="this.src='img/garra.png'"></div>
                    <div class="inicio-card-info">
                        <h3>${escapeHtml(nombreMostrar)}</h3>
                        ${esDino ? `<div><span>📅 ${periodoTxt}</span> | <span>🍽️ ${dietaTxt}</span></div>` : ''}
                        <p>${escapeHtml(descripcionPreview)}...</p>
                        <div><i class="fas fa-calendar-alt"></i> ${fecha}</div>
                    </div>
                </div>`;
            }).join('');
        } else {
            grid.innerHTML = '<div class="no-results"><img src="img/garra.png" style="width:80px"><p>' + textos[currentLang].loading + '</p></div>';
        }
    } catch (error) {
        console.error('Error cargando inicio:', error);
        grid.innerHTML = '<div class="no-results"><img src="img/garra.png" style="width:80px"><p>Error de conexión</p></div>';
    }
}

// ==================== DINOSAURIOS ====================
async function cargarDinosaurios(pagina = 1) {
    paginaDinos = pagina;
    const grid = document.getElementById('dinoGrid');
    if (!grid) return;
    grid.innerHTML = '<div class="loading"><div class="dino-loader"></div><p>' + textos[currentLang].loading + '</p></div>';
    
    const periodo = document.getElementById('filterPeriodo')?.value || '';
    const dieta = document.getElementById('filterDieta')?.value || '';
    const busqueda = document.getElementById('searchDinoInput')?.value || '';
    
    let url = `obtener_dinos.php?pagina=${pagina}&periodo=${encodeURIComponent(periodo)}&dieta=${encodeURIComponent(dieta)}&busqueda=${encodeURIComponent(busqueda)}`;
    
    try {
        const res = await fetch(url);
        const data = await res.json();
        if (data.success) {
            totalPaginasDinos = data.total_paginas || 1;
            const dinos = data.dinosaurios || [];
            
            // ACTUALIZAR CONTADORES
            if (data.total) {
                totalDinosauriosGlobal = data.total;
                document.getElementById('totalDinosCount').innerText = totalDinosauriosGlobal;
                document.getElementById('dinoCounterText').innerHTML = textos[currentLang].dinosaurs_total;
            }
            
            const hayFiltros = periodo !== '' || dieta !== '' || busqueda !== '';
            if (hayFiltros) {
                document.getElementById('filteredDinoCounter').style.display = 'flex';
                document.getElementById('filteredDinosCount').innerText = dinos.length;
                document.getElementById('filteredDinoText').innerHTML = textos[currentLang].showing;
            } else {
                document.getElementById('filteredDinoCounter').style.display = 'none';
            }
            
            if (dinos.length === 0) {
                grid.innerHTML = '<div class="no-results"><img src="img/garra.png" style="width:80px"><p>' + (currentLang === 'es' ? 'No hay dinosaurios.' : 'No dinosaurs.') + '</p></div>';
            } else {
                grid.innerHTML = dinos.map(dino => {
                    const imagenUrl = getImagenUrl(dino.imagen);
                    const nombre = getNombreDino(dino);
                    const periodoTxt = getPeriodoDino(dino);
                    const dietaTxt = getDietaDino(dino);
                    const descripcionPreview = stripHtml(getDescripcionDino(dino)).substring(0, 100);
                    return `<div class="dino-card" onclick="verDetalleDino(${dino.id})">
                        <div class="dino-card-icon"><img src="${imagenUrl}" style="width:60px" onerror="this.src='img/garra.png'"></div>
                        <div class="dino-info">
                            <h2>${escapeHtml(nombre)}</h2>
                            <div><span class="dino-badge badge-periodo">📅 ${periodoTxt}</span><span class="dino-badge badge-dieta">🍽️ ${dietaTxt}</span></div>
                            <p>${escapeHtml(descripcionPreview)}...</p>
                        </div>
                    </div>`;
                }).join('');
            }
            actualizarPaginacion('dinoPagination', pagina, totalPaginasDinos, 'dinosaurios');
        } else {
            grid.innerHTML = '<div class="no-results"><img src="img/garra.png" style="width:80px"><p>Error</p></div>';
        }
    } catch (error) {
        console.error('Error cargando dinosaurios:', error);
        grid.innerHTML = '<div class="no-results"><img src="img/garra.png" style="width:80px"><p>Error de conexión</p></div>';
    }
}

// ==================== NOTICIAS ====================
async function cargarNoticias(pagina = 1) {
    paginaNoticias = pagina;
    const grid = document.getElementById('noticiasGrid');
    if (!grid) return;
    grid.innerHTML = '<div class="loading"><div class="dino-loader"></div><p>' + textos[currentLang].loading + '</p></div>';
    try {
        const res = await fetch(`obtener_noticias.php?pagina=${pagina}`);
        const data = await res.json();
        if (data.success) {
            totalPaginasNoticias = data.total_paginas || 1;
            const noticias = data.noticias || [];
            if (noticias.length === 0) {
                grid.innerHTML = '<div class="no-results"><img src="img/garra.png" style="width:80px"><p>' + textos[currentLang].loading + '</p></div>';
            } else {
                grid.innerHTML = noticias.map(noticia => {
                    const imagenUrl = getImagenUrl(noticia.imagen);
                    const titulo = getTituloNoticia(noticia);
                    const contenidoPreview = stripHtml(getContenidoNoticia(noticia)).substring(0, 150);
                    return `<div class="noticia-card" onclick="verDetalleNoticia(${noticia.id})">
                        ${noticia.imagen ? `<div class="noticia-imagen-mini"><img src="${imagenUrl}" style="width:100%; height:150px; object-fit:cover; border-radius:10px" onerror="this.src='img/garra.png'"></div>` : ''}
                        <div class="noticia-header"><h3>${escapeHtml(titulo)}</h3><span>${noticia.fecha}</span></div>
                        <div class="noticia-body"><p>${escapeHtml(contenidoPreview)}...</p><small>${escapeHtml(noticia.autor || 'Admin')}</small></div>
                        <button class="ver-mas-btn">${textos[currentLang].read_more}</button>
                    </div>`;
                }).join('');
            }
            actualizarPaginacion('noticiasPagination', pagina, totalPaginasNoticias, 'noticias');
        } else {
            grid.innerHTML = '<div class="no-results"><img src="img/garra.png" style="width:80px"><p>Error</p></div>';
        }
    } catch (error) {
        console.error('Error cargando noticias:', error);
        grid.innerHTML = '<div class="no-results"><img src="img/garra.png" style="width:80px"><p>Error de conexión</p></div>';
    }
}

// ==================== DETALLES ====================
async function verDetalleDino(id) {
    try {
        const res = await fetch(`obtener_dinos.php?id=${id}`);
        const data = await res.json();
        const dino = data.dinosaurios?.[0];
        if (!dino) return;
        const imagenUrl = getImagenUrl(dino.imagen);
        const nombre = getNombreDino(dino);
        const nombreCientifico = currentLang === 'es' ? (dino.nombre_cientifico || textos[currentLang].not_registered) : (dino.nombre_cientifico_en || dino.nombre_cientifico || textos[currentLang].not_registered);
        const periodo = getPeriodoDino(dino);
        const dieta = getDietaDino(dino);
        const tamano = getTamanoDino(dino);
        const peso = getPesoDino(dino);
        const descripcionHtml = getDescripcionDino(dino).replace(/\n/g, '<br>');
        
        const modal = document.getElementById('modalBody');
        modal.innerHTML = `<h2><i class="fas fa-bone"></i> ${escapeHtml(nombre)}</h2>
            <div class="modal-flex">
                <div class="modal-text">
                    <div class="modal-info">
                        <p><strong>${textos[currentLang].scientific_name}</strong> ${escapeHtml(nombreCientifico)}</p>
                        <p><strong>${textos[currentLang].discovery_year}</strong> ${escapeHtml(dino.anio_descubrimiento || textos[currentLang].not_registered)}</p>
                        <p><strong>${textos[currentLang].period}</strong> ${periodo}</p>
                        <p><strong>${textos[currentLang].diet}</strong> ${dieta}</p>
                        <p><strong>${textos[currentLang].size}</strong> ${tamano}</p>
                        <p><strong>${textos[currentLang].weight}</strong> ${peso}</p>
                    </div>
                    <div class="modal-desc"><strong>${textos[currentLang].description}</strong><div>${descripcionHtml}</div></div>
                </div>
                <div class="modal-image"><img src="${imagenUrl}" style="max-width:250px" onerror="this.src='img/garra.png'"></div>
            </div>`;
        document.getElementById('modal').style.display = 'flex';
    } catch (error) {
        console.error(error);
    }
}

async function verDetalleNoticia(id) {
    try {
        const res = await fetch(`obtener_noticias.php?id=${id}`);
        const data = await res.json();
        const noticia = data.noticias?.[0];
        if (!noticia) return;
        const imagenUrl = getImagenUrl(noticia.imagen);
        const titulo = getTituloNoticia(noticia);
        const contenidoHtml = getContenidoNoticia(noticia).replace(/\n/g, '<br>');
        const fecha = new Date(noticia.fecha).toLocaleDateString(currentLang === 'es' ? 'es-ES' : 'en-US', {
            year: 'numeric', month: 'long', day: 'numeric'
        });
        
        const modal = document.getElementById('modalBody');
        modal.innerHTML = `<h2><i class="fas fa-newspaper"></i> ${escapeHtml(titulo)}</h2>
            <div class="modal-flex noticia-modal">
                <div class="modal-text noticia-contenido">
                    <div class="modal-info"><p><strong>${textos[currentLang].publication_date}</strong> ${fecha}</p><p><strong>${textos[currentLang].author}</strong> ${escapeHtml(noticia.autor || 'Admin')}</p></div>
                    <div class="noticia-texto-completo">${contenidoHtml}</div>
                </div>
                <div class="modal-image noticia-imagen"><img src="${imagenUrl}" style="max-width:250px" onerror="this.src='img/garra.png'"></div>
            </div>`;
        document.getElementById('modal').style.display = 'flex';
    } catch (error) {
        console.error(error);
    }
}

// ==================== PAGINACIÓN ====================
function actualizarPaginacion(containerId, actual, total, tipo) {
    const container = document.getElementById(containerId);
    if (!container || total <= 1) {
        if (container) container.innerHTML = '';
        return;
    }
    container.innerHTML = `<div class="pagination-controls">
        ${actual > 1 ? `<button onclick="cambiarPagina(${actual-1}, '${tipo}')">${textos[currentLang].prev}</button>` : ''}
        <span>${textos[currentLang].page} ${actual} ${textos[currentLang].of} ${total}</span>
        ${actual < total ? `<button onclick="cambiarPagina(${actual+1}, '${tipo}')">${textos[currentLang].next}</button>` : ''}
    </div>`;
}

function cambiarPagina(pagina, tipo) {
    if (tipo === 'dinosaurios') {
        cargarDinosaurios(pagina);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else if (tipo === 'noticias') {
        cargarNoticias(pagina);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

// ==================== FILTROS ====================
document.getElementById('filterPeriodo')?.addEventListener('change', () => cargarDinosaurios(1));
document.getElementById('filterDieta')?.addEventListener('change', () => cargarDinosaurios(1));
document.getElementById('searchDinoInput')?.addEventListener('input', () => cargarDinosaurios(1));

let busquedaNoticias = '', fechaFiltro = '';
document.getElementById('searchNoticiaInput')?.addEventListener('input', (e) => {
    busquedaNoticias = e.target.value;
    cargarNoticias(1);
});
document.getElementById('filterFecha')?.addEventListener('change', (e) => {
    fechaFiltro = e.target.value;
    cargarNoticias(1);
});
document.getElementById('resetNoticiaFilters')?.addEventListener('click', () => {
    document.getElementById('searchNoticiaInput').value = '';
    document.getElementById('filterFecha').value = '';
    busquedaNoticias = '';
    fechaFiltro = '';
    cargarNoticias(1);
});