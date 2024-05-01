Bem-vindos à API sales . 

O que preciso para rodar minha api ? php , e acesso ao banco de dados postGree. 

# Rodar o banco no docker : 

##
docker run --name sales -e POSTGRESQL_USERNAME=admin -e POSTGRESQL_PASSWORD=admin -e POSTGRESQL_DATABASE=api_sales -p 5432:5432 bitnami/postgresql

## após clonar o projeto: 
no terminal do vsCode , rodar os seguintes comandos :
### php migrate.php - criar as tabelas
### php seeders/productSeeder.php - criação dos primeiros produtos.
### php seeders/userSeeder.php  - criação do usuário inicial .
### php seeders/PaymentSeeder.php - criação das formas de pagamento iniciais.

# End points da aplicação -

## users :
http://localhost/Sales/routes/users.php

## clients : 
http://localhost/Sales/routes/clients.php

## products:
http://localhost/Sales/routes/products.php

## payments:
http://localhost/Sales/routes/payments.php

## sales:
http://localhost/Sales/routes/sales.php

## Pontos de melhoria 
- Criação de authenticação 
- Envio de email para confirmação e alteração de senha
- Criação de middlewares
- Vincular venda ao vendedor para ter relatórios gerenciais de vendas
- Implementar multiplos produtos na mesma venda .
- Docker compose 
- Testes Unitários.

.