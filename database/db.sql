-- creati o baza noua de date cu numele juicy si rulati scriptul asta in phpmyadmin 
DROP TABLE IF EXISTS clienti;
DROP TABLE IF EXISTS plateste_pentru;
DROP TABLE IF EXISTS lista_cumparaturi;
DROP TABLE IF EXISTS produse;
DROP TABLE IF EXISTS cantitate_cumparata;
DROP TABLE IF EXISTS detine;
DROP TABLE IF EXISTS vanzator;

CREATE TABLE clienti(
    id_client INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    adresa VARCHAR(255),
    email VARCHAR(50),
    nume VARCHAR(40),
    prenume VARCHAR(40),
    parola VARCHAR(60)
);

CREATE TABLE plateste_pentru(
    id_client INT NOT NULL,
    id_lista_cumparaturi INT NOT NULL
);

CREATE TABLE lista_cumparaturi(
    id_lista_cumparaturi INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE cantitate_cumparata(
    id_lista_cumparaturi INT NOT NULL,
    id_produs INT NOT NULL,
    cantitate INT NOT NOULL
);

CREATE TABLE produse(
    id_produs INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_vanzator INT NOT NULL,
    nume VARCHAR(50),
    categorie VARCHAR(50),
    pret INT NOT NULL
);

CREATE TABLE detine(
    id_vanzator INT NOT NULL,
    id_produs INT NOT NULL,
    cantitate INT NOT NULL
);

CREATE TABLE vanzator(
    id_vanzator INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nume VARCHAR(40),
    parola VARCHAR(40)
);
