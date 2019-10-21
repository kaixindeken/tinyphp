# README

## 数据库准备

```mysql
create database yourtablename;
use yourtablename;
create table users (id int not null primary key auto_increment, name varchar(100) not null, age int not null, gender int not null, height int not null, weight int not null) engine=innodb default charset=utf8;
```



## 创建并编辑`app/conf/db.php`

```php
<?php

return [
    'pdo' => [
        'ms' => 'mysql',
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'yourpassword',
        'database' => 'yourdatabase',
    ]
];
```

