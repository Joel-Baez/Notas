DROP DATABASE IF EXISTS notas_app;
CREATE DATABASE notas_app CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE notas_app;

DROP TABLE IF EXISTS notas;
DROP TABLE IF EXISTS materias;
DROP TABLE IF EXISTS estudiantes;
DROP TABLE IF EXISTS programas;

CREATE TABLE programas (
    codigo VARCHAR(4) PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE estudiantes (
    codigo VARCHAR(5) PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL,
    email VARCHAR(80) NOT NULL,
    programa VARCHAR(4) NOT NULL,
    CONSTRAINT fk_estudiante_programa FOREIGN KEY (programa) REFERENCES programas(codigo)
) ENGINE=InnoDB;

CREATE TABLE materias (
    codigo VARCHAR(4) PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    programa VARCHAR(4) NOT NULL,
    CONSTRAINT fk_materia_programa FOREIGN KEY (programa) REFERENCES programas(codigo)
) ENGINE=InnoDB;

CREATE TABLE notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    materia VARCHAR(4) NOT NULL,
    estudiante VARCHAR(5) NOT NULL,
    actividad VARCHAR(80) NOT NULL,
    valor DECIMAL(4,2) NOT NULL,
    CONSTRAINT ck_nota_valor CHECK (valor > 0 AND valor <= 5.00),
    CONSTRAINT fk_nota_estudiante FOREIGN KEY (estudiante) REFERENCES estudiantes(codigo) ON DELETE CASCADE,
    CONSTRAINT fk_nota_materia FOREIGN KEY (materia) REFERENCES materias(codigo) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO programas (codigo, nombre) VALUES
('1111', 'Ingeniería de Sistemas'),
('2222', 'Ingeniería Multimedia');

INSERT INTO estudiantes (codigo, nombre, email, programa) VALUES
('10001', 'Estudiante 1', 'test1@test.com', '1111'),
('10002', 'Estudiante 2', 'test2@test.com', '1111'),
('10003', 'Estudiante 3', 'test3@test.com', '2222'),
('10004', 'Estudiante 4', 'test4@test.com', '2222');

INSERT INTO materias (codigo, nombre, programa) VALUES
('1101', 'Programación avanzada G1', '1111'),
('1102', 'Ingeniería de Software G1', '1111'),
('2201', 'Programación avanzada G2', '2222'),
('2202', 'Taller de desarrollo web', '2222');

INSERT INTO notas (materia, estudiante, actividad, valor) VALUES
('1101', '10001', 'Ejemplo 1', 3.00),
('1101', '10002', 'Ejemplo 1', 4.00),
('1102', '10001', 'Ejemplo 2', 3.50),
('1102', '10002', 'Ejemplo 2', 3.80),
('2201', '10003', 'Actividad 1', 3.50);
