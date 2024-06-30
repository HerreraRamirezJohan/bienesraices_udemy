CREATE DATABASE udemy_bienesraices;

create table propertie(
    id int PRIMARY KEY AUTO_INCREMENT,
    title varchar(150),
    price double(10,2),
    imagen varchar(255),
    description varchar(255),
    rooms int,
    parking int 
);

create table seller(
    id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(150),
    lastname varchar(150),
    phone char(10)
);

alter table propertie add id_seller int;
alter table propertie add constraint fk_seller foreign key (id_seller) references seller(id);

CREATE TABLE user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email varchar(200),
    password varchar(255)
);

INSERT INTO user (email, password) VALUES ('admin@email.com', '$2a$12$Zv7utvHGxFNYUz8/IEp2geL70Htyl0Jtc9FzE0WbqO/ZVTWc7QdNO');