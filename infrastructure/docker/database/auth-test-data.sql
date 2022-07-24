drop table if exists user;
create table user
(
    id varchar(36) not null primary key,
    name varchar(200) not null unique,
    password varchar(100) not null
);
insert into user values (
    '9ae78eef-5842-4f54-814d-be0105d0f6bf',
    'name', '$2y$12$X8ZXX7FEP1wQ5CbmuEYAeehCadm9/aPY9TH.hXNqvkcVkYY.PBql6'
);
