DROP TABLE IF EXISTS Abilitazione;
DROP TABLE IF EXISTS Lavorazione;
DROP TABLE IF EXISTS Mansione;
DROP TABLE IF EXISTS Dipendente;
DROP TABLE IF EXISTS Fattura;
DROP TABLE IF EXISTS Incarico;
DROP TABLE IF EXISTS Cliente;

CREATE TABLE Cliente (
  ID int(11) NOT NULL AUTO_INCREMENT,
  tipo ENUM('P', 'I') DEFAULT 'P',
  nominativo varchar(50) NOT NULL,
  codiceFiscale varchar(16) UNIQUE DEFAULT NULL,
  partitaIVA varchar(11) UNIQUE DEFAULT NULL,
  indirizzo varchar(50) NOT NULL,
  citta varchar(30) NOT NULL,
  telefono varchar(11) NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB;

CREATE TABLE Incarico (
  ID int(11) NOT NULL AUTO_INCREMENT,
  dataInizio date NOT NULL,
  dataFine date DEFAULT NULL,
  cliente int(11) NOT NULL,
  PRIMARY KEY (ID),
  FOREIGN KEY (cliente) REFERENCES Cliente(ID)
) ENGINE=InnoDB;

CREATE TABLE Fattura (
  ID int(11) NOT NULL AUTO_INCREMENT,
  dataEmissione date NOT NULL,
  imponibile decimal(12,2) NOT NULL DEFAULT '0',
  aliquota decimal(4,2) NOT NULL DEFAULT '22',
  incarico int(11) NOT NULL,
  PRIMARY KEY (ID),
  FOREIGN KEY (incarico) REFERENCES Incarico(ID)
) ENGINE=InnoDB;

CREATE TABLE Dipendente (
  ID int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(50) NOT NULL,
  cognome varchar(50) NOT NULL,
  dataAssunzione date NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB;

CREATE TABLE Mansione (
  ID int(11) NOT NULL AUTO_INCREMENT,
  tipo ENUM('S', 'H') NOT NULL DEFAULT 'S',
  descrizione varchar(50) NOT NULL,
  prezzoOrario decimal(12,2) NOT NULL DEFAULT '0',
  costoHW decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB;

CREATE TABLE Lavorazione (
  ID int(11) NOT NULL AUTO_INCREMENT,
  dataInizio date NOT NULL,
  dataFine date NOT NULL,
  ore int(2) NOT NULL DEFAULT '0',
  costo decimal(12,2) NOT NULL DEFAULT '0',
  quantitaHW int(3) DEFAULT NULL,
  incarico int(11) NOT NULL,
  mansione int(11),
  dipendente int(11),
  PRIMARY KEY (ID),
  FOREIGN KEY (incarico) REFERENCES Incarico(ID),
  FOREIGN KEY (mansione) REFERENCES Mansione(ID) ON DELETE SET NULL,
  FOREIGN KEY (dipendente) REFERENCES Dipendente(ID) ON DELETE SET NULL
) ENGINE=InnoDB;


CREATE TABLE Abilitazione (
  dipendente int(11) NOT NULL,
  mansione int(11) NOT NULL,
  dataInizio date NOT NULL,
  PRIMARY KEY (dipendente, mansione),
  FOREIGN KEY (dipendente) REFERENCES Dipendente(ID) ON DELETE CASCADE,
  FOREIGN KEY (mansione) REFERENCES Mansione(ID) ON DELETE CASCADE
) ENGINE=InnoDB;


DROP VIEW IF EXISTS IncarichiNonTerminati;
DROP VIEW IF EXISTS IncarichiSenzaFattura;

CREATE VIEW IncarichiNonTerminati AS
SELECT ID, DataInizio, DataFine, Cliente
FROM Incarico
WHERE DataFine IS NULL;

CREATE VIEW IncarichiSenzaFattura AS
SELECT I.ID, I.DataInizio, I.DataFine, I.Cliente 
FROM Incarico AS I
WHERE I.ID NOT IN (SELECT I2.ID FROM Incarico AS I2 join Fattura AS F1 ON I2.ID=F1.Incarico)
  AND I.ID NOT IN (SELECT ID FROM IncarichiNonTerminati);