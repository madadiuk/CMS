FROM nginx:latest
ADD ./nginx/conf.d/app.conf /etc/nginx/conf.d/default.conf
