create database chamados_suporte; 
use chamados_suporte;


CREATE TABLE clientes (
    id_cliente int auto_increment primary key,
    nome varchar(100) NOT NULL,
    email varchar(100) NOT NULL UNIQUE,
    telefone varchar(20)
);

CREATE TABLE colaboradores (
    id_colaborador int auto_increment primary key,
    nome varchar(100) NOT NULL,
    email varchar(100) NOT NULL UNIQUE
);

CREATE TABLE chamados (
    id_chamado INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    descricao TEXT NOT NULL,
    criticidade ENUM('baixa', 'média', 'alta') NOT NULL,
    status ENUM('aberto', 'em andamento', 'resolvido') DEFAULT 'aberto',
    data_abertura DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_colaborador INT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_colaborador) REFERENCES colaboradores(id_colaborador)
);


select * from chamados;