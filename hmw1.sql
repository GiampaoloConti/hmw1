CREATE DATABASE hmw1;
USE hmw1;


CREATE TABLE TabellaRegistrazione(
Nome_utente VARCHAR(255) PRIMARY KEY,
Password VARCHAR(255),
Nome VARCHAR(255),
Cognome VARCHAR(255),
Email VARCHAR(255),
ProfilePic VARCHAR(255)
);

CREATE TABLE Contenuti(
Titolo VARCHAR(255),
Contenuto VARCHAR(255),
Autore VARCHAR(255),
Immagine VARCHAR(255),
Link VARCHAR(255) PRIMARY KEY
);

create table Preferiti(
UserID VARCHAR(255),
Titolo VARCHAR(255),
Contenuto VARCHAR(255),
Autore VARCHAR(255),
Immagine VARCHAR(255),
Link VARCHAR(255),
PRIMARY KEY(Link,UserID),
FOREIGN KEY(UserID) REFERENCES TabellaRegistrazione(Nome_utente),
FOREIGN KEY(Link) REFERENCES Contenuti(Link)
);

CREATE TABLE Commenti(
UserID VARCHAR(255),
Link VARCHAR(255),
ProfilePic VARCHAR(255),
Testo VARCHAR(255),
PRIMARY KEY(UserID,Link,Testo),
FOREIGN KEY(UserID) REFERENCES TabellaRegistrazione(Nome_utente),
FOREIGN KEY(Link) REFERENCES Contenuti(Link)
);