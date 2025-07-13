    </main>

    <!-- Rodapé -->
    <footer class="bg-light mt-auto py-3 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <span class="text-muted">
                        <i class="bi bi-c-circle"></i> <?= date('Y') ?> Finanças Pessoais
                    </span>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-muted">
                        v1.0.0 |
                        <a href="/sobre" class="text-decoration-none">Sobre</a> |
                        <a href="/termos" class="text-decoration-none">Termos</a>
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle com Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts Customizados -->
    <script src="/assets/js/app.js"></script>

    <?php if (isset($scripts)): ?>
    <!-- Scripts específicos da página -->
    <?php foreach ($scripts as $script): ?>
    <script src="<?= $script ?>"></script>
    <?php endforeach; ?>
    <?php endif; ?>
    </body>

    </html>