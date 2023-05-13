FROM node:18.16.0-alpine

COPY package.json /var/www/package.json
COPY webpack.config.js /var/www/webpack.json

RUN cd /var/www && npm install