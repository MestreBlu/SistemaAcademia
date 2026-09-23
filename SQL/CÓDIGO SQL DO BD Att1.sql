-- CRRIAÇÃO DO BD
CREATE DATABASE IF NOT EXISTS gestao_academia;
USE gestao_academia;

/* CRIAÇÃO DA TABELA USUÁRIO, RESPONSÁVEL POR ARMAZENAR USUÁRIO E SENHA 
QUE SERÃO USADOS NA PÁGINA DE LOGIN */

CREATE TABLE IF NOT EXISTS usuario (
	id_usuario INT AUTO_INCREMENT, 
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(30) NOT NULL,
    tipo ENUM('professor', 'recepcionista') NOT NULL,
    CONSTRAINT pk_usuario PRIMARY KEY (id_usuario),
    CONSTRAINT uk_usuario UNIQUE KEY (usuario)
);

INSERT INTO usuario (usuario, senha, tipo)
VALUES ('recepcao', 'gestao@123', 'recepcionista'),
       ('personal', 'treino@123', 'professor');
  
  
-- CRIAÇÃO DA TABELA ALUNO
CREATE TABLE IF NOT EXISTS aluno (
	id_aluno INT AUTO_INCREMENT, 
    nome VARCHAR(100) NOT NULL, 
    cpf VARCHAR(14) NOT NULL,
    data_nascimento DATE NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100) NOT NULL,
    data_cadastro DATE NOT NULL,
    CONSTRAINT pk_aluno PRIMARY KEY (id_aluno),
    CONSTRAINT uk_cpf_aluno UNIQUE KEY (cpf),
    CONSTRAINT uk_email_aluno UNIQUE KEY (email)
);

INSERT INTO aluno (nome, cpf, data_nascimento, telefone, email, data_cadastro)
VALUES ('Roger', '432.435.231-66', '2007-11-30', '(11) 98762-5742', 'roger.presser.paula@gmail.com', CURDATE());

-- CRIAÇÃO DA TABELA TREINO
CREATE TABLE IF NOT EXISTS treino (
	id_treino INT AUTO_INCREMENT,
    id_aluno INT NOT NULL,
    nome_treino VARCHAR(100) NOT NULL, 
    descricao TEXT NOT NULL,
    data_criacao DATE NOT NULL,
    CONSTRAINT pk_treino PRIMARY KEY (id_treino),
    CONSTRAINT fk_aluno_treino FOREIGN KEY (id_aluno) REFERENCES aluno (id_aluno)
);

INSERT INTO treino (id_aluno, nome_treino, descricao, data_criacao)
VALUES ( 1, 
		'Treino A - Peito e Tríceps',
		'Supino reto - 4 séries de 10 repetições
		Supino inclinado - 3 séries de 12 repetições
		Tríceps pulley - 3 séries de 15 repetições',
        CURDATE()
);


-- ADICIONANDO CAMPOS QUE FALTAM 
ALTER TABLE aluno
ADD COLUMN senha VARCHAR(255) NOT NULL, -- CAMPO A SER REMOVIDO
ADD COLUMN celular VARCHAR(20), 
ADD COLUMN endereco VARCHAR(255), 
ADD COLUMN objetivo VARCHAR(100), -- CAMPO A SER ALTERADO
ADD COLUMN plano ENUM('Mensal', 'Trimestral', 'Anual') NOT NULL, /* Novo campo restrito às opções do form */
ADD COLUMN peso_atual DECIMAL(5,2) 
-- ADD COLUMN altura DECIMAL(3,2) NOT NULL;
;

SELECT * FROM usuario; 
SELECT * FROM aluno; 
SELECT * FROM treino; 
