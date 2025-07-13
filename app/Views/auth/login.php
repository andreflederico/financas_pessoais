<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Acesse sua conta
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

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <form action="/login" method="POST" novalidate>
                        <!-- Campo Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= htmlspecialchars($_SESSION['form_data']['email'] ?? '') ?>" required>
                            <div class="invalid-feedback">Por favor, insira um email válido</div>
                        </div>

                        <!-- Campo Senha -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Por favor, insira sua senha</div>
                        </div>

                        <!-- Lembrar de mim e Esqueci a senha -->
                        <div class="d-flex justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Lembrar de mim</label>
                            </div>
                            <a href="/forgot-password" class="text-decoration-none">Esqueci minha senha</a>
                        </div>

                        <!-- Botão de Login -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Entrar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <p class="mb-0">Não tem uma conta? <a href="/register">Cadastre-se</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de interatividade -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar senha
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.getElementById('password');
        const icon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });

        // Validação do formulário
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>