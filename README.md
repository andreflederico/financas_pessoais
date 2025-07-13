Aqui está um **README.md completo** para seu projeto no GitHub, com instruções claras para colaboradores e garantia de consistência no desenvolvimento:

# Finanças Pessoais 100% Sob Controle

![Dashboard Preview](/public/assets/images/dashboard-preview.png)

Sistema de gerenciamento manual de orçamentos, cartões de crédito e investimentos com balanceamento automático.

## 🚀 Tecnologias
- **Backend**: PHP 8.1+ (MVC puro)
- **Frontend**: Bootstrap 5 + Chart.js
- **Banco de Dados**: MySQL 8+
- **Padrão**: RESTful (roteamento via `index.php`)

## 📦 Estrutura do Projeto
```
financas_pessoais/
├── app/
│   ├── Config/
│   │   ├── Database.php          # Configuração do banco de dados
│   │   └── Constants.php        # Constantes do sistema (cores, paths)
│   │
│   ├── Controllers/
│   │   ├── TransactionController.php # CRUD de transações + parcelamento
│   │   ├── InvestmentController.php # Aportes, proventos, relatórios
│   │   ├── CreditCardController.php # Faturas e limites
│   │   └── BudgetController.php    # Orçamentos e alertas
│   │
│   ├── Models/
│   │   ├── Transaction.php      # Lógica de transações e recorrências
│   │   ├── Investment.php       # Cálculos de alocação e rentabilidade
│   │   ├── CreditCard.php       # Fechamento de faturas
│   │   ├── Budget.php           # Monitoramento de orçamentos
│   │   └── User.php             # Autenticação e preferências
│   │
│   ├── Services/
│   │   ├── InvestmentService.php # Balanceamento de carteira
│   │   ├── RecurrenceService.php # Gerenciamento de transações recorrentes
│   │   └── ReportGenerator.php  # PDF/CSV de relatórios
│   │
│   ├── Views/
│   │   ├── transactions/
│   │   │   ├── list.php         # Listagem com filtros
│   │   │   └── form.php         # Formulário de lançamento
│   │   │
│   │   ├── investments/
│   │   │   ├── dashboard.php    # Gráfico de alocação
│   │   │   ├── income.php       # Registro de proventos
│   │   │   └── report.php       # Relatório YTD
│   │   │
│   │   ├── budgets/
│   │   │   ├── overview.php     # Progresso por categoria
│   │   │   └── alerts.php       # Alertas de gastos
│   │   │
│   │   └── layout/
│   │       ├── header.php       # Cabeçalho comum
│   │       ├── footer.php       # Rodapé com scripts
│   │       └── sidebar.php      # Menu navegação
│   │
│   └── Utils/
│       ├── helpers.php          # Funções globais (formatação, datas)
│       └── auth.php             # Controle de sessão
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   │   ├── app.css          # Estilos globais
│   │   │   └── charts.css       # Customização de gráficos
│   │   │
│   │   ├── js/
│   │   │   ├── app.js           # Funções gerais
│   │   │   ├── charts.js        # Interação com Chart.js
│   │   │   └── transactions.js  # Lógica de parcelamento
│   │   │
│   │   └── images/              # Ícones/logo
│   │
│   ├── index.php                # Ponto de entrada (roteamento)
│   └── .htaccess               # Rewrite rules (URL amigável)
│
├── database/
│   ├── migrations/              # Scripts de migração
│   │   ├── 2023_create_transactions_table.php
│   │   └── 2023_create_investments_table.php
│   │
│   ├── seeds/                   # Dados iniciais
│   │   ├── CategoriesSeeder.php
│   │   └── InvestmentTypesSeeder.php
│   │
│   └── financas.sql             # Backup do esquema completo
│
├── vendor/                      # Dependências (Composer)
│
├── .env                         # Variáveis de ambiente
├── composer.json                # Autoload e dependências
└── README.md                    # Guia de instalação
```

## 🔌 Pré-requisitos
- PHP 8.1+
- MySQL 8+
- Composer (para autoload)
- Node.js (opcional para assets)

## 🛠️ Instalação
1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/financas-pessoais.git
   ```
2. Configure o ambiente:
   ```bash
   cp .env.example .env
   # Edite .env com suas credenciais do MySQL
   ```
3. Instale dependências:
   ```bash
   composer install
   ```
4. Importe o banco de dados:
   ```bash
   mysql -u usuario -p financas_pessoais < database/financas.sql
   ```

## 🌈 Convenções de Código
### PHP
- Nomes de classes em `PascalCase`
- Métodos em `camelCase`
- Banco de dados: sempre use prepared statements
```php
// Bom
public function getTransactionsByDate(DateTime $date) { ... }

// Ruim
public function get_transactions($date) { ... }
```

### JavaScript
- Use `data-attributes` para interações DOM:
```html
<button data-action="delete-transaction" data-id="123">Excluir</button>
```

## 🧩 Módulos Principais
| Módulo           | Descrição                                  | Arquivos Chave                          |
|------------------|-------------------------------------------|-----------------------------------------|
| Transações       | CRUD com parcelamento e recorrência       | `app/Controllers/TransactionController` |
| Investimentos    | Balanceamento de carteira e proventos     | `app/Services/InvestmentService`        |
| Orçamentos       | Monitoramento por categoria               | `app/Models/Budget.php`                 |

## 🤝 Como Contribuir
1. Crie uma branch:
   ```bash
   git checkout -b feature/nova-funcionalidade
   ```
2. Siga o [Guia de Estilo](/docs/STYLE_GUIDE.md)
3. Envie um PR com:
   - Descrição da mudança
   - Screenshots (se aplicável)

## 📊 Exemplo de Consulta SQL
```sql
-- Relatório de proventos mensais
SELECT 
  MONTH(payment_date) AS mes,
  SUM(amount) AS total
FROM investment_income
WHERE YEAR(payment_date) = 2023
GROUP BY mes;
```

## 📌 Roadmap
- [ ] Importação de extratos via CSV (#12)
- [ ] Simulador de aposentadoria (#18)
- [ ] API RESTful (#25)

## 📧 Contato
Para dúvidas, abra uma **issue** ou contate:
[seu-email@exemplo.com](mailto:seu-email@exemplo.com)
