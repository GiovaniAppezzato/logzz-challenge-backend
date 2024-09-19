<p align="center">
    <a href="https://www.logzz.com.br" target="_blank"> 
        <img src="./public/logzz.svg" width="200" style="margin-bottom: 30px;">    
    </a>
</p>

## 📝 Introdução

Olá! Este repositório contém a minha solução para o desafio da Logzz. Trata-se de um sistema simples de cadastro de produtos, com o comando para importar uma base de dados de outra api utilizando Laravel e Next.js.

Se precisar entrar em contato, você pode me encontrar no [LinkedIn](https://www.linkedin.com/in/giovani-appezzato/), pelo e-mail giovani.appezzato@gmail.com ou no número (19) 99494-7867.

Deploy do frontend: https://giovani-appezzato-challenge-logzz.vercel.app/sign-in

Deploy da api: https://logzz.giovani-appezzato.com.br/api/test-connection

## 🚀 Começando

Siga as **instruções** abaixo para configurar o ambiente e rodar o backend do projeto localmente. Existem duas formas de instalar o projeto: com Docker utilizando Laravel Sail e sem Docker.

### 📋 Pré-requisitos

Antes de começar, verifique se você possui as seguintes dependências instaladas. Caso contrário, faça o download e instale-as para prosseguir:

* [Git](https://git-scm.com/downloads) 
* [NPM](https://www.npmjs.com/)
* [Composer](https://getcomposer.org/)
* [PHP ^8.2](https://www.php.net/releases/8.2/en.php)
* [Docker (Opcional)](https://www.docker.com/)

### 🐳 Instalação (com Docker e Laravel Sail)

Se você optar por rodar o projeto usando Docker, essa é a abordagem recomendada, especialmente se estiver em um ambiente Linux. Para usuários do Windows, é necessário utilizar o [WSL 2 (Windows Subsystem for Linux)](https://learn.microsoft.com/pt-br/windows/wsl/install)  em conjunto com o Docker Desktop. Caso contrário, pule para a instalação do projeto sem o Docker.

1. Clone o repositório:

``` bash
git clone https://github.com/GiovaniAppezzato/logzz-challenge-backend
```

2. Navegue até a pasta do projeto e execute o comando para instalar todas as dependências necessárias:

``` bash
composer install
```

Caso não tenha o Composer instalado localmente, você pode utilizar o seguinte comando para instalar as dependências diretamente no container do Laravel Sail:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

3. Crie o arquivo de configuração copiando o exemplo fornecido:

``` bash
cp .env.example .env
```

4. Abra o arquivo `.env` e configure as variáveis de ambiente conforme necessário. Certifique-se de configurar corretamente as informações necessárias para a aplicação:

``` bash
APP_URL=http://localhost
APP_PORT=8001

...

QUEUE_CONNECTION=database

...

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
# FORWARD_DB_PORT=33062
```

Descomente a linha FORWARD_DB_PORT caso já tenha um MySQL rodando na porta 3306 da sua máquina.


5. Inicie os containers Docker usando o Laravel Sail:

``` bash
./vendor/bin/sail up -d
```

6. Crie a APP_KEY do projeto:

``` bash
./vendor/bin/sail artisan key:generate
```

7. Execute as migrations para criar as tabelas no banco de dados:

``` bash
./vendor/bin/sail artisan migrate
```

8. Crie um link simbólico para visualizar os uploads pelo frontend:

``` bash
./vendor/bin/sail artisan storage:link
```

9. Inicie os workers com o comando abaixo:

``` bash
./vendor/bin/sail artisan queue:work
```

10. Para finalizar, importe os dados via comando customizado proposto pelo teste:

``` bash
./vendor/bin/sail artisan products:import  

# Ou

./vendor/bin/sail artisan products:import --id=1
```

11. Pronto! o projeto estará rodando em um ambiente Dockerizado, pronto para ser utilizado localmente acessando o [localhost](http://localhost:8001)

### 🔧 Instalação (sem Docker)

1. Clone o repositório:

``` bash
git clone https://github.com/GiovaniAppezzato/logzz-challenge-backend
```

2. Instale as dependências necessárias:

``` bash
composer install
```

3. Crie o arquivo de configuração copiando o exemplo fornecido:

``` bash
cp .env.example .env
```

4. Abra o arquivo `.env` e configure as variáveis de ambiente conforme necessário. Certifique-se de configurar corretamente as informações do banco de dados:

``` bash
QUEUE_CONNECTION=database

...

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Como alternativa, você pode usar o banco de dados local [SQLite](https://www.sqlite.org/):

``` bash
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

5. Crie a APP_KEY do projeto:

``` bash
php artisan key:generate
```

6. Execute as migrations para criar as tabelas no banco de dados:

``` bash
php artisan migrate
```

7. Crie um link simbólico para conseguir visualizar os uploads:

``` bash    
php artisan storage:link
```

8. Inicie os workers com o comando abaixo:

``` bash
php artisan queue:work
```

9. Para finalizar, importe os dados via comando customizado proposto pelo teste:

``` bash
php artisan products:import  

# Ou

php artisan products:import --id=1
```

10. Inicie o servidor local do Laravel:

``` bash
php artisan serve
```

11. Pronto! O projeto estará rodando localmente no endereço IP fornecido pelo terminal após a inicialização do servidor.
