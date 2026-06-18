# Decisoes E Trade-offs

## Objetivo

Registrar as principais decisoes tecnicas do projeto, os motivos de cada escolha e em quais cenarios elas devem ser revisitadas.

## 1. Manter um monolito Laravel

Decisao:

- todo o sistema permanece em um unico projeto Laravel

Motivo:

- reduz carga operacional
- simplifica setup, deploy e manutencao
- favorece equipe pequena full stack

Trade-off:

- menos independencia tecnica entre modulos

Quando revisitar:

- se houver crescimento forte de complexidade por modulo
- se surgirem demandas de escalabilidade operacional separada

## 2. Usar Blade em vez de SPA

Decisao:

- renderizar a maior parte da interface no servidor

Motivo:

- menor atrito entre frontend e backend
- menos duplicacao de regras
- menor custo de manutencao

Trade-off:

- menos fluidez em interacoes muito ricas comparado a uma SPA

Quando revisitar:

- se a experiencia depender de interacoes densas no cliente

## 3. Usar Alpine.js apenas para interacoes leves

Decisao:

- reservar Alpine.js para toggles, menus e interacoes pequenas

Motivo:

- evita excesso de JavaScript
- mantem a interface simples

Trade-off:

- algumas interacoes podem exigir implementacao mais cuidadosa se crescerem demais

## 4. Usar SQLite em desenvolvimento

Decisao:

- manter ambiente local com arquivo unico de banco

Motivo:

- onboarding rapido
- execucao local simples

Trade-off:

- pode haver diferencas para o banco de producao em cenarios especificos

Recomendacao:

- validar comportamentos de producao em banco equivalente antes de publicacao

## 5. Priorizar testes de negocio

Decisao:

- testar autenticacao, distribuicao automatica, dashboard e CRUD principal

Motivo:

- maior retorno por esforco
- protege o que pode gerar regressao funcional relevante

Trade-off:

- nem toda view ou detalhe visual recebe teste dedicado

## 6. Manter permissao simples inicialmente

Decisao:

- autorizacao baseada apenas em autenticacao

Motivo:

- escopo atual nao exige matriz complexa de permissao
- evita criar regra nao confirmada

Trade-off:

- nao ha segregacao fina de acessos

Quando revisitar:

- se perfis, papeis ou limites de acesso forem formalmente definidos

## 7. Componentizacao progressiva da interface

Decisao:

- extrair componentes Blade reutilizaveis para campos, botoes, cards, badges e estrutura visual

Motivo:

- reduz repeticao
- melhora consistencia visual
- simplifica manutencao

Trade-off:

- abstrair cedo demais pode dificultar leitura

Regra pratica:

- extrair componente apenas quando houver reuso claro ou ganho concreto de padronizacao

## 8. Qualidade acima de quantidade

Decisao:

- preferir menos funcionalidades com melhor organizacao e teste

Motivo:

- protege evolucao sustentavel
- evita crescimento desordenado

## 9. Limitar complexidade antes de trocar de abordagem

Decisao:

- manter Blade como abordagem principal enquanto as telas permanecerem simples e centradas em fluxo server-side

Motivo:

- evita migracao prematura para uma arquitetura mais pesada
- preserva produtividade da equipe pequena

Trade-off:

- algumas interacoes mais avancadas podem exigir ajustes pontuais antes de justificar nova abordagem

Regra pratica:

- primeiro tentar resolver com Blade, componentes e interacoes leves
- so elevar a complexidade quando houver ganho claro e recorrente

## Resumo

As escolhas atuais privilegiam simplicidade, baixo atrito e capacidade de evolucao gradual. Os trade-offs foram aceitos conscientemente para favorecer uma equipe pequena e um produto com foco em fundamentos.
