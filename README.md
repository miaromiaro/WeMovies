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
# composer instal
# npm install
```

#And open this url on browser
http://localhost:8009

Launch unit test
----------------------------
$ php bin/phpunit
