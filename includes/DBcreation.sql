create schema loginsystem;

use loginsystem;

create table users (
	idUsers int not null primary key,
    uidUsers varchar(50) not null,
    emailUsers varchar(50) not null,
    pwdUsers varchar(500) not null,
    gender char(1),
    headline varchar(300),
    bio varchar(5000),
    userImg varchar(1000)
);