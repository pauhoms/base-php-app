drop table if exists user;
create table user
(
    id varchar(36) not null primary key,
    name varchar(200) not null unique,
    password varchar(100) not null
);
insert into user values ('id', 'name', '$2y$12$X8ZXX7FEP1wQ5CbmuEYAeehCadm9/aPY9TH.hXNqvkcVkYY.PBql6');
insert into user values ('id2', 'name2', 'password');
