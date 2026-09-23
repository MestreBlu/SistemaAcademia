-- SELECIONANDO O BD
USE gestao_academia;


-- ADICIONANDO ADM DENTRO DE USUARIO
ALTER TABLE usuario 
MODIFY COLUMN tipo ENUM('professor', 'recepcionista', 'adm') NOT NULL; 

INSERT INTO usuario (usuario, senha, tipo)
VALUES ('admin', 'admin@123', 'adm');


-- ADICIONANDO ALTURA EM ALUNO 
ALTER TABLE aluno
ADD COLUMN altura DECIMAL(3,2); 


-- CORRIGINDO OBJETIVO 
ALTER TABLE aluno
MODIFY COLUMN objetivo TEXT;


-- REMOVENDO O CAMPO SENHA DE ALUNO
ALTER TABLE aluno
DROP COLUMN senha; 


-- CONFERINDO REGULARIDADE
SELECT * FROM usuario; 
SELECT * FROM aluno; 
SELECT * FROM treino; 


