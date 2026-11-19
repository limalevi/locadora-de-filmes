-- DDL
CREATE DATABASE locadora_filmes;
USE locadora_filmes;

CREATE TABLE cliente (
    id_cliente INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    telefone VARCHAR(11),
    email VARCHAR(45),
    data_cadastro DATE NOT NULL
);

CREATE TABLE funcionario (
    id_funcionario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    cargo VARCHAR(30),
    matricula VARCHAR(9),
    ativo TINYINT NOT NULL
);

CREATE TABLE genero (
    id_genero INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(35) UNIQUE NOT NULL
);

CREATE TABLE filme (
    id_filme INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(45) NOT NULL,
    ano_lancamento INT NOT NULL,
    duracao_min INT NOT NULL,
    preco_diaria DECIMAL(4, 2) NOT NULL,
    id_genero INT,

    CONSTRAINT fk_genero_filme FOREIGN KEY (id_genero) REFERENCES genero(id_genero) ON DELETE SET NULL
);

CREATE TABLE exemplar (
    id_exemplar INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_filme INT NOT NULL,

    CONSTRAINT fk_filme_exemplar FOREIGN KEY (id_filme) REFERENCES filme(id_filme)
);

CREATE TABLE locacao (
    id_locacao INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    id_funcionario INT NOT NULL,
    data_locacao DATETIME NOT NULL,
    data_previsto_locacao DATETIME NOT NULL,
    status ENUM('Ativa', 'Devolvida', 'Atrasada', 'Cancelada') NOT NULL DEFAULT 'Ativa',

    CONSTRAINT fk_cliente_locacao FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
    CONSTRAINT fk_funcionario_locacao FOREIGN KEY (id_funcionario) REFERENCES funcionario(id_funcionario)
);

CREATE TABLE item_locacao (
    id_item INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_locacao INT NOT NULL,
    id_exemplar INT NOT NULL,
    data_devolucao DATETIME NOT NULL,
    multa DECIMAL(4, 2),

    CONSTRAINT fk_locacao_item FOREIGN KEY (id_locacao) REFERENCES locacao(id_locacao),
    CONSTRAINT fk_exemplar_item FOREIGN KEY (id_exemplar) REFERENCES exemplar(id_exemplar)
);




-- DML
INSERT INTO cliente (nome, cpf, telefone, email, data_cadastro) VALUES
('Ana Paula Silva', '12345678901', '(85) 99999-1111', 'ana.silva@email.com', '2026-01-15'),
('Carlos Eduardo Lima', '23456789012', '(85) 98888-2222', 'carlos.lima@email.com', '2026-02-10'),
('Mariana Costa', '34567890123', '(85) 97777-3333', 'mariana.costa@email.com', '2026-03-05');

INSERT INTO funcionario (nome, cpf, cargo, matricula, ativo) VALUES
('João Pedro Almeida', '45678901234', 'Atendente', 'MAT001', 1),
('Fernanda Oliveira', '56789012345', 'Gerente', 'MAT002', 1),
('Roberto Santos', '67890123456', 'Caixa', 'MAT003', 0);

INSERT INTO genero (nome) VALUES ('Ação'), ('Ficção Científica'), ('Comédia');

INSERT INTO filme (titulo, ano_lancamento, duracao_min, preco_diaria, id_genero) VALUES
('Mad Max: Estrada da Fúria', 2015, 120, 10.00, 1),
('Interestelar', 2014, 169, 12.00, 2),
('As Branquelas', 2004, 109, 8.00, 3);

INSERT INTO exemplar (id_filme) VALUES (1), (2), (3);

INSERT INTO locacao (id_cliente, id_funcionario, data_locacao, data_previsto_locacao, status) VALUES
(1, 1, '2026-11-01 14:30:00', '2026-11-04 14:30:00', 'Devolvida'),
(2, 2, '2026-11-05 16:00:00', '2026-11-08 16:00:00', 'Atrasada'),
(3, 1, '2026-11-12 10:15:00', '2026-11-15 10:15:00', 'Ativa');

INSERT INTO item_locacao (id_locacao, id_exemplar, data_devolucao, multa) VALUES
(1, 1, '2026-11-04 11:00:00', 0.00),
(2, 2, '2026-11-10 18:20:00', 15.00),
(3, 3, '2026-11-15 10:15:00', NULL);


SELECT * FROM cliente;
SELECT * FROM filme;
SELECT * FROM locacao;

UPDATE locacao SET status = 'Devolvida' WHERE id_locacao = 3;
UPDATE filme SET preco_diaria = 12.00 WHERE id_filme = 1;

DELETE FROM funcionario WHERE id_funcionario = 3;

SELECT * FROM locacao;
SELECT * FROM filme;
SELECT * FROM funcionario;