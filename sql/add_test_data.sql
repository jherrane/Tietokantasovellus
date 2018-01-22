INSERT INTO Kayttaja(nimi,salasana) VALUES ('Pekka', 'akkep');
INSERT INTO Kayttaja(nimi,salasana) VALUES ('admin', 'admin');

INSERT INTO Drinkki(nimi,tyyppi,hintaluokka,kuvaus,added) VALUES ('Jallukola', 'Long drink', 1, 'Lisää shottiin jallua(*) jäitä ja kolajuomaa makusi mukaan', NOW());

INSERT INTO RaakaAine(nimi) VALUES ('Jaloviina(*)');
INSERT INTO RaakaAine(nimi) VALUES ('Jaloviina(***)');
INSERT INTO RaakaAine(nimi) VALUES ('Ruisviski');

INSERT INTO KayttajaDrinkki(kayttaja_id,drinkki_id) VALUES (1,1);
INSERT INTO DrinkkiRaakaAine(drinkki_id,raakaaine_id,maara) VALUES (1,1,'4 cl');