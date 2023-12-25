# Laravel-Udemy

- Comando utilizado para inicializar o projeto: composer create-project --prefer-dist laravel/laravel app_super_gestao

### Artisan:


Comandos básicos artisan

* php artisan list                      -> Lista todos os comandos do artisan.
* php artisan serve                     -> Inicializa o localhost do laravel.
* php artisan down                      -> Coloca a aplicação em manutenção.
* php artisan up                        -> Retira a aplicação do modo de manutenção.
* php artisan make:controller {nome}    -> Cria um controlador.
* php artisan route:list                -> Lista todas as rotas da aplicação.
* php artisan view:clear                -> Limpa as views compiladas no cache.
* php artisan make:model                -> Cria um model, caso ele tenha como objetivo salvar dados no banco, acrescentar o comando '-m' para criar 
                                           uma migration (sempre criar models com o nome no singualar).


### Migrations

* php artisan migrate                   -> Executa uma migration.
* php artisan migrate:rollback          -> Reverte as alterações feitas pelas migrações.
* php artisan migrate:status            -> Mostra a situação de todas as migrações executadas.
* php artisan migrate:reset             -> Executa os métodos Down de todas as migrações executadas.
* php artisan migrate:refresh           -> Executa os métodos Down de todas as migrações, porém logo em seguida executa o migrate novamente.
* php artisan migrate:fresh             -> Realiza o Drop de todos os objetos de banco e em seguida executa o método Up de todas as migrações.


### Tinker

* php artisan tinker                    -> É um um console interativo que permite acessar e manipular as classes do projeto.
* $foo = \App\Models\{Class}::all()     -> Recupera todos os registros associados à determinada classe.

### Rotas:

##### Há quatro arquivos principais de rotas:

* API       -> Registra rotas de API's, não suportando cookies ou sessions.
* Channels  -> Registra rotas para comunicação broadcasting, ou seja, serve para utilizar comunicação em tempo real como websockets.
* Console   -> Serve para a criação de comandos personalizados que podem ser executados no Artisan.
* Web       -> Serve para trabalhar com rotas padrões web, carregando páginas no back-end e serviando-as ao client, suportando cookies e sessions.

### Controllers
~~~php
                ----------> Controller1 
                |                       {
                |                           action1()   
                |                           action2()   ----------------
Routes ---------|                           action3()                   |
                |                       }                               |
                |                                                       |
                |                                                       |------------> Views
                ----------> Controller2                                 |
                                        {                               |
                                            action1()                   |
                                            action2()   -----------------
                                            action3()
                                        }
~~~


### Seeders

* São responsáveis por semear o banco de dados da aplicação com os dados iniciais da configuração, ou dados de teste, definindo classes Seeders que conterão as instruções para semear as tabelas no banco de dados, essas classes podem ser chamadas pela classe DatabaseSeeder.
* php artisan make:seeder {nome}.
* php artisan db:seed -> executa as seeds.
* php artisan db:seed --class={nome}. -> executa uma seed em específico


### Factories

* Uma factory permite através de um seeder semear em massa uma tabela no banco de dados.
* php artisan make:factory {nome} --model={nome} -> Cria e define o modelo base para a factory