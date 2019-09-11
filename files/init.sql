create database babyblog;

use babyblog;

-- we don't know how to generate schema babyblog (class Schema) :(
create table if not exists users
(
	id int auto_increment
		primary key,
	username varchar(128) null,
	password varchar(32) null,
	isvip int default '0' null
)
;

create table if not exists article
(
	id int auto_increment
		primary key,
	title varchar(10240) null,
	content varchar(10240) null,
	userid int null,
	constraint article_users_id_fk
		foreign key (userid) references users (id)
)
;
