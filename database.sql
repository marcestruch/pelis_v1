CREATE DATABASE IF NOT EXISTS pelis2;
USE pelis2;

-- Taula de Pel·lícules
CREATE TABLE IF NOT EXISTS pelis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titol VARCHAR(255) NOT NULL,
    valoracio DECIMAL(3, 2) DEFAULT 0,
    pais VARCHAR(100),
    director VARCHAR(100),
    genere VARCHAR(100),
    duracio INT,
    anyo INT,
    sinopsi TEXT,
    imatge VARCHAR(255)
);

-- Taula de Jocs (Nova)
CREATE TABLE IF NOT EXISTS jocs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titol VARCHAR(255) NOT NULL,
    valoracio DECIMAL(3, 2) DEFAULT 0,
    pais VARCHAR(100),
    desenvolupador VARCHAR(100),
    genere VARCHAR(100),
    any INT,
    descripcio TEXT,
    imatge VARCHAR(255)
);

-- Taula d'Usuaris
CREATE TABLE IF NOT EXISTS usuaris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL
);

-- Taula de Valoracions (Opcional, si es vol mantenir per pelis, caldria una per jocs o polimòrfica)
CREATE TABLE IF NOT EXISTS valoracions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    peli_id INT,
    joc_id INT,
    usuari_id INT NOT NULL,
    valoracio INT NOT NULL,
    FOREIGN KEY (peli_id) REFERENCES pelis(id) ON DELETE CASCADE,
    FOREIGN KEY (joc_id) REFERENCES jocs(id) ON DELETE CASCADE,
    FOREIGN KEY (usuari_id) REFERENCES usuaris(id) ON DELETE CASCADE
);
