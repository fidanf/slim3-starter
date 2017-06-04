create table users
(
	id int auto_increment
		primary key,
	name varchar(50) null,
	email varchar(50) null,
	password varchar(255) null,
	created_at timestamp default CURRENT_TIMESTAMP not null,
	updated_at datetime null
);

