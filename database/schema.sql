drop database if exists article_aggregator_co;
create database article_aggregator_co;
use article_aggregator_co;

create table users (
   id int auto_increment not null primary key,
   password_digest varchar(255) null,
   email varchar(255) not null unique,
   name varchar(255) not null,
   profile_picture varchar(255) default 'default.jpg',
   github_identifier varchar(15)
);

create table articles (
   id int auto_increment not null primary key,
   title varchar(255) not null,
   url varchar(255) not null,
   created_at datetime not null,
   updated_at datetime,
   author_id int not null,
   foreign key (author_id) references users (id)
);

create table user_github_token (
    id int primary key,
    foreign key (id) references users (id),
    access_token varchar(255)
);
