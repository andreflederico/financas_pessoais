<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Redefinir Senha</h4>
                </div>

                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <form action="/forgot-password" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email cadastrado</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="Digite o email da sua conta">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-envelope-fill me-2"></i> Enviar Link de Redefinição
                            </button>

                            <a href="/login" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Voltar ao Login
                            </a>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-muted small">
                    <p class="mb-0">Enviaremos um link para redefinir sua senha. O link expira em 1 hora.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>