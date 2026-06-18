# Sistema de Controle de Chamados Internos

Aplicacao web para registro, distribuicao e acompanhamento de chamados internos, desenvolvida com Laravel.

## Inicio Rapido

Antes de iniciar, voce precisa ter instalado na maquina:

- `PHP 8.2+`
- `Composer`
- `Node.js`
- `NPM`

Para rodar o sistema pela primeira vez:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
npm run build
php artisan serve --host=127.0.0.1 --port=8082
```

No Windows PowerShell:

```powershell
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
if (-not (Test-Path database/database.sqlite)) { New-Item database/database.sqlite -ItemType File }
php artisan migrate --seed
npm run build
php artisan serve --host=127.0.0.1 --port=8082
```

Apos isso, acesse:

- Aplicacao: [http://127.0.0.1:8082/](http://127.0.0.1:8082/)
- Login: [http://127.0.0.1:8082/login](http://127.0.0.1:8082/login)

## Stack

- Backend: `PHP`, `Laravel 12`, `Eloquent ORM`, `Laravel Breeze`
- Frontend: `Blade`, `TailwindCSS`, `Alpine.js`
- Banco em desenvolvimento: `SQLite`
- Testes: `PHPUnit`
- Build frontend: `Vite`

## Documentacao Tecnica

- Indice da documentacao: `docs/README.md`
- Arquitetura: `docs/arquitetura.md`
- Decisoes e trade-offs: `docs/decisoes-e-tradeoffs.md`
- Guia de manutencao: `docs/guia-de-manutencao.md`
- Qualidade e testes: `docs/qualidade-e-testes.md`

## Trade-offs Registrados

### Blade + Alpine em vez de SPA

Escolha:

- usar renderizacao server-side com `Blade`
- usar `Alpine.js` apenas para interacoes leves

Motivos:

- reduz atrito entre frontend e backend
- mantem a equipe trabalhando em uma base unica
- acelera entregas de CRUD, dashboards e telas administrativas
- simplifica manutencao para equipe pequena

Trade-off:

- menos fluidez para interacoes muito ricas comparado a uma SPA completa

### SQLite em desenvolvimento

Escolha:

- usar `SQLite` no ambiente local

Motivos:

- onboarding mais rapido
- execucao simples sem dependencias externas
- menor custo de setup para avaliacao e manutencao

Trade-off:

- algumas diferencas podem existir entre ambiente local e banco de producao

### Permissao simples por enquanto

Escolha:

- manter o acesso baseado apenas em autenticacao

Motivos:

- o escopo atual nao detalha matriz formal de perfis e papeis
- evita criar regra de autorizacao nao confirmada
- reduz complexidade inicial

Trade-off:

- o sistema ainda nao possui segregacao fina de acesso por perfil

## Requisitos

- `PHP 8.2+`
- `Composer`
- `Node.js` e `NPM`

## Instalacao

1. Instale as dependencias PHP:

```bash
composer install
```

2. Instale as dependencias frontend:

```bash
npm install
```

3. Crie o arquivo de ambiente:

```bash
cp .env.example .env
```

No Windows PowerShell, use:

```powershell
Copy-Item .env.example .env
```

4. Gere a chave da aplicacao:

```bash
php artisan key:generate
```

5. Garanta que o arquivo do banco SQLite exista:

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

No Windows PowerShell, use:

```powershell
if (-not (Test-Path database/database.sqlite)) { New-Item database/database.sqlite -ItemType File }
```

6. Execute migrations e seeders:

```bash
php artisan migrate --seed
```

## Execucao Local

O frontend precisa estar compilado para a interface funcionar corretamente. Use uma das opcoes abaixo:

- `npm run dev`: para desenvolvimento local com recompilacao automatica
- `npm run build`: para gerar os assets uma vez e depois subir a aplicacao

Se esta rodando o projeto pela primeira vez e nao vai deixar o Vite aberto, execute antes:

```bash
npm run build
```

Depois, suba a aplicacao na porta padronizada do projeto:

```bash
php artisan serve --host=127.0.0.1 --port=8082
```

Se quiser desenvolvimento com assets em tempo real, rode em outro terminal:

```bash
npm run dev
```

Para build de producao dos assets:

```bash
npm run build
```

## Acesso

- Aplicacao: [http://127.0.0.1:8082/](http://127.0.0.1:8082/)
- Login: [http://127.0.0.1:8082/login](http://127.0.0.1:8082/login)

## Credenciais Iniciais

Administrador:

- E-mail: `admin@example.com`
- Senha: `password`

Usuarios responsaveis:

- `enzoea256@gmail.com` / `123456`
- `leonardo.pai@example.com` / `123456`
- `bianca.scoralick@example.com` / `123456`

## Fluxos Implementados

- Login e logout
- Dashboard com indicadores de total, abertos, em andamento, resolvidos e fechados
- Cadastro de chamado
- Edicao de chamado
- Alteracao de status
- Listagem de chamados
- Filtros por status, prioridade e responsavel
- Visualizacao detalhada
- Distribuicao automatica por menor carga com desempate por menor ID

## Banco De Dados

- Desenvolvimento: `SQLite`
- Arquivo local: `database/database.sqlite`
- Nao existe um servidor de banco separado para subir localmente nesse setup
- O banco passa a funcionar assim que o arquivo `database/database.sqlite` existe e as migrations sao executadas
- Ou seja: com o fluxo documentado no README, o banco ja fica pronto para uso junto com a aplicacao

Se precisar reiniciar a base local do zero:

```bash
php artisan migrate:fresh --seed
```

## Testes

Executar toda a suite:

```bash
php artisan test
```

Executar apenas um grupo especifico:

```bash
php artisan test --filter=TicketAssignmentServiceTest
php artisan test --filter=CreateTicketTest
php artisan test --filter=UpdateTicketTest
php artisan test --filter=ListTicketsTest
php artisan test --filter=ShowTicketTest
php artisan test --filter=ViewDashboardTest
```

## Estrutura Principal

```text
app
├── Enums
├── Http
│   ├── Controllers
│   └── Requests
├── Models
└── Services

database
├── factories
├── migrations
└── seeders

resources
└── views
    ├── auth
    ├── components
    ├── layouts
    └── tickets

tests
├── Feature
└── Unit
```

## Observacoes

- O projeto utiliza `SQLite` para facilitar avaliacao local sem configuracao adicional.
- A aplicacao foi organizada no fluxo `Controller -> Form Request -> Service -> Model`.
- As regras de distribuicao automatica possuem cobertura de testes.
