## Instruções

Com o docker e docker-compose instalado e configurado, rodar a sequencia de comandos abaixo:

    docker-compose up -d --build api
    cd src
    docker-compose run --rm composer install
    cp env.example .env
    docker-compose run --rm artisan key:generate
    docker-compose run --rm artisan migrate:fresh --seed

Abraços,

Marcos
