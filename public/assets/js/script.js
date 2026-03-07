// Mode sombre
class DarkMode {
    constructor() {
        this.toggle = document.getElementById('darkToggle');
        this.init();
    }
    
    init() {
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
        
        this.toggle?.addEventListener('click', () => this.toggleDarkMode());
    }
    
    toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', 
            document.body.classList.contains('dark-mode') ? 'enabled' : 'disabled'
        );
    }
}

// Upload CV
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
            // Traitement du fichier
            console.log('Fichier accepté:', files[0].name);
        } else {
            alert('Veuillez uploader un fichier PDF');
        }
    }
}

// Recherche en temps réel
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
        // Appel AJAX pour la recherche
        fetch(`/api/search?q=${keyword}`)
            .then(response => response.json())
            .then(data => this.displayResults(data));
    }
    
    displayResults(data) {
        // Afficher les résultats
    }
}

// Notifications
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

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    new DarkMode();
    new FileUpload();
    new LiveSearch();
    
    // Confirmations de suppression
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
            }
        });
    });
});