Aqui está um **README.md completo** para seu projeto no GitHub, com instruções claras para colaboradores e garantia de consistência no desenvolvimento:

```markdown
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
├── app/               # Lógica da aplicação (MVC)
├── public/            # Arquivos acessíveis publicamente
├── database/          # Migrações e seeds
├── vendor/            # Dependências do Composer
└── .env.example       # Variáveis de ambiente
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

```

### 🔍 Detalhes Importantes para Inclusão:
1. **Adicione screenshots** na pasta `/public/assets/images/`:
   - `dashboard-preview.png` (600x400px)
   - `mobile-view.png` (opcional)

2. **Crie o arquivo `/docs/STYLE_GUIDE.md`** com:
   ```markdown
   # Guia de Estilo
   ## Cores Primárias
   - Azul: `#2E86AB` (botões primários)
   - Verde: `#4CAF50` (valores positivos)
   ```

3. **Inclua um exemplo de `.env`**:
   ```ini
   DB_HOST=localhost
   DB_NAME=financas
   DB_USER=root
   DB_PASS=
   ```

Quer que eu gere algum arquivo adicional (como o `STYLE_GUIDE.md` completo) ou ajuste algo específico no README?
