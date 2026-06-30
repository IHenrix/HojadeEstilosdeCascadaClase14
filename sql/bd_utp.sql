DROP TABLE IF EXISTS venta;
DROP TABLE IF EXISTS producto;
DROP TABLE IF EXISTS cliente;
DROP TABLE IF EXISTS administradores;

CREATE TABLE administradores (
    id      SERIAL PRIMARY KEY,
    nombre  VARCHAR(100) NOT NULL,
    correo  VARCHAR(150) NOT NULL UNIQUE,
    pass    VARCHAR(255) NOT NULL
);

CREATE TABLE cliente (
    id         SERIAL PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    apellido   VARCHAR(100) NOT NULL,
    distrito   VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE producto (
    id          SERIAL PRIMARY KEY,
    nombre      VARCHAR(150) NOT NULL,
    precio      NUMERIC(10,2) NOT NULL,
    stock       INT NOT NULL DEFAULT 0,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE venta (
    id          SERIAL PRIMARY KEY,
    cliente_id  INT REFERENCES cliente(id),
    producto_id INT REFERENCES producto(id),
    cantidad    INT NOT NULL,
    total       NUMERIC(10,2) NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO administradores (nombre, correo, pass) VALUES
('Enrique Prada', 'administrador@utp.edu.pe', '$2y$10$gwFVLILzLIAJG8Ba0bS.aupWyhtbLbnJOxnJQYgFQ4AzagxSLSwP.'); -- contraseña: Marco1415

INSERT INTO cliente (nombre, apellido, distrito) VALUES
('Ana',    'Pérez',   'Los Olivos'),
('Carlos', 'Gómez',   'Comas'),
('Lucía',  'Torres',  'Independencia'),
('José',   'Ramírez', 'San Martín de Porres'),
('María',  'López',   'Puente Piedra'),
('Pedro',  'Díaz',    'Carabayllo'),
('Rosa',   'Quispe',  'Ancón'),
('Luis',   'Mamani',  'Santa Rosa'),
('Elena',  'Vargas',  'Los Olivos'),
('Jorge',  'Castro',  'Comas'),
('Carmen', 'Flores',  'Independencia');

INSERT INTO producto (nombre, precio, stock) VALUES
('Laptop HP',       2500.00, 10),
('Mouse Logitech',    45.00, 50),
('Teclado Mecánico', 120.00, 30),
('Monitor 24"',      850.00, 15),
('Auriculares Sony', 180.00, 25);

INSERT INTO venta (cliente_id, producto_id, cantidad, total, created_at) VALUES
(1,  1, 1, 2500.00, '2026-06-01 10:00:00'),
(2,  2, 3,  135.00, '2026-06-05 11:30:00'),
(3,  3, 2,  240.00, '2026-06-08 09:15:00'),
(4,  4, 1,  850.00, '2026-06-10 14:00:00'),
(5,  5, 2,  360.00, '2026-06-12 16:45:00'),
(6,  1, 1, 2500.00, '2026-06-15 08:30:00'),
(7,  2, 5,  225.00, '2026-06-18 13:00:00'),
(8,  3, 1,  120.00, '2026-06-20 10:20:00'),
(9,  4, 2, 1700.00, '2026-06-25 15:10:00'),
(10, 5, 3,  540.00, '2026-06-28 17:00:00');
