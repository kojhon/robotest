<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template rpovided test</h1>
    <br>
</p>

Yii 2 provided [Yii 2](http://www.yiiframework.com/) application for
test work for robofinance.



DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      forms/              contains form classes
      services/           contains services
      repositories/       contains model repositories
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.0.


RUN
------------

### Run with Docker
        
Start the container

    docker-compose up -d

If you want - you can up migrations and add seed data to db

    docker-compose exec web php ./yii migrate/up --interactive=0
    docker-compose exec web php ./yii seed
    
You can then access the application through the following URL:

    http://127.0.0.1:3000