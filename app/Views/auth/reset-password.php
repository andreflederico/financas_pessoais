<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-shield-lock me-2"></i>
                        Redefinir Senha
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Mensagens de status -->
                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <!-- Formulário de redefinição -->
                    <form action="/reset-password" method="POST" id="resetForm">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
                        <div class="mb-3">
                            <label for="password" class="form-label">Nova Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required
                                    minlength="8" placeholder="Mínimo 8 caracteres">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar"></div>
                                </div>
                                <small class="text-muted strength-text"></small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirme a Nova Senha</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required placeholder="Digite a senha novamente">
                            <div class="invalid-feedback feedback-mismatch">
                                As senhas não coincidem
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-key-fill me-2"></i>
                                Redefinir Senha
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="/login" class="text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Voltar ao Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para validação -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar senha
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    });

    // Validação de força da senha
    const passwordInput = document.getElementById('password');
    const strengthBar = document.querySelector('.progress-bar');
    const strengthText = document.querySelector('.strength-text');

    passwordInput.addEventListener('input', function() {
        const strength = calculatePasswordStrength(this.value);
        strengthBar.style.width = strength.percentage + '%';
        strengthBar.className = 'progress-bar ' + strength.class;
        strengthText.textContent = strength.text;
        strengthText.className = 'text-muted strength-text ' + strength.textClass;
    });

    // Validação de correspondência de senhas
    const form = document.getElementById('resetForm');
    const passwordConfirm = document.getElementById('password_confirmation');

    form.addEventListener('submit', function(e) {
        if (passwordInput.value !== passwordConfirm.value) {
            e.preventDefault();
            passwordConfirm.classList.add('is-invalid');
        }
    });

    passwordConfirm.addEventListener('input', function() {
        if (passwordInput.value === this.value) {
            this.classList.remove('is-invalid');
        }
    });

    function calculatePasswordStrength(password) {
        let strength = 0;
        // Critérios de força
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;

        const classes = ['bg-danger', 'bg-warning', 'bg-info', 'bg-primary', 'bg-success'];
        const texts = ['Muito fraca', 'Fraca', 'Moderada', 'Forte', 'Muito forte'];
        const textClasses = ['text-danger', 'text-warning', 'text-info', 'text-primary', 'text-success'];

        return {
            percentage: strength * 25,
            class: classes[strength - 1] || 'bg-danger',
            text: texts[strength - 1] || 'Muito fraca',
            textClass: textClasses[strength - 1] || 'text-danger'
        };
    }
});
</script>

<style>
.password-strength {
    display: <?=isset($_SESSION['error']) ? 'block': 'none'?>;
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>