# Laravel-Udemy

- Comando utilizado para inicializar o projeto: composer create-project --prefer-dist laravel/laravel app_super_gestao

### Artisan:
* php artisan list    -> Lista todos os comandos do artisan.
* php artisan serve   -> Inicializa o localhost do laravel.
* php artisan down    -> Coloca a aplicação em manutenção.
* php artisan up      -> Retira a aplicação do modo de manutenção.

### Rotas:

##### Há quatro arquivos principais de rotas:

* API       -> Registra rotas de API's, não suportando cookies ou sessions.
* Channels  -> Registra rotas para comunicação broadcasting, ou seja, serve para utilizar comunicação em tempo real como websockets.
* Console   -> Serve para a criação de comandos personalizados que podem ser executados no Artisan.
* Web       -> Serve para trabalhar com rotas padrões web, carregando páginas no back-end e serviando-as ao client, suportando cookies e sessions.

### Controllers:
                ----------> Controller1 
                |                       {
                |                           action1()
                |                           action2()
Routes ---------|                           action3()
                |                        }   
                |    
                |                    
                ----------> Controller2
                                        {
                                            action1()
                                            action2()
                                            action3()
                                        }

