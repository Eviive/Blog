FROM node:18-alpine

WORKDIR /var/www/Blog

COPY ./package.json /var/www/Blog/package.json

RUN npm i

CMD npm run watch
