<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success" id="successAlert">
        <i class="fas fa-check-circle"></i>
        <?= $_SESSION['success'] ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger" id="errorAlert">
        <i class="fas fa-exclamation-circle"></i>
        <?= $_SESSION['error'] ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<style>
.alert {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    color: white;
    font-weight: 500;
    z-index: 9999;
    animation: slideIn 0.3s ease-out;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    max-width: 400px;
}

.alert-success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.alert-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.alert i {
    margin-right: 8px;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}
</style>

<script>
// Disparaître après 3 secondes
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.animation = 'fadeOut 0.5s ease-out forwards';
        setTimeout(() => alert.remove(), 500);
    });
}, 3000);
</script>