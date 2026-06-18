# Arquitetura

## Objetivo

Este projeto foi estruturado para ser simples de executar localmente, simples de evoluir e viavel para manutencao por uma equipe pequena full stack.

O foco da arquitetura e:

- baixo atrito entre frontend e backend
- curva de aprendizado curta
- facilidade de onboarding
- organizacao suficiente para crescer sem burocracia excessiva
- cobertura de testes nas regras de negocio mais criticas

## Visao Geral

O sistema adota um monolito Laravel com renderizacao server-side.

Fluxo principal:

`Route -> Controller -> Form Request -> Service -> Model -> View`

Essa escolha reduz complexidade operacional e mantem todo o produto em uma unica base de codigo.

## Stack Escolhida

### Backend

- PHP 8.2+
- Laravel 12
- Eloquent ORM
- Laravel Breeze para autenticacao simples

### Frontend

- Blade
- TailwindCSS
- Alpine.js
- Vite

### Dados e Qualidade

- SQLite em desenvolvimento
- PHPUnit para testes

## Decisoes Arquiteturais

### 1. Monolito Laravel

Escolha:

- manter backend, frontend server-side, autenticacao, validacao e persistencia no mesmo projeto

Motivo:

- reduz custo cognitivo
- simplifica deploy e setup local
- evita sincronizacao entre multiplos repositorios
- favorece produtividade de equipe pequena

Quando revisitar:

- caso o produto passe a exigir escalabilidade operacional independente entre modulos
- caso o frontend precise de autonomia total como aplicacao separada

### 2. Blade + TailwindCSS + Alpine.js

Escolha:

- usar Blade para renderizacao
- TailwindCSS como base visual
- Alpine.js apenas para interacoes leves

Motivo:

- reduz atrito entre frontend e backend
- acelera entrega de telas administrativas e CRUDs
- evita custo de manter SPA separada para um produto simples
- facilita componentizacao visual sem excesso de infraestrutura

Quando revisitar:

- se surgirem fluxos muito interativos, em tempo real ou com estado complexo no cliente

### 3. Service Layer

Escolha:

- controllers enxutos
- validacao em Form Requests
- regra de negocio em Services

Motivo:

- melhora legibilidade
- facilita testes unitarios de regras criticas
- evita regra de negocio espalhada em controller, Blade ou JavaScript

### 4. Models com responsabilidade limitada

Escolha:

- usar models para entidade, relacionamentos, casts e consultas simples

Motivo:

- evita que o model vire um ponto concentrador de regras de negocio
- melhora separacao de responsabilidade

### 5. SQLite em desenvolvimento

Escolha:

- usar `database/database.sqlite` para execucao local

Motivo:

- elimina dependencia de configuracao externa para avaliacao e onboarding
- reduz tempo entre clonar e rodar o sistema

Trade-off:

- comportamento de banco local pode divergir de um banco relacional de producao em alguns cenarios mais avancados

### 6. Testes focados no nucleo

Escolha:

- priorizar testes de autenticacao, distribuicao automatica, dashboard e fluxos principais de chamados

Motivo:

- protege o comportamento critico sem inflar a suite com testes de baixo valor
- mantem equilibrio entre velocidade e seguranca

## Estrutura de Pastas

```text
app/
  Enums/
  Http/
    Controllers/
    Requests/
  Models/
  Services/

database/
  factories/
  migrations/
  seeders/

resources/
  css/
  js/
  views/
    auth/
    components/
    layouts/
    tickets/

tests/
  Feature/
  Unit/
```

## Responsabilidades por Camada

### Routes

- definem entradas HTTP
- conectam URLs aos controllers

### Controllers

- orquestram fluxo da requisicao
- delegam validacao e regra de negocio
- retornam views ou redirects

### Form Requests

- validam entradas
- centralizam regras de validacao

### Services

- concentram regras de negocio
- coordenam criacao, atualizacao, consulta e distribuicao

### Models

- representam entidades do dominio
- definem relacionamentos e casts

### Views e Components

- exibem dados
- compoem interface
- evitam regra de negocio

## Principios de Evolucao

- preferir simplicidade antes de abstracao
- introduzir nova camada apenas quando houver necessidade recorrente
- manter convencoes do Laravel como padrao
- priorizar componentizacao em interfaces repetidas
- documentar trade-offs relevantes

## O Que Esta Fora de Escopo por Enquanto

- SPA separada
- microservicos
- filas, eventos e processos assicronos complexos
- autorizacao detalhada por perfis e papeis
- design system sofisticado ou engenharia pesada de frontend

## Resumo

Esta arquitetura foi escolhida para maximizar previsibilidade, velocidade de manutencao e facilidade de execucao local. Ela privilegia fundamentos fortes, baixa complexidade operacional e uma base segura para evolucao gradual.
