<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-person-plus me-2"></i>
                        Criar Nova Conta
                    </h3>
                </div>

                <div class="card-body">
                    <!-- Mensagens de feedback -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['form_data'])): ?>
                        <?php $old = $_SESSION['form_data'];
                        unset($_SESSION['form_data']); ?>
                    <?php endif; ?>

                    <form action="/register" method="POST" id="registerForm" novalidate>
                        <div class="row g-3">
                            <!-- Nome Completo -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?= htmlspecialchars($old['name'] ?? '') ?>" required minlength="3">
                                <div class="invalid-feedback">Por favor, insira seu nome completo</div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                                <div class="invalid-feedback">Por favor, insira um email válido</div>
                            </div>

                            <!-- Senha -->
                            <div class="col-md-6">
                                <label for="password" class="form-label">Senha</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required
                                        minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$">
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <small class="text-muted">
                                    Mínimo 8 caracteres, com letras maiúsculas, minúsculas e números
                                </small>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar" role="progressbar"></div>
                                </div>
                            </div>

                            <!-- Confirmar Senha -->
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                                <div class="invalid-feedback">As senhas não coincidem</div>
                            </div>

                            <!-- Termos e Condições -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Concordo com os <a href="/terms" target="_blank">Termos de Serviço</a> e
                                        <a href="/privacy" target="_blank">Política de Privacidade</a>
                                    </label>
                                    <div class="invalid-feedback">Você deve aceitar os termos</div>
                                </div>
                            </div>

                            <!-- Botão de Registro -->
                            <div class="col-12 mt-4">
                                <button class="btn btn-primary w-100 py-2" type="submit">
                                    <i class="bi bi-person-check me-2"></i>
                                    Criar Conta
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <p class="mb-0">Já tem uma conta? <a href="/login">Faça login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Validação e Interatividade -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registerForm');

        // Mostrar/ocultar senha
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.closest('.input-group').querySelector('input');
                const icon = this.querySelector('i');
                input.type = input.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });

        // Validar força da senha
        const passwordInput = document.getElementById('password');
        const progressBar = document.querySelector('.progress-bar');

        passwordInput.addEventListener('input', function() {
            const strength = calculatePasswordStrength(this.value);
            progressBar.style.width = strength.percentage + '%';
            progressBar.className = 'progress-bar ' + strength.class;
        });

        // Validar correspondência de senhas
        document.getElementById('password_confirmation').addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        // Validação do formulário
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);

        function calculatePasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            const classes = ['bg-danger', 'bg-warning', 'bg-info', 'bg-primary', 'bg-success'];
            return {
                percentage: strength * 25,
                class: classes[strength - 1] || 'bg-danger'
            };
        }
    });
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>