-- create database twitter_2;


-- use twitter_2;


-- create table users (
-- 	id int primary key auto_increment not null,
-- 	user_name varchar(255) not null,
-- 	password varchar(255) not null,
-- 	created datetime,
-- 	modified datetime
-- );


-- create table posts (
-- 	id int primary key auto_increment not null,
-- 	user_id int not null,
-- 	body varchar(255),
-- 	created datetime,
-- 	modified datetime
-- );


-- create table relationships (
-- 	id int not null auto_increment,
-- 	follower_id int not null,
-- 	followed_id int not null,
-- 	created datetime,
-- 	modified datetime,
-- 	primary key (`id`, `follower_id`, `followed_id`)
-- );

-- alter table users drop status;
-- alter table users add email varchar(255) not null after user_name;
-- alter table posts add status enum('active', 'deleted') default 'active' not null after body;
-- alter table users add password_confirm varchar(255) not null after password;
-- alter table posts add favorite enum('like', 'normal') default 'normal' not null after status;


alter table users add password varchar(255) not null after name;
