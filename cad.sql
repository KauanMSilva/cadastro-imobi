CREATE DATABASE imobiliaria;
USE imobiliaria;

CREATE TABLE corretores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE,
    creci VARCHAR(50) NOT NULL
);
