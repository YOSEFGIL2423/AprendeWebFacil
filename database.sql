-- Crear base de datos
CREATE DATABASE IF NOT EXISTS aprendewebfacil;
USE aprendewebfacil;

-- Tabla de contactos
CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    mensaje TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar datos de ejemplo
INSERT INTO contactos (nombre, email, telefono, mensaje) VALUES
('Juan Pérez', 'juan@ejemplo.com', '123456789', 'Me interesa aprender desarrollo web desde cero. ¿Por dónde debo empezar?'),
('María García', 'maria@ejemplo.com', '987654321', 'Quisiera información sobre los cursos que ofrecen.'),
('Carlos López', 'carlos@ejemplo.com', NULL, 'Excelente sitio web, muy informativo para principiantes.');

-- Tabla de usuarios (para futuras expansiones)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de cursos (para futuras expansiones)
CREATE TABLE IF NOT EXISTS cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    duracion INT,
    nivel ENUM('principiante', 'intermedio', 'avanzado'),
    precio DECIMAL(10,2),
    activo BOOLEAN DEFAULT TRUE
);