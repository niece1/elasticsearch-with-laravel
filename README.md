<p align="center">
![GitHub language count](https://img.shields.io/github/languages/count/niece1/elasticsearch-with-laravel)
![GitHub top language](https://img.shields.io/github/languages/top/niece1/elasticsearch-with-laravel)
![GitHub repo size](https://img.shields.io/github/repo-size/niece1/elasticsearch-with-laravel)
![Lines of code](https://img.shields.io/tokei/lines/github/niece1/elasticsearch-with-laravel)
![GitHub contributors](https://img.shields.io/github/contributors/niece1/elasticsearch-with-laravel)
![GitHub last commit](https://img.shields.io/github/last-commit/niece1/elasticsearch-with-laravel)
![GitHub](https://img.shields.io/github/license/niece1/elasticsearch-with-laravel)
</p>

## Intro

This repo is an example of basic search functionality using Elasticsearch and Laravel. No extra packages. Only custom code.

## Usage

If it happens you decide to run it on your machine make sure you have [Docker installed](https://docs.docker.com/docker-for-mac/install/) and Docker Engine is allotted at least 8GiB of memory.

Clone repository.

From your terminal window at the project root spin up the containers for the web server by running
```
docker-compose up -d --build
```
The following are built for our web server, with their exposed ports detailed:

- **nginx** - :8088
- **mysql** - :4306
- **php** - :9000
- **phpmyadmin** - :8081
- **elasticsearch** - :9200

Two additional containers are included that handle Composer and NPM.

Depending on operating system, you may encounter rights problems so make sure you have appropriate writable rights for project folder.

To perform database migrations run:
```
docker-compose run --rm artisan migrate
```

In your **.env** file specify following variables:
```
ELASTICSEARCH_ENABLED=true
ELASTICSEARCH_HOSTS="elasticsearch"
```

## License

This is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
