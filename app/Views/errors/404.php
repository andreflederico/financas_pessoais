<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <!-- Ícone (usando Bootstrap Icons) -->
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#2E86AB"
                    class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
                    <path
                        d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.457A.5.5 0 0 1 0 11.104V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z" />
                    <path
                        d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                </svg>
            </div>

            <!-- Título e mensagem -->
            <h1 class="display-4 text-primary mb-3">404 - Página não encontrada</h1>
            <p class="lead mb-4">A página que você está procurando não existe ou foi movida.</p>

            <!-- Botão de ação -->
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="/" class="btn btn-primary btn-lg px-4 gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-house-door me-2" viewBox="0 0 16 16">
                        <path
                            d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z" />
                    </svg>
                    Voltar ao Início
                </a>

                <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                    </svg>
                    Voltar à Página Anterior
                </a>
            </div>

            <!-- Ajuda adicional -->
            <div class="mt-5 text-muted small">
                <p>Se você acredita que isto é um erro, entre em contato com o suporte.</p>
                <p class="mb-0">Código do erro: <span
                        class="badge bg-light text-dark">404_NOT_FOUND_<?= time() ?></span></p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>