CREATE TABLE Kayttaja(
	id SERIAL PRIMARY KEY,
	nimi varchar(100) NOT NULL, 
	salasana varchar(60) NOT NULL
);

CREATE TABLE Drinkki(
	id SERIAL PRIMARY KEY,
	nimi varchar(100) NOT NULL,
	tyyppi varchar(30),
	hintaluokka INTEGER
);

CREATE TABLE RaakaAine(
	id SERIAL PRIMARY KEY,
	nimi varchar(100) NOT NULL
);

CREATE TABLE KayttajaDrinkki(
	kayttaja_id INTEGER REFERENCES Kayttaja(id),
	drinkki_id INTEGER REFERENCES Drinkki(id)
);

CREATE TABLE DrinkkiRaakaAine(
	drinkki_id INTEGER REFERENCES Drinkki(id),
	raakaaine_id INTEGER REFERENCES RaakaAine(id),
	maara varchar(30)
);