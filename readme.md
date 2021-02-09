# Пример обработки HTTP

Этот репозиторий содержит 
[целый плейлист на youtube](https://www.youtube.com/watch?v=_yIflB_pgXo&list=PL7Nh93imVuXwJ0bYlpfu84MhwQmDoSOia)
объясняющий основы обработки http запросов, плейлист может со временем пополнятся.

## Dev окружение

Для запуска требуется:
1. [Docker engine](https://docs.docker.com/install/)
2. [Docker compose](https://docs.docker.com/compose/install/)

### Запуск dev окружения

```
docker-compose up -d
```

На dev окружение доступен hot reload изменений.

## Build for production

Перед сборкой укажите корректный image, чтобы туда пушить изменения.
```
vim docker/docker-compose-builder.yml
```

Сборка
```
./build.sh
```

Теперь образ запущен - **это самый простой пример вы можете его доработать под себя**

## Example production

Что использовать на продакшене это целиком ваш выбор (kubernate, swarm, ...) и его **поддержка**.

Главное что у вас есть готовые образы которые можно запускать как вам угодно.

### Простейший пример запуска

1. Создайте docker-compose.yml на нужном сервере (или вашей рабочей машине).
    ```
    version: '3.7'
    services:
      nginx:
        # image: cekta/demo:nginx # Укажите путь до образа на шаге build
        restart: always
        ports:
          - 80:80
      app:
        # image: cekta/demo:app # Укажите путь до образа на шаге build
        restart: always
      migration:
        # image: cekta/demo:migration # Укажите путь до образа на шаге build
    ```
2. Запустите docker-compose
    ```
    docker-compose -f docker/docker-compose-builder.yml pull
    docker-compose -f docker/docker-compose-builder.yml up -d
    ```

### Простейший пример обновления

1. Сделать build for production
    ``` 
    ./build.sh
    ```
2. Повторно запустить на сервере docker-compose
    ```
    docker-compose -f docker/docker-compose-builder.yml pull
    docker-compose -f docker/docker-compose-builder.yml up -d
    ```

В этом варианте возможен небольшой downtime на период пока устанавливаются миграции.

**Вы всегда можете сделать свой вариант используя готовые образы.**
