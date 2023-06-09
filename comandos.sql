-- Para os bancos Oracle e PL-SQL

CREATE TABLE tabela_nome(
id number not null,
nome varchar(80) not null,
telefone varchar(50) not null,
primary key(id)
);

INSERT INTO tabela_nome(id, nome, telefone) VALUES(1, 'Michel', '21 9999-9999');
COMMIT;

-- Para os bancos MySql, SQL Server e PostgreSQL

CREATE TABLE tabela_nome(
id integer not null,
nome varchar(80) not null,
telefone varchar(50) not null,
primary key(id)
);

INSERT INTO tabela_nome(id, nome, telefone) VALUES(1, 'Michel', '21 9999-9999');
