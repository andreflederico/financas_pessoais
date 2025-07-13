<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#overview" data-bs-toggle="tab">
                            <i class="bi bi-speedometer2 me-2"></i> Visão Geral
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#transactions" data-bs-toggle="tab">
                            <i class="bi bi-cash-stack me-2"></i> Transações
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#investments" data-bs-toggle="tab">
                            <i class="bi bi-graph-up me-2"></i> Investimentos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#budgets" data-bs-toggle="tab">
                            <i class="bi bi-pie-chart me-2"></i> Orçamentos
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Financeiro</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-calendar me-1"></i> <?= date('F Y') ?>
                        </button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#newTransactionModal">
                        <i class="bi bi-plus-circle me-1"></i> Nova Transação
                    </button>
                </div>
            </div>

            <div class="tab-content">
                <!-- Visão Geral -->
                <div class="tab-pane fade show active" id="overview">
                    <div class="row">
                        <!-- Saldo Atual -->
                        <div class="col-md-4 mb-4">
                            <div class="card text-white bg-primary h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Saldo Atual</h5>
                                    <h2 class="card-text">R$ <?= number_format($balance, 2, ',', '.') ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Receitas do Mês -->
                        <div class="col-md-4 mb-4">
                            <div class="card text-white bg-success h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Receitas (<?= date('m/Y') ?>)</h5>
                                    <h2 class="card-text">R$ <?= number_format($monthlyIncome, 2, ',', '.') ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Despesas do Mês -->
                        <div class="col-md-4 mb-4">
                            <div class="card text-white bg-danger h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Despesas (<?= date('m/Y') ?>)</h5>
                                    <h2 class="card-text">R$ <?= number_format($monthlyExpenses, 2, ',', '.') ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Gráfico de Despesas por Categoria -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">Despesas por Categoria</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="expensesChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Próximas Faturas -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">Próximas Faturas</h5>
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <?php foreach ($upcomingBills as $bill): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1"><?= htmlspecialchars($bill['description']) ?></h6>
                                                    <small class="text-muted">Vence em
                                                        <?= date('d/m', strtotime($bill['due_date'])) ?></small>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">R$
                                                    <?= number_format($bill['amount'], 2, ',', '.') ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aba de Transações -->
                <div class="tab-pane fade" id="transactions">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Últimas Transações</h5>
                            <div>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Filtrar..."
                                        id="transactionSearch">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Descrição</th>
                                            <th>Categoria</th>
                                            <th class="text-end">Valor</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($transactions as $transaction): ?>
                                            <tr>
                                                <td><?= date('d/m/Y', strtotime($transaction['date'])) ?></td>
                                                <td><?= htmlspecialchars($transaction['description']) ?></td>
                                                <td>
                                                    <span class="badge"
                                                        style="background-color: <?= $transaction['category_color'] ?>">
                                                        <?= htmlspecialchars($transaction['category_name']) ?>
                                                    </span>
                                                </td>
                                                <td
                                                    class="text-end <?= $transaction['type'] === 'income' ? 'text-success' : 'text-danger' ?>">
                                                    <?= $transaction['type'] === 'income' ? '+' : '-' ?>
                                                    R$ <?= number_format($transaction['amount'], 2, ',', '.') ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aba de Investimentos -->
                <div class="tab-pane fade" id="investments">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">Alocação de Ativos</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="allocationChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">Performance</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="performanceChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aba de Orçamentos -->
                <div class="tab-pane fade" id="budgets">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Seus Orçamentos</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Categoria</th>
                                            <th>Orçamento</th>
                                            <th>Gasto</th>
                                            <th>Progresso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($budgets as $budget): ?>
                                            <tr>
                                                <td>
                                                    <span class="badge" style="background-color: <?= $budget['color'] ?>">
                                                        <?= htmlspecialchars($budget['category']) ?>
                                                    </span>
                                                </td>
                                                <td>R$ <?= number_format($budget['amount'], 2, ',', '.') ?></td>
                                                <td>R$ <?= number_format($budget['spent'], 2, ',', '.') ?></td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar 
                                                        <?= $budget['percentage'] > 90 ? 'bg-danger' : ($budget['percentage'] > 70 ? 'bg-warning' : 'bg-success') ?>"
                                                            role="progressbar" style="width: <?= $budget['percentage'] ?>%"
                                                            aria-valuenow="<?= $budget['percentage'] ?>" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            <?= round($budget['percentage']) ?>%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nova Transação -->
<div class="modal fade" id="newTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Transação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="transactionForm">
                    <div class="mb-3">
                        <label class="form-label">Tipo</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="type" id="typeIncome" value="income"
                                autocomplete="off">
                            <label class="btn btn-outline-success" for="typeIncome">Receita</label>

                            <input type="radio" class="btn-check" name="type" id="typeExpense" value="expense"
                                autocomplete="off" checked>
                            <label class="btn btn-outline-danger" for="typeExpense">Despesa</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Valor</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Categoria</label>
                        <select class="form-select" id="category" name="category_id" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" data-color="<?= $category['color'] ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Data</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?= date('Y-m-d') ?>"
                            required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveTransaction">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts do Dashboard -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de Despesas por Categoria
        const expensesCtx = document.getElementById('expensesChart').getContext('2d');
        const expensesChart = new Chart(expensesCtx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode(array_column($expensesByCategory, 'category')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($expensesByCategory, 'amount')) ?>,
                    backgroundColor: <?= json_encode(array_column($expensesByCategory, 'color')) ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });

        // Gráfico de Alocação de Investimentos
        const allocationCtx = document.getElementById('allocationChart').getContext('2d');
        const allocationChart = new Chart(allocationCtx, {
            type: 'pie',
            data: {
                labels: <?= json_encode(array_column($investmentAllocation, 'type')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($investmentAllocation, 'percentage')) ?>,
                    backgroundColor: [
                        '#2E86AB', '#4CAF50', '#FFC107', '#F44336', '#9C27B0'
                    ]
                }]
            }
        });

        // Salvar nova transação via AJAX
        document.getElementById('saveTransaction').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('transactionForm'));

            fetch('/transactions', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erro: ' + data.message);
                    }
                });
        });
    });
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>