# Пример обработки HTTP

Этот репозиторий содержит 
[целый плейлист на youtube](https://www.youtube.com/watch?v=_yIflB_pgXo&list=PL7Nh93imVuXwJ0bYlpfu84MhwQmDoSOia)
объяснящий основы обработки http запросов

```
docker-compose up -d
```

## Несколько application

``` 
docker-compose up -d --scale application=5
docker-compose restart
```

Без рестарта может не работать.

