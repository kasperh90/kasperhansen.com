FROM node:18.16.0-alpine

COPY package.json /var/www/package.json
COPY webpack.config.js /var/www/webpack.config.js

RUN cd /var/www && npm install