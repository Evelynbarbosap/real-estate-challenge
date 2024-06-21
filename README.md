
# Setup Docker Laravel 10 com PHP 8.1

### Passo a passo
Clone Repositório
```sh
git clone -b https://github.com/Evelynbarbosap/real-estate-challenge.git
```
```sh
cd real-estate-challenge
```

Crie o Arquivo .env
```sh
cp .env.example .env
```


Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME="Real Estate Challenge"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acesse o container app
```sh
docker-compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```


Gere a key do projeto Laravel
```sh
php artisan key:generate
```


Gere os seeds
```sh
php artisan db:seed
```


Acesse o projeto pelo postman/insomnia/outro de sua preferência
[http://localhost:8989](http://localhost:8989)


Endpoints:

Tarefas de um edifício junto com seus comentários.
```sh
GET http://localhost:8989/api/v1//buildings/{building}/tasks?status=completed  # /api/tasks?assigned_to=1  ||  /api/tasks?start_date=2024-01-01&end_date=2024-06-20 || ?status=completed
```

Criar um novo comentário para uma tarefa.
```sh
POST http://localhost:8989/api/v1/tasks/{task}/comments
```
payload: 
```sh 
{
    "comment": "Comentário exemplo",
    "user_id": 1
}
```

Criar uma nova tarefa.
```sh
POST http://localhost:8989/api/v1/tasks/building/{building}
```

payload: 
```sh 
{
    "title": "Titulo exemplo",
    "description": "Descrição exemplo",
    "assigned_to": 2,
    "status": "Informe o status desejado", # 'open', 'progress', 'completed', 'rejected'
    "due_date": "Y-m-d"
}

```


Gere os testes unitários
```sh
php artisan test
```


PRINTS DAS ENDPOINTS
GET Tarefas de um edifício junto com seus comentários.
![image](https://github.com/Evelynbarbosap/real-estate-challenge/assets/38754479/74877a22-e510-4b20-8950-d9d970943e91)

POST Criar um novo comentário para uma tarefa.
![image](https://github.com/Evelynbarbosap/real-estate-challenge/assets/38754479/483f38e1-804b-462e-a4c5-1d2ffc2c6cc2)

POST Criar uma nova tarefa.
![image](https://github.com/Evelynbarbosap/real-estate-challenge/assets/38754479/a594f80d-3716-46e1-aee0-a4922455c104)

TESTE UNITÁRIO
![image](https://github.com/Evelynbarbosap/real-estate-challenge/assets/38754479/0ff622c5-59d4-410f-bfdc-46448ba18e0a)



