CREATE DATABASE RESEAU_SOCIAL;
USE RESEAU_SOCIAL;

CREATE TABLE Utillisateur(
   iduser INT NOT NULL AUTO_INCREMENT,
   Nom VARCHAR(50),
   email VARCHAR(50),
   mdp VARCHAR(50),
   image VARCHAR(50),
   role VARCHAR(50),
   PRIMARY KEY(iduser)
);

CREATE TABLE Status(
   Numero INT,
   Delai TIME,
   chemin_acces VARCHAR(50),
   PRIMARY KEY(Numero)
);

CREATE TABLE Discussion(
   numd INT,
   Date_creation DATE,
   PRIMARY KEY(numd)
);

CREATE TABLE sessions(
   id_sessions VARCHAR(50),
   iduser INT NOT NULL,
   PRIMARY KEY(id_sessions),
   FOREIGN KEY(iduser) REFERENCES Utillisateur(iduser)
);

CREATE TABLE Pages(
   nump INT,
   Nomp VARCHAR(50),
   Description INT,
   iduser INT,
   PRIMARY KEY(nump),
   FOREIGN KEY(iduser) REFERENCES Utillisateur(iduser)
);

CREATE TABLE Post(
   numposte INT,
   lien VARCHAR(50),
   titre VARCHAR(50),
   Description VARCHAR(50),
   iduser INT,
   PRIMARY KEY(numposte),
   FOREIGN KEY(iduser) REFERENCES Utillisateur(iduser)
);

CREATE TABLE Messages(
   idm INT,
   Dte_creation DATE,
   Dte_modif VARCHAR(50),
   numd INT NOT NULL,
   iduser INT NOT NULL,
   PRIMARY KEY(idm),
   FOREIGN KEY(numd) REFERENCES Discussion(numd),
   FOREIGN KEY(iduser) REFERENCES Utillisateur(iduser)
);

CREATE TABLE Commentaire(
   idcom INT,
   Texte VARCHAR(50),
   numposte INT NOT NULL,
   iduser INT NOT NULL,
   PRIMARY KEY(idcom),
   FOREIGN KEY(numposte) REFERENCES Post(numposte),
   FOREIGN KEY(iduser) REFERENCES Utillisateur(iduser)
);

CREATE TABLE Entrenir(
   iduser INT,
   numd INT,
   PRIMARY KEY(iduser, numd),
   FOREIGN KEY(iduser) REFERENCES Utillisateur(iduser),
   FOREIGN KEY(numd) REFERENCES Discussion(numd)
);

CREATE TABLE Publier(
   iduser INT,
   numposte INT,
   PRIMARY KEY(iduser, numposte),
   FOREIGN KEY(iduser) REFERENCES Utillisateur(iduser),
   FOREIGN KEY(numposte) REFERENCES Post(numposte)
);

CREATE TABLE Suivre(
   iduser INT,
   nump INT,
   PRIMARY KEY(iduser, nump),
   FOREIGN KEY(iduser) REFERENCES Utillisateur(iduser),
   FOREIGN KEY(nump) REFERENCES Pages(nump)
);

CREATE TABLE Gerer(
   iduser INT,
   nump INT,
   PRIMARY KEY(iduser, nump),
   FOREIGN KEY(iduser) REFERENCES Utillisateur(iduser),
   FOREIGN KEY(nump) REFERENCES Pages(nump)
);

CREATE TABLE Poster(
   iduser INT,
   Numero INT,
   PRIMARY KEY(iduser, Numero),
   FOREIGN KEY(iduser) REFERENCES Utillisateur(iduser),
   FOREIGN KEY(Numero) REFERENCES Status(Numero)
);
