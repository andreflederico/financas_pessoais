Aqui está o **`STYLE_GUIDE.md`** completo para seu projeto, garantindo consistência no desenvolvimento:

# Guia de Estilo - Finanças Pessoais

## 🎨 Design System
### Cores
| Tipo          | Hexadecimal | Uso                  |
|---------------|-------------|----------------------|
| Primária      | `#2E86AB`   | Botões, cabeçalhos   |
| Sucesso       | `#4CAF50`   | Receitas, confirmação|
| Alerta        | `#F44336`   | Despesas, erros      |
| Fundo         | `#F5F5F5`   | Background           |
| Texto         | `#333333`   | Cor principal        |

### Tipografia
- **Fonte Principal**: `'Segoe UI', Roboto, sans-serif`
- Tamanhos:
  - Títulos: `1.8rem`
  - Corpo: `1rem`
  - Labels: `0.875rem`

## 💻 Código Frontend
### HTML
- Semântico + Bootstrap 5:
```html
<!-- Bom -->
<div class="card shadow-sm">
  <h2 class="card-header text-primary">Transações</h2>
</div>

<!-- Ruim -->
<div class="caixa">
  <div class="titulo-azul">...</div>
</div>
```

### CSS
- Prefixar classes com módulo:
```css
/* Bom */
.transaction-card { ... }
.transaction-card--active { ... }

/* Ruim */
.card-1 { ... }
.active { ... }
```

### JavaScript
- Use `data-attributes` para interações:
```javascript
// Bom
document.querySelector('[data-action="delete-transaction"]');

// Ruim
document.getElementById('btn-delete-123');
```

## 🔧 Código Backend
### PHP (PSR-12)
- Nomes de classes:
```php
// Bom
class TransactionController { ... }

// Ruim
class transacao_controller { ... }
```

- Métodos:
```php
// Bom
public function calculateInstallments(float $value): array { ... }

// Ruim
public function calc_parcelas($valor) { ... }
```

### Banco de Dados
- Convenções:
  - Tabelas: `snake_case` (ex: `investment_income`)
  - Campos: `snake_case` (ex: `payment_date`)

- Exemplo de query:
```php
// Bom (prepared statements)
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ?");
$stmt->execute([$userId]);

// Ruim (SQL injection)
$query = "SELECT * FROM transactions WHERE user_id = $userId";
```

## 📂 Estrutura de Arquivos
### Views
- Organização por módulo:
```
/Views
  /transactions
    list.php    # Listagem
    form.php    # Formulário
  /investments
    dashboard.php
```

### Convenção de Nomes
| Tipo          | Padrão          | Exemplo                     |
|---------------|-----------------|-----------------------------|
| Controller    | PascalCase      | `TransactionController.php` |
| Model         | PascalCase      | `CreditCard.php`            |
| View          | snake_case      | `annual_report.php`         |

## ✅ Boas Práticas
1. **Tratamento de Erros**
   - Use exceções específicas:
   ```php
   throw new InsufficientBalanceException('Saldo insuficiente');
   ```

2. **Logging**
   - Registre ações críticas:
   ```php
   error_log("[DELETE] Transação ID: $id removida");
   ```

3. **Segurança**
   - Sempre valide inputs:
   ```php
   filter_var($input, FILTER_SANITIZE_STRING);
   ```

## 🛠️ Ferramentas Recomendadas
- **PHP CS Fixer**: Para padronização de código
- **ESLint**: Análise JS
- **DBDiagram**: Modelagem do banco

✏️ **Manutenção**: Atualize este guia conforme novas convenções forem adotadas.
