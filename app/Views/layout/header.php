<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finanças Pessoais | <?= $title ?? 'Controle Financeiro' ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- CSS Customizado -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-piggy-bank me-2"></i>
                Finanças Pessoais
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/' ? 'active' : '' ?>" href="/">
                            <i class="bi bi-house-door me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/transacoes') ? 'active' : '' ?>"
                            href="/transacoes">
                            <i class="bi bi-cash-stack me-1"></i> Transações
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/investimentos') ? 'active' : '' ?>"
                            href="/investimentos">
                            <i class="bi bi-graph-up me-1"></i> Investimentos
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= htmlspecialchars($_SESSION['user']['name']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/perfil"><i class="bi bi-person me-2"></i>Perfil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="/logout" method="POST">
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container Principal -->
    <main class="container my-4 flex-grow-1">
        <!-- Mensagens Flash -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>