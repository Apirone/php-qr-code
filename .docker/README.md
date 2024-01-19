# Docker usage

You need to have docker and docker compose installed.
If they are not installed, install them.

* Copy `docker-compose.yml` and `sample.env` into project root folder.
* Rename `sample.env` to `.env` and configure environment.
* Run `composer install` command to vendor install. Composer must be installed locally.
* Build container with `docker compose build` command.
* Run container with `docker compose start` command.
* Open in browser `http://localhost`.
