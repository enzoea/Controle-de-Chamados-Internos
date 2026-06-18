# Qualidade E Testes

## Objetivo

Definir uma estrategia de qualidade pragmatica para um sistema simples, mantido por equipe pequena.

## Principios

- qualidade acima de quantidade
- testes focados no que protege negocio
- evitar suite grande com baixo valor
- manter legibilidade e previsibilidade do codigo

## O Que Deve Ser Testado Primeiro

### Regras de negocio

- atribuicao automatica
- criterios de desempate
- comportamento quando nao houver elegiveis

### Fluxos principais

- login e logout
- acesso ao dashboard
- cadastro de chamado
- edicao de chamado
- filtros da listagem
- visualizacao detalhada

### Integridade de dados

- validacoes essenciais
- comportamento de seeders

## O Que Pode Ficar Em Segundo Plano

- detalhes visuais sem impacto funcional
- pequenas variacoes de layout
- testes excessivos de implementacao interna

## Tipos De Teste Usados No Projeto

### Testes unitarios

Usados para regras de negocio puras ou com baixo acoplamento.

Exemplo atual:

- `TicketAssignmentServiceTest`

### Testes de feature

Usados para garantir fluxo HTTP, autenticacao, validacao e renderizacao principal.

Exemplos atuais:

- autenticacao
- dashboard
- CRUD principal de chamados
- listagem e filtros

## Boas Praticas Para Novos Testes

- testar comportamento, nao implementacao
- cobrir regra critica antes de detalhe opcional
- manter nome do teste explicito
- usar factories e seeders para reduzir ruido
- nao criar testes apenas para inflar cobertura

## Definicao De Cobertura Suficiente

Uma entrega possui cobertura suficiente quando:

- a regra de negocio principal esta protegida
- o fluxo principal da funcionalidade foi validado
- erros de validacao relevantes foram cobertos

## Qualidade De Codigo

Ao evoluir o sistema, revisar:

- controller esta fino
- request valida o que precisa validar
- service concentra regra relevante
- view nao contem regra de negocio
- nao houve duplicacao desnecessaria

## Checklist De Revisao

Antes de concluir uma entrega, verificar:

- a funcionalidade atende o comportamento esperado
- o codigo segue o padrao atual do projeto
- existe teste quando a mudanca tem risco relevante
- o README ou `docs/` precisa registrar nova decisao
- houve impacto visual indevido em outras telas

## Pragmatismo

Nem toda mudanca exige novos testes. O criterio deve ser risco de regressao e importancia da regra alterada. Em um time pequeno, o objetivo e proteger o essencial sem desacelerar a evolucao do produto.
