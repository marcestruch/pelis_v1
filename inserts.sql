USE pelis2;

-- Inserts per a Pel·lícules
INSERT INTO pelis (titol, valoracio, pais, director, genere, duracio, anyo, sinopsi, imatge) VALUES
('The Godfather', 5.00, 'Estats Units', 'Francis Ford Coppola', 'Drama, Crim', 175, 1972, 'El patriarca d''una dinastia del crim organitzat transfereix el control del seu imperi clandestí al seu fill reticent.', 'godfather.png'),
('Spirited Away', 4.80, 'Japó', 'Hayao Miyazaki', 'Animació, Fantasia', 125, 2001, 'Durant el trasllad de la seva família als suburbis, una nena de 10 anys vaga per un món governat per déus, bruixes i esperits, on els humans es transformen en bèsties.', 'spirited_away.png'),
('Inception', 4.70, 'Estats Units', 'Christopher Nolan', 'Ciència-ficció, Acció', 148, 2010, 'Un lladre que roba secrets corporatius a través de l''ús de la tecnologia d''intercanvi de somnis rep la tasca inversa de plantar una idea en la ment d''un C.E.O.', 'inception.jpg');

-- Inserts per a Jocs
INSERT INTO jocs (titol, valoracio, pais, desenvolupador, genere, any, descripcio, imatge) VALUES
('The Legend of Zelda: Breath of the Wild', 5.00, 'Japó', 'Nintendo', 'Aventura, Acció', 2017, 'Oblida tot el que saps sobre els jocs de The Legend of Zelda. Entra en un món de descobriments, exploració i aventura a The Legend of Zelda: Breath of the Wild.', 'zelda.jpg'),
('Elden Ring', 4.90, 'Japó', 'FromSoftware', 'RPG, Acció', 2022, 'Aixeca''t, Tiznado, i deixa''t guiar per la gràcia per esgrimir el poder de l''Anell d''Elden i convertir-te en un Senyor d''Elden a les Terres Intermèdies.', 'elden_ring.jpg'),
('Minecraft', 4.50, 'Suècia', 'Mojang', 'Sandbox, Supervivència', 2011, 'Explora mons generats aleatòriament i construeix coses increïbles, des de les cases més simples fins als castells més grans.', 'minecraft.jpg');

-- Inserts per a Usuaris (Opcional, per proves)
INSERT INTO usuaris (email, pass) VALUES
('admin@example.com', '1234'),
('user@example.com', '1234');
