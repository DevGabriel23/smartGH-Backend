CREATE DATABASE smart-gh;

CREATE TABLE users(
	id SERIAL PRIMARY KEY,
	username VARCHAR(40),
	password TEXT
);


CREATE TABLE datos(
	id SERIAL PRIMARY KEY,
	temp real,
	humedad real,
	agua real,
	suelo real,
	bomba int,
	fecha date,
	hora time
);

CREATE TABLE riegos(
	id SERIAL PRIMARY KEY,
	agua real,
	fecha date,
	hora time
);