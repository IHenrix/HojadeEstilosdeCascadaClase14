DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS administradores;

CREATE TABLE administradores (
    id      SERIAL PRIMARY KEY,
    nombre  VARCHAR(100) NOT NULL,
    correo  VARCHAR(150) NOT NULL UNIQUE,
    pass    VARCHAR(255) NOT NULL
);

CREATE TABLE usuario (
    id         SERIAL PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    apellido   VARCHAR(100) NOT NULL,
    distrito   VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO administradores (nombre, correo, pass) VALUES
('Enrique Prada', 'administrador@utp.edu.pe', '$2y$10$gwFVLILzLIAJG8Ba0bS.aupWyhtbLbnJOxnJQYgFQ4AzagxSLSwP.'); -- contraseña: Marco1415

INSERT INTO usuario (nombre, apellido, distrito) VALUES
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
