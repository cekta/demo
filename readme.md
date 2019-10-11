# Пример обработки HTTP

Этот репозиторий содержит 
[целый плейлист на youtube](https://www.youtube.com/watch?v=_yIflB_pgXo&list=PL7Nh93imVuXwJ0bYlpfu84MhwQmDoSOia)
объяснящий основы обработки http запросов

## Dev окружение

```
docker-compose up -d
```

## Build for production

Это лишь пример как можно все собрать в образы и потом запускать где угодно.

Если вам не нравится docker и образы, вы можете сделать свой скрипт сборки в архив и потом разворачивать его в ansible 
или любом удобном вам варианте.

Подготовка (один раз)
``` 
vim build/docker-compose.yml # Укажите image куда пушить
```

Сборка и отправка образа
``` 
./build.sh
```

## Example production

Это лишь пример как запустить в любом месте, не забывайте указать пути до ваших образов(image) и сделать docker login в 
ваш registry.

В реальности вместо docker-compose можно использовать любые удобные вам оркестраторы.

### Подготовка
```
mkdir production
cd production
```

Создать файлик docker-compose.yml
``` 
version: '3.7'
services:
  web:
    image: cekta/youtube-minimal-knowledge:web
    restart: always
    ports:
      - 80:80
  api:
    image: cekta/youtube-minimal-knowledge:api
    restart: always
```

### Получение новой версии и релиз

```
docker-compose pull
docker-compose up -d
```

Вам не нужны исходные коды, все что необходимо уже в образах.
