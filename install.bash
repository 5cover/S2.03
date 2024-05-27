#!/bin/env bash

dpkg -i /usr/local/src/*

mysql --user=root --password=lannion <<EOF
    create database paolo;
    show databases;
    create table etudiants (
      id int primary key,
      nom text not null,
      date_naissance date not null,
      classement int not null);
EOF