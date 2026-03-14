// ===== MODE SOMBRE =====
class DarkMode {
    constructor() {
        this.toggle = document.getElementById('darkToggle');
        this.init();
    }
    
    init() {
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
        
        if (this.toggle) {
            this.toggle.addEventListener('click', () => this.toggleDarkMode());
        }
    }
    
    toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', 
            document.body.classList.contains('dark-mode') ? 'enabled' : 'disabled'
        );
    }
}

// ===== GESTION DES ONGLETS DANS LE DASHBOARD ADMIN =====
function showTab(tabId) {
    // Cacher tous les tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Désactiver tous les boutons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Afficher le tab sélectionné
    document.getElementById(tabId).classList.add('active');
    
    // Activer le bouton correspondant (celui qui a été cliqué)
    if (event && event.target) {
        event.target.classList.add('active');
    }
}

// ===== RECHERCHE UTILISATEURS (DASHBOARD ADMIN) =====
function initUserSearch() {
    const searchUsers = document.getElementById('searchUsers');
    
    if (searchUsers) {
        searchUsers.addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll('#users-tab tbody tr');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    }
}

// ===== UPLOAD CV =====
class FileUpload {
    constructor() {
        this.dropZone = document.getElementById('cvUpload');
        this.init();
    }
    
    init() {
        if (!this.dropZone) return;
        
        this.dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            this.dropZone.style.borderColor = 'var(--primary)';
        });
        
        this.dropZone.addEventListener('dragleave', () => {
            this.dropZone.style.borderColor = '';
        });
        
        this.dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            this.handleFiles(e.dataTransfer.files);
        });
    }
    
    handleFiles(files) {
        if (files[0]?.type === 'application/pdf') {
            console.log('Fichier accepté:', files[0].name);
            Notifications.show('CV uploadé avec succès !', 'success');
        } else {
            Notifications.show('Veuillez uploader un fichier PDF', 'danger');
        }
    }
}

// ===== RECHERCHE EN TEMPS RÉEL =====
class LiveSearch {
    constructor() {
        this.searchInput = document.getElementById('searchJobs');
        this.init();
    }
    
    init() {
        if (!this.searchInput) return;
        
        let timeout;
        this.searchInput.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => this.search(), 500);
        });
    }
    
    search() {
        const keyword = this.searchInput.value;
        // Simulation de recherche (à remplacer par un vrai appel AJAX)
        console.log('Recherche pour:', keyword);
        Notifications.show('Recherche en cours...', 'info');
    }
}

// ===== NOTIFICATIONS =====
class Notifications {
    static show(message, type = 'success') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas ${this.getIcon(type)}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
    
    static getIcon(type) {
        const icons = {
            success: 'fa-check-circle',
            danger: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        return icons[type] || icons.info;
    }
}

// ===== CONFIRMATIONS DE SUPPRESSION =====
function setupDeleteConfirmations() {
    document.querySelectorAll('.delete-btn, a[href*="delete"]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
            }
        });
    });
}

// ===== INITIALISATION GLOBALE =====
document.addEventListener('DOMContentLoaded', () => {
    new DarkMode();
    new FileUpload();
    new LiveSearch();
    initUserSearch();
    setupDeleteConfirmations();
});