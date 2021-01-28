# Teste Backend

## Requisitos
Para rodar essa aplicação você precisará do PHP 7.4, Composer e MySQL. Além disso, são necessárias as extensões do PHP para utilizar o framework Laravel 8, você pode conferir elas [aqui](https://laravel.com/docs/7.x/installation#server-requirements).

## Instalação
Após clonar o repositório para sua máquina, entre em seu diretório e instale as dependências usando o composer: 
```sh
$ composer install
```
Depois disso, copie o arquivo `.env.example` para `.env` e gere a chave da aplicação.
```sh
$ cp .env.example .env
$ php artisan key:generate
```

Crie um banco de dados MySQL e insira os detalhes da conexão no arquivo `.env`
```dotenv
DB_DATABASE=example_database
DB_USERNAME=example_user
DB_PASSWORD=qwe123
```

## Rodando o servidor

Utilize o seguinte comando para iniciar o servidor:
```sh
$ php artisan serve
```

Todos os endpoints da API são prefixados com `/apí` e suas documentações estão disponíveis em `http://localhost:8000/swagger/`
