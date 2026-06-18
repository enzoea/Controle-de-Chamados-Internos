# Guia De Manutencao

## Objetivo

Este guia define como evoluir o sistema sem aumentar complexidade desnecessaria.

## Regras Gerais

- manter controllers enxutos
- usar Form Requests para validacao
- colocar regra de negocio em Services
- manter Models focados em entidade, relacionamentos, casts e consultas simples
- evitar regra de negocio em Blade e JavaScript
- componentizar apenas onde houver reuso ou ganho claro de padrao

## Padroes Internos

### Nomeacao

- requests: `StoreXRequest`, `UpdateXRequest`, `IndexXRequest`
- controllers: `XController`
- services de escrita: `XCreationService`, `XUpdateService`
- services de leitura: `XQueryService`
- enums: `XStatus`, `XPriority` ou nome equivalente do dominio
- componentes Blade: nome curto e sem ambiguidade, por exemplo `card`, `table`, `status-badge`

### Organizacao de views

- `layouts/` para estruturas base
- `components/` para elementos reutilizaveis
- `auth/` para autenticacao
- `tickets/` para o modulo de chamados

### Testes

- `tests/Unit/` para regra de negocio concentrada
- `tests/Feature/` para fluxo HTTP, autenticacao, validacao e comportamento funcional
- nomear testes com descricao direta do comportamento esperado

## Como Adicionar Uma Nova Feature

### 1. Definir o fluxo

Antes de codar, responder:

- qual o objetivo funcional
- quais telas serao impactadas
- quais regras de negocio serao alteradas
- existe risco de permissao, validacao ou performance

### 2. Criar ou ajustar as camadas certas

Use a seguinte referencia:

- `routes/` para rotas
- `app/Http/Controllers/` para orquestracao
- `app/Http/Requests/` para validacao
- `app/Services/` para regra de negocio
- `app/Models/` para persistencia e relacoes
- `resources/views/` para interface

### 3. Preferir convencao

Ao criar nova funcionalidade, seguir nomes previsiveis:

- `StoreXRequest`
- `UpdateXRequest`
- `XController`
- `XCreationService`
- `XUpdateService`
- `XQueryService`

## Quando Criar Um Novo Service

Criar service quando:

- houver regra de negocio real
- houver fluxo reutilizavel
- o controller estiver com comportamento demais

Nao criar service quando:

- a logica for apenas uma consulta simples e local
- a extracao gerar burocracia sem ganho de clareza

## Limites De Complexidade

### Quando uma tela pode continuar em Blade

Uma tela pode continuar em Blade quando:

- o fluxo e majoritariamente CRUD
- a interacao no cliente e simples
- o estado da tela depende principalmente do servidor
- a manutencao fica clara sem precisar de frontend separado

### Quando vale extrair componente

Extrair componente quando:

- o bloco aparece em mais de uma tela
- ha repeticao relevante de classes ou estrutura
- existe ganho de consistencia visual ou semantica

Nao extrair componente quando:

- o trecho existe em apenas um ponto
- a extracao adiciona indirecao sem ganho pratico

### Quando uma regra exige novo service

Criar novo service quando:

- a regra de negocio tem mais de um passo relevante
- a logica precisa ser reutilizada
- o controller comeca a acumular decisao de negocio
- a regra merece teste mais isolado

Nao criar novo service quando:

- a logica e apenas atribuicao simples de dados
- a consulta e direta e sem regra adicional
- a extracao nao melhora leitura nem reutilizacao

## Quando Criar Um Componente Blade

Criar componente quando:

- o bloco visual aparece em mais de uma tela
- existe ganho claro de consistencia
- o mesmo conjunto de classes se repete

Evitar criar componente quando:

- o trecho existe em um unico lugar
- a abstracao torna a leitura pior

## Organizacao De Views

- `layouts/` para estrutura macro
- `components/` para elementos reutilizaveis
- `tickets/` para telas do modulo de chamados
- `auth/` para autenticacao

## JavaScript

- manter Alpine.js apenas para interacoes leves
- evitar acumular logica complexa no frontend
- se uma interacao ficar rica demais, reavaliar abordagem

## Banco E Persistencia

- usar migrations para toda mudanca estrutural
- usar seeders para dados base do ambiente
- usar factories para apoio a testes

## Performance

- evitar queries complexas no controller
- considerar eager loading quando necessario
- revisar risco de N+1 em listagens e detalhes

## Documentacao Minima Para Novas Entregas

Toda feature nova deve registrar no minimo:

- objetivo da funcionalidade
- arquivos principais afetados
- trade-off assumido
- como testar manualmente
- se houve alteracao em regra de negocio

## Definicao De Pronto

Uma entrega deve buscar:

- funcionamento correto
- organizacao coerente com o padrao atual
- impacto visual consistente
- teste relevante quando houver risco de regressao
- documentacao se houver decisao tecnica nova
