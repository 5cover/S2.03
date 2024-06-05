<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script de création de la BDD utilisateurs</title>
</head>

<body>
    <pre>
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli("localhost", "root", "lannion", "paolo");

$sql = <<<SQL
drop schema if exists users cascade;
create schema users;
set schema 'users';

create extension citext;
create domain email as citext
  check ( value ~ '^[a-zA-Z0-9.!#$%&''*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$' );


create table _user(
    id varchar(268) primary key,
    varchar(255) name not null unique,
    adresse email not null unique;
    password_hash text not null,
    password_salt text not null,
    validated boolean not null
);

create table user_token (
    user_id varchar(268) primary key,
    selector varchar(255) not null,
    hashed_validator varchar(255) not null,
    expiry timestamp not null,
    constraint fk_user
        foreign key (user_id)
        references _user(id);
);
SQL;

var_dump($db->execute_query($sql));
?>
</pre>
</body>

</html>
<?php
