# WeMovies
========================
Cinema website, which looks like Allocine

Installation
------------
PHP8+ is required

Get repository.

```bash
https://github.com/miaromiaro/WeMovies.git
```

Run docker

```bash
docker-compose  up -d --build
```

Install dependancies
----------------------------

```bash
$ docker exec -it wemovie_php bash
# composer install
# npm install
```

If not run on docker launch (out of docker)
```bash
# exit
$ npm run build
```

link http://localhost:8009

Test
----------------------------
Launch unit test
```bash
$ php bin/phpunit
```
