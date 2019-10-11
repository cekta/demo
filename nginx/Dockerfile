FROM nginx as developer
COPY developer.conf /etc/nginx/nginx.conf
EXPOSE 80

FROM nginx as production
COPY production.conf /etc/nginx/nginx.conf
EXPOSE 80
