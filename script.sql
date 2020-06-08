CREATE DATABASE aranoz;
USE aranoz;
create table categoria(
    id int primary key AUTO_INCREMENT,
    nombre varchar(50) not null unique,
    descripcion varchar(256) null
) engine = innodb;
create table producto(
    id int AUTO_INCREMENT,
    codigo varchar(50) NOT NULL UNIQUE,
    nombre varchar(100) not null unique,
    precio decimal(11, 2) not null,
    descripcion varchar(256) null,
    stock int not null,
    estado bit default(1),
    imagen varchar(256) null,
    categoria_id int not null,
    PRIMARY KEY(id),
    FOREIGN KEY(categoria_id) REFERENCES categoria(id)
) engine = innodb;
create table usuario(
    id int primary key AUTO_INCREMENT,
    rol varchar(20) DEFAULT ('cliente') NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    direccion VARCHAR(100),
    login VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(128) NOT NULL,
    telefono VARCHAR(15)
) engine = innodb;
CREATE TABLE venta(
    id INT NOT NULL AUTO_INCREMENT,
    fecha DATETIME NOT NULL,
    cliente_id INT NOT NULL,
    estado CHAR(1) NOT NULL DEFAULT 'P',
    PRIMARY KEY (id),
    FOREIGN KEY (cliente_id) REFERENCES usuario(id)
) engine = innodb;
CREATE TABLE detalleventa(
    id INT NOT NULL AUTO_INCREMENT,
    venta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(venta_id) REFERENCES venta(id),
    FOREIGN KEY(producto_id) REFERENCES producto(id)
) engine = innodb;
--VISTAS
CREATE VIEW vw_producto_detalle AS
SELECT p.id,
    p.nombre,
    p.precio,
    p.estado,
    P.descripcion,
    c.nombre as categoria
FROM producto p
    INNER JOIN categoria c ON (p.categoria_id = c.id);
--INSERTS
INSERT INTO categoria(nombre, descripcion)
VALUES(
        'sala',
        'Lorem ipsum, dolor sit amet consectetur'
    );
INSERT INTO producto (
        codigo,
        nombre,
        precio,
        descripcion,
        stock,
        estado,
        imagen,
        categoria_id
    )
VALUES(
        'ASDF147',
        'Silla',
        '20',
        'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dicta fugit corrupti nemo!',
        100,
        1,
        'https://images.pexels.com/photos/2762247/pexels-photo-2762247.jpeg?cs=srgb&dl=photo-of-black-chair-2762247.jpg&fm=jpg',
        1
    );
INSERT INTO producto (
        codigo,
        nombre,
        precio,
        descripcion,
        stock,
        estado,
        imagen,
        categoria_id
    )
VALUES(
        'QWER587',
        'Sofa',
        '50',
        'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dicta fugit corrupti nemo!',
        100,
        1,
        'https://images.pexels.com/photos/1866149/pexels-photo-1866149.jpeg?cs=srgb&dl=2-seat-orange-leather-sofa-beside-wall-1866149.jpg&fm=jpg',
        1
    );
INSERT INTO producto (
        codigo,
        nombre,
        precio,
        descripcion,
        stock,
        estado,
        imagen,
        categoria_id
    )
VALUES(
        'QWER123',
        'Mesita Centro',
        '2',
        'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dicta fugit corrupti nemo!',
        100,
        1,
        'https://images.pexels.com/photos/378006/pexels-photo-378006.jpeg?cs=srgb&dl=bouquet-bright-coffee-coffee-cup-378006.jpg&fm=jpg',
        1
    );