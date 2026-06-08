CREATE TABLE contatos (
                          id SERIAL PRIMARY KEY,
                          nome VARCHAR(100) NOT NULL,
                          email VARCHAR(255) NOT NULL,
                          telefone VARCHAR(20) NOT NULL
);
