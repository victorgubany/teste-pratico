Configurações de sistema :
0. renomear o arquivo .env.example para .env e executar o comando php artisan key:generate
1. no arquivo .env deverá ser posta as credenciais do banco de dados. Segue o exemplo:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teste1
DB_USERNAME=root
DB_PASSWORD=
2. rodar o comando no terminal "composer install"
3. rodar o comando no terminal "php artisan migrate"
4. rodar o comando no terminal para iniciar a aplicação "php artisan serve"

Para ser iniciado 

Primeiro é necessario registrar um usuario com isso iremos no endpoint http://127.0.0.1:8000/api/register e passaremos em um metodo post o body com email, password, name

segundo lugar e pegar as credenciais 
http://127.0.0.1:8000/api/login, e passaremos o corpo da requisição como email e password.
o endpoint retornará um token, esse token deverá ser posto no header das requisições como authorization: bearer (token)

A partir desse momento todas as rotas vão precisar ter o authorization com o token no header

Primeiro deverá ser criado uma categoria:
http://127.0.0.1:8000/api/categorie/create, requisição post com o body "name".

Apos isso podemos listar as categorias para pegar o id de mesma:
http://127.0.0.1:8000/api/categorie/list requisição get

criar tarefa
http://127.0.0.1:8000/api/task/create nessa rota, podemos mandar uma requisição post com o body contendo name e categorie,
sendo que o name é o nome da tarefa e o categorie é o id que aprendemos a buscar no passo anterior

listar tarefas
http://127.0.0.1:8000/api/task/list, podemos fazer uma solicitação get, podemos também usar o query parameter para filtrar as tarefas por categoria exemplo : http://127.0.0.1:8000/api/task/list?categorie=2

deletar tarefa 
http://127.0.0.1:8000/api/task/delete, requisição post com o id da tarefa, só poderá ser feito pelo usuario que criou


atualizar tarefa

http://127.0.0.1:8000/api/task/update, requisição post com id e status, 
status são 0->pendente 1->concluido 2->em andamento

