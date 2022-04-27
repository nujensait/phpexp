# Dockerfile
FROM node:9.3

WORKDIR /usr/src

RUN npm install -g eslint babel-eslint
RUN npm install -g eslint-config-airbnb-base eslint-plugin-import

#COPY eslintrc.yml /root/.eslintrc.yml

CMD ["eslint", "/app"]