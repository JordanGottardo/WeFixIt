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

DROP TRIGGER IF EXISTS before_mansione_insert;
DROP TRIGGER IF EXISTS before_mansione_update;
DROP TRIGGER IF EXISTS before_lavorazione_insert;
DROP TRIGGER IF EXISTS before_lavorazione_update;
DROP TRIGGER IF EXISTS before_incarico_insert;
DROP TRIGGER IF EXISTS before_incarico_update;
DROP TRIGGER IF EXISTS before_abilitazione_insert;
DROP TRIGGER IF EXISTS before_abilitazione_update;
DROP TRIGGER IF EXISTS before_cliente_insert;
DROP TRIGGER IF EXISTS before_cliente_update;
DROP TRIGGER IF EXISTS before_fattura_insert;

delimiter //
CREATE TRIGGER before_mansione_insert BEFORE INSERT ON Mansione
  FOR EACH ROW BEGIN
    IF (NEW.tipo = "S") THEN
      SET NEW.costoHW = NULL;
    ELSEIF (NEW.tipo = "H" AND NEW.costoHW IS NULL) THEN
      SET NEW.costoHW = 0;
    END IF;
  END//

CREATE TRIGGER before_mansione_update BEFORE UPDATE ON Mansione
  FOR EACH ROW BEGIN
    IF (NEW.tipo = "S") THEN
      SET NEW.costoHW = NULL;
    ELSEIF (NEW.tipo = "H" AND NEW.costoHW IS NULL) THEN
      SET NEW.costoHW = OLD.costoHW;
    END IF;
  END//

CREATE TRIGGER before_lavorazione_insert BEFORE INSERT ON Lavorazione
  FOR EACH ROW BEGIN
    DECLARE IDM int(11);
    DECLARE TM ENUM('S', 'H');
    DECLARE POM decimal(12,2);
    DECLARE PHM decimal(12,2);
    DECLARE IDI int(11);
    DECLARE DII date;
    DECLARE IDD int(11);

    SET IDM = NEW.mansione; 
    SET TM = (SELECT m.tipo FROM Mansione as m WHERE m.ID = IDM LIMIT 1);
        
    IF (TM = 'S' AND NEW.quantitaHW IS NOT NULL) THEN
      SET NEW.quantitaHW = NULL;
    ELSEIF (TM = 'H' AND NEW.quantitaHW IS NULL) THEN
      SET NEW.quantitaHW = 1;
    END IF;
    
    SET POM = (SELECT m.prezzoOrario FROM Mansione as m WHERE m.ID = IDM LIMIT 1);
    SET PHM = (SELECT m.costoHW FROM Mansione as m WHERE m.ID = IDM LIMIT 1);
    SET NEW.costo = (POM * NEW.ore) + (IFNULL(PHM, 0) * IFNULL(NEW.quantitaHW, 0));
    
    SET IDI = NEW.incarico;
    SET DII = (SELECT i.dataInizio FROM Incarico as i WHERE i.ID = IDI LIMIT 1);
       
    IF (NEW.dataInizio > NEW.dataFine) THEN
      SET NEW.dataFine = NEW.dataInizio;
    END IF;

    IF (NEW.dataInizio < DII) THEN
      SET NEW.dataInizio = DII;
    END IF;

    IF (NEW.dataFine < NEW.dataInizio) THEN
      SET NEW.dataFine = NEW.dataInizio;
    END IF;

    SET IDD = NEW.dipendente;

    IF ((SELECT a.dataInizio FROM Abilitazione AS a WHERE a.dipendente = IDD AND a.mansione = IDM) IS NULL) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Il dipendente selezionato non ha l\'abilitzione a svolgere la mansione';
    END IF;

  END//

CREATE TRIGGER before_lavorazione_update BEFORE UPDATE ON Lavorazione
  FOR EACH ROW BEGIN
    DECLARE IDM int(11);
    DECLARE TM ENUM('S', 'H');
    DECLARE IDF int(11);
    DECLARE POM decimal(12,2);
    DECLARE PHM decimal(12,2);
    DECLARE IDD int(11);
    
    SET IDM = (SELECT l.mansione FROM Lavorazione AS l WHERE l.ID = NEW.ID);
    SET TM = (SELECT m.tipo FROM Mansione as m WHERE m.ID = IDM LIMIT 1);

    IF (TM = 'S' AND NEW.quantitaHW IS NOT NULL) THEN
      SET NEW.quantitaHW = NULL;
    ELSEIF (TM = 'H' AND NEW.quantitaHW IS NULL) THEN
      SET NEW.quantitaHW = OLD.quantitaHW;
    END IF;
    
    SET POM = (SELECT m.prezzoOrario FROM Mansione as m WHERE m.ID = IDM LIMIT 1);
    SET PHM = (SELECT m.costoHW FROM Mansione as m WHERE m.ID = IDM LIMIT 1);
    SET NEW.costo = (POM * NEW.ore) + (IFNULL(PHM, 0) * IFNULL(NEW.quantitaHW, 0));
        
    SET IDF = (SELECT f.ID FROM Fattura as f WHERE f.incarico = NEW.incarico);

    IF (IDF IS NOT NULL) THEN
      BEGIN
        DECLARE TOT decimal(12,2);

        SET TOT = (SELECT SUM(l.costo) FROM Lavorazione as l WHERE l.incarico = NEW.incarico);
        UPDATE fattura as f SET f.imponibile = TOT WHERE f.incarico = NEW.incarico;
      END;
    END IF;

    IF (OLD.dataFine <> NEW.dataFine AND NEW.dataFine < NEW.dataInizio) THEN
            SET NEW.dataFine = OLD.dataFine;
    END IF;
    
    IF (OLD.dataInizio <> NEW.dataInizio) THEN         
      IF (NEW.dataInizio > NEW.dataFine) THEN
        SET NEW.dataInizio = OLD.dataInizio;
      END IF;
      
      BEGIN
        DECLARE IDI int(11);
        DECLARE DII date;

        SET IDI = NEW.incarico;
        SET DII = (SELECT i.dataInizio FROM Incarico as i, Lavorazione as l WHERE i.ID = IDI LIMIT 1);

        IF (NEW.dataInizio < DII) THEN
          SET NEW.dataInizio = DII;
        END IF;
      END;
    END IF;

    SET IDD = NEW.dipendente;

    IF (NEW.dipendente <> OLD.dipendente) THEN
        IF ((SELECT a.dataInizio FROM Abilitazione AS a WHERE a.dipendente = IDD AND a.mansione = IDM) IS NULL) THEN
            SET NEW.dipendente = OLD.dipendente;
        END IF;
    END IF;

  END//

CREATE TRIGGER before_incarico_insert BEFORE INSERT ON Incarico
  FOR EACH ROW BEGIN
    IF (NEW.dataFine IS NOT NULL) THEN
      SET NEW.dataFine = NULL;
    END IF;
  END//

CREATE TRIGGER before_incarico_update BEFORE UPDATE ON Incarico
  FOR EACH ROW BEGIN
    IF (OLD.dataFine IS NULL AND NEW.dataFine IS NOT NULL) OR (OLD.dataFine <> NEW.dataFine) THEN            
      IF (NEW.dataFine < OLD.dataInizio) THEN
        SET NEW.dataFine = OLD.dataFine;
      END IF;
      
      BEGIN      
        DECLARE IDI int(11);
        DECLARE DFL date;

        SET IDI = NEW.ID;
        SET DFL = (SELECT MAX(l.dataFine) FROM Lavorazione as l WHERE l.incarico = IDI );
              
        IF (DFL IS NOT NULL) THEN
          IF (NEW.dataFine < DFL) THEN
            SET NEW.dataFine = DFL;
          END IF;
        END IF;
      END;
    END IF;
        
    IF (OLD.dataInizio <> NEW.dataInizio AND NEW.dataInizio > NEW.dataFine) THEN
      SET NEW.dataInizio = OLD.dataInizio;
    END IF;
  END//

CREATE TRIGGER before_abilitazione_insert BEFORE INSERT ON Abilitazione
  FOR EACH ROW BEGIN
    DECLARE DA int(11);
    DECLARE DAD date;

    SET DA = NEW.dipendente;
    SET DAD = (SELECT d.dataAssunzione FROM Dipendente as d WHERE d.ID = DA);
       
    IF (NEW.dataInizio < DAD) THEN
      SET NEW.dataInizio = DAD;
    END IF;
  END//

CREATE TRIGGER before_abilitazione_update BEFORE UPDATE ON Abilitazione
  FOR EACH ROW BEGIN
    DECLARE DA int(11);
    DECLARE DAD date;

    SET DA = NEW.dipendente;
    SET DAD = (SELECT d.dataAssunzione FROM Dipendente as d WHERE d.ID = DA);
        
    IF (NEW.dataInizio < DAD) THEN
      SET NEW.dataInizio = OLD.dataInizio;
    END IF;
  END//

CREATE TRIGGER before_cliente_insert BEFORE INSERT ON Cliente
  FOR EACH ROW BEGIN
    IF (NEW.codiceFiscale IS NOT NULL AND NEW.partitaIVA IS NOT NULL) THEN
      IF (NEW.tipo = 'P') THEN
        SET NEW.partitaIVA = NULL;
      ELSEIF (NEW.tipo = 'I') THEN
        SET NEW.codiceFiscale = NULL;
      END IF;
    END IF;

    IF (NEW.codiceFiscale IS NULL AND NEW.partitaIVA IS NULL) THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '\'codiceFiscale\' e \'partitaIVA\' non possono essere entrambi NULL';
    END IF;
  END//

CREATE TRIGGER before_cliente_update BEFORE UPDATE ON Cliente
  FOR EACH ROW BEGIN
    IF (NEW.codiceFiscale IS NOT NULL AND NEW.partitaIVA IS NOT NULL) THEN
      IF (NEW.tipo = 'P') THEN
        SET NEW.partitaIVA = NULL;
      ELSEIF (NEW.tipo = 'I') THEN
        SET NEW.codiceFiscale = NULL;
      END IF;
    END IF;
  END//

CREATE TRIGGER before_fattura_insert BEFORE INSERT ON Fattura
  FOR EACH ROW BEGIN
    DECLARE TCL decimal(12,2);

    SET TCL = (SELECT SUM(l.costo) FROM Lavorazione as l WHERE l.incarico = NEW.incarico);
    SET NEW.imponibile = IFNULL(TCL,0);
  END//

delimiter ;

DROP procedure IF EXISTS modPrezzoOrario;
DROP function IF EXISTS cercaFattura;
DROP function IF EXISTS lavorazioniDipCitta;

delimiter //

CREATE PROCEDURE modPrezzoOrario(IN tipoMans ENUM('S', 'H', 'A'), IN per decimal(4,2), IN lim decimal(12,2))
    BEGIN
        DECLARE mSign tinyint(1);

        IF (per < 0) THEN
            SET mSign = -1;
        ELSE
            SET mSign = 1;
        END IF;

        UPDATE Mansione AS m1
        SET m1.prezzoOrario = m1.prezzoOrario + (m1.prezzoOrario * (per/100))
        WHERE (m1.tipo = tipoMans OR IF(tipoMans like 'A', true, false))
        AND (mSign*lim) > mSign*(SELECT AVG(l2.costo) FROM Lavorazione AS l2 WHERE l2.mansione = m1.ID);
    END //


CREATE FUNCTION cercaFattura(FID int(11), impMin decimal(12,2), impMax decimal(12,2), IVA bool) RETURNS decimal(12,2)
BEGIN
    DECLARE IMP decimal(12,2);
    SET IMP = (SELECT f.imponibile FROM Fattura AS f WHERE f.ID=FID);

    IF (impMin IS NULL) THEN
        SET impMin = 0;
    END IF;
    IF (impMax = 0) THEN
        SET impMax = NULL;
    END IF;

    IF (IVA = 0) THEN
        IF ((IMP >= impMin) AND (IFNULL(IMP <= impMax, true))) THEN
            RETURN IMP;
        END IF;
        RETURN NULL;
    ELSE
        SET IVA = (SELECT f.aliquota FROM Fattura AS f WHERE f.ID = FID);
        SET IMP = IMP + (IMP * (IVA/100));
            IF ((IMP >= impMin) AND (IFNULL(IMP <= impMax, true))) THEN
                RETURN IMP;
            END IF;
        RETURN NULL;
    END IF;
END //


CREATE FUNCTION lavorazioniDipCitta(luogo varchar(255)) RETURNS int(11)
BEGIN
    DECLARE LAV int(11);

    SELECT COUNT(*) INTO LAV
    FROM Lavorazione AS l1 JOIN Dipendente AS d1 ON l1.dipendente = d1.ID
        JOIN Incarico AS i1 ON l1.incarico = i1.ID
        JOIN Cliente AS c1 ON i1.cliente = c1.ID
        WHERE c1.citta = luogo
    GROUP BY d1.ID;

    RETURN LAV;
END //

delimiter ;

INSERT INTO Cliente (ID, tipo, nominativo, codiceFiscale, partitaIVA, indirizzo, citta, telefono) VALUES
(1, 'P', 'Mario Bianchi', 'MRABCH70H13G224J', NULL, 'Via Rossi 29', 'Padova', '049134845'),
(2, 'P', 'Matteo Gallo', 'MTTGLL84H13G999V', NULL, 'Via dei Tigli 2', 'Prato', '03845687412'),
(3, 'P', 'Tommaso Sagese', 'TMMSGS84H13L378F', NULL, 'Corso Porta Borsari, 23', 'Trento', '0358 027931'),
(4, 'P', 'Ortensia Padovano', 'RTNPVN76H13G478S', NULL, 'Via Croce Rossa, 142', 'Perugia', '0379882541'),
(5, 'P', 'Ludovica Sal', 'SLALVC76H13G478G', NULL, 'Via Goffredo Mameli, 56', 'Rimini', '0329 276383'),
(6, 'P', 'Gregorio Ferri', 'FRRGGR89L05D086S', NULL, 'Viale Ippocrate, 2', 'Cosenza', '0311 061732'),
(7, 'I', 'WeBreakIt SRL', NULL, '84961694189', 'Viale Augusto, 144', 'Perugia', '03253230105'),
(8, 'I', 'Pneus SPA', NULL, '14910588197', 'Via Guantai Nuovi, 136', 'Perugia', '0335 364730'),
(9, 'I', 'Lazzarel SNC', NULL, '14141694194', 'Via Tasso, 68', 'Taranto', '03938490556'),
(10, 'I', 'Caramel SRL', NULL, '48189479878', 'Via del Mascherone, 50', 'Vicenza', '04445929879');

INSERT INTO Dipendente (ID, nome, cognome, dataAssunzione) VALUES
(1, 'Walter', 'Lucciano', '2000-06-07'),
(2, 'Abelina', 'Siciliano', '2001-06-04'),
(3, 'Carla', 'Schiavone', '2001-11-30'),
(4, 'Bartolomeo', 'Genovesi', '2004-04-06'),
(5, 'Fiammetta', 'Nucci', '2006-07-08');

INSERT INTO Mansione (ID, tipo, descrizione, prezzoOrario, costoHW) VALUES
(1, 'S', 'Installazione antivirus', '20.00', NULL),
(2, 'S', 'Deframmentazione hard disk', '14.00', NULL),
(3, 'S', 'Formattazione disco', '16.00', NULL),
(4, 'S', 'Aggiornamento OS', '30.00', NULL),
(5, 'H', 'Installazione CPU', '40.00', '200.00'),
(6, 'H', 'Installazione ventole', '30.00', '20.00'),
(7, 'H', 'Sostituzione pasta termica', '10.00', '5.00'),
(8, 'H', 'Pulizia PC', '15.00', '0.00'),
(9, 'S', 'Installazione driver', '15.00', NULL);

INSERT INTO Abilitazione (dipendente, mansione, dataInizio) VALUES
(1,4,'2002-05-09'),
(1,5,'2002-09-20'),
(1,7,'2003-01-30'),
(1,8,'2002-05-10'),
(2,1,'2003-10-23'),
(2,6,'2002-04-18'),
(2,8,'2002-03-02'),
(3,3,'2002-10-09'),
(3,6,'2002-06-17'),
(3,7,'2003-11-14'),
(3,8,'2002-09-20'),
(4,2,'2004-06-08'),
(4,5,'2004-10-12'),
(4,8,'2004-05-11'),
(5,1,'2006-12-02'),
(5,2,'2006-06-13'),
(5,3,'2007-05-19'),
(5,8,'2006-10-20'),
(5, 9, '2008-05-05');

INSERT INTO Incarico (ID, dataInizio, dataFine, cliente) VALUES
(1,'2016-04-20',NULL,5),
(2,'2016-05-10',NULL,1),
(3,'2016-05-15',NULL,1),
(4,'2015-10-20','2015-12-16',8),
(5,'2015-06-18','2015-07-04',10),
(6,'2015-02-12','2015-03-14',4),
(7,'2015-02-20','2015-03-22',6),
(8,'2016-03-11',NULL,9),
(9,'2016-01-24',NULL,2),
(10,'2016-04-25',NULL,7),
(11,'2015-09-19','2015-10-23',5),
(12,'2015-05-27','2015-07-10',3),
(13,'2015-02-06','2015-02-24',8),
(14,'2016-04-15',NULL,5),
(15,'2016-05-26',NULL,3),
(16,'2016-06-01',NULL,9),
(17,'2016-06-05',NULL,10),
(18,'2016-05-26',NULL,8),
(19,'2016-06-02',NULL,3),
(20,'2016-06-06',NULL,7),
(21, '2016-06-01', '2016-06-25', 1),
(22, '2016-06-01', '2016-06-20', 1);

INSERT INTO Lavorazione (ID, dataInizio, dataFine, ore, costo, quantitaHW, incarico, mansione, dipendente) VALUES
(1,'2016-04-21','2016-05-13',45,630.00,NULL,1,2,5),
(2,'2016-04-20','2016-05-20',45,1410.00,3,1,6,3),
(3,'2016-04-22','2016-06-21',3,95.00,13,1,7,1),
(4,'2016-04-21','2016-05-19',26,390.00,10,1,8,1),
(5,'2016-04-24','2016-06-01',22,308.00,NULL,1,2,4),
(6,'2016-04-23','2016-05-22',29,406.00,NULL,1,2,5),
(7,'2016-05-13','2016-06-24',33,660.00,NULL,2,1,5),
(8,'2016-05-11','2016-07-07',38,570.00,6,2,8,4),
(9,'2016-05-13','2016-06-27',27,432.00,NULL,2,3,3),
(10,'2016-05-11','2016-06-18',32,385.00,13,2,7,1),
(11,'2016-05-14','2016-06-14',21,315.00,10,2,8,1),
(12,'2016-05-10','2016-06-13',35,1350.00,15,2,6,3),
(13,'2016-05-11','2016-06-13',45,1350.00,NULL,2,4,1),
(14,'2016-05-13','2016-06-14',42,1260.00,NULL,2,4,1),
(15,'2016-05-12','2016-06-21',19,266.00,NULL,2,2,4),
(16,'2016-05-11','2016-07-02',40,560.00,NULL,2,2,4),
(17,'2016-05-16','2016-06-22',40,1400.00,10,3,6,2),
(18,'2016-05-15','2016-07-08',39,780.00,NULL,3,1,5),
(19,'2016-05-18','2016-07-01',9,135.00,4,3,8,2),
(20,'2016-05-17','2016-06-27',13,770.00,19,3,6,3),
(21,'2016-05-16','2016-06-24',45,6800.00,25,3,5,1),
(22,'2016-05-16','2016-07-09',41,505.00,19,3,7,3),
(23,'2016-05-15','2016-06-30',36,720.00,NULL,3,1,2),
(24,'2015-10-20','2015-11-18',20,860.00,13,4,6,2),
(25,'2015-10-22','2015-12-15',31,930.00,NULL,4,4,1),
(26,'2015-10-21','2015-12-13',22,5680.00,24,4,5,1),
(27,'2015-10-20','2015-11-30',46,920.00,NULL,4,1,2),
(28,'2015-10-23','2015-12-04',38,445.00,13,4,7,1),
(29,'2015-06-18','2015-06-25',45,630.00,NULL,5,2,4),
(30,'2015-06-19','2015-06-28',45,5600.00,19,5,5,4),
(31,'2015-06-18','2015-07-02',26,520.00,NULL,5,1,2),
(32,'2015-06-20','2015-07-01',7,2680.00,12,5,5,4),
(33,'2015-06-19','2015-06-29',34,510.00,5,5,8,5),
(34,'2015-06-21','2015-06-24',4,80.00,NULL,5,1,5),
(35,'2015-06-23','2015-06-30',18,235.00,11,5,7,3),
(36,'2015-06-19','2015-07-02',20,320.00,NULL,5,3,3),
(37,'2015-06-19','2015-06-23',35,490.00,NULL,5,2,5),
(38,'2015-02-12','2015-03-13',21,420.00,NULL,6,1,5),
(39,'2015-02-11','2015-02-20',23,290.00,12,6,7,3),
(40,'2015-02-12','2015-03-04',47,1410.00,NULL,6,4,1),
(41,'2015-02-13','2015-02-26',48,570.00,18,6,7,3),
(42,'2015-02-22','2015-03-21',34,510.00,3,7,8,4),
(43,'2015-02-24','2015-03-09',29,910.00,2,7,6,3),
(44,'2015-02-24','2015-03-14',5,2200.00,10,7,5,1),
(45,'2015-02-24','2015-03-04',39,1170.00,NULL,7,3,3),
(46,'2015-02-22','2015-02-25',16,224.00,NULL,7,2,5),
(47,'2015-02-24','2015-03-18',48,600.00,24,7,7,3),
(48,'2015-02-22','2015-02-26',37,450.00,16,7,1,5),
(49,'2015-02-21','2015-03-07',12,360.00,NULL,7,4,1),
(50,'2016-03-12','2016-04-30',48,1680.00,12,8,6,3),
(51,'2016-03-12','2016-04-18',15,2800.00,11,8,5,1),
(52,'2016-03-12','2016-05-01',16,224.00,NULL,8,2,5),
(53,'2016-03-13','2016-05-11',17,272.00,NULL,8,3,5),
(54,'2016-03-14','2016-05-09',45,1650.00,15,8,6,3),
(55,'2016-03-11','2016-04-29',48,720.00,23,8,8,5),
(56,'2016-03-14','2016-05-06',46,690.00,25,8,8,2),
(57,'2016-01-24','2016-02-11',13,390.00,NULL,9,4,1),
(58,'2016-01-25','2016-02-20',22,440.00,NULL,9,1,2),
(59,'2016-01-26','2016-02-22',11,330.00,NULL,9,4,1),
(60,'2016-01-24','2016-02-04',26,1220.00,22,9,6,3),
(61,'2016-01-24','2016-02-20',3,42.00,NULL,9,2,5),
(62,'2016-01-23','2016-01-29',36,1340.00,13,9,6,2),
(63,'2016-01-24','2016-01-26',3,90.00,NULL,9,4,1),
(64,'2016-04-25','2016-05-16',43,645.00,11,10,8,4),
(65,'2016-04-26','2016-05-04',34,544.00,NULL,10,3,3),
(66,'2016-04-25','2016-05-15',26,2240.00,6,10,5,4),
(67,'2016-04-27','2016-05-06',17,238.00,NULL,10,2,4),
(68,'2016-04-26','2016-05-08',43,688.00,NULL,10,3,3),
(69,'2015-09-19','2015-10-18',2,40.00,NULL,11,1,2),
(70,'2015-09-21','2015-10-12',38,608.00,NULL,11,3,5),
(71,'2015-09-22','2015-10-21',22,1100.00,22,11,6,3),
(72,'2015-09-21','2015-10-11',4,120.00,NULL,11,4,1),
(73,'2015-09-19','2015-10-11',23,2120.00,6,11,5,1),
(74,'2015-09-19','2015-10-09',5,70.00,NULL,11,2,5),
(75,'2015-09-22','2015-10-21',2,60.00,8,11,7,1),
(76,'2015-09-23','2015-10-13',12,180.00,23,11,8,5),
(77,'2015-05-27','2015-06-24',48,1880.00,22,12,6,3),
(78,'2015-05-29','2015-06-29',46,644.00,NULL,12,2,5),
(79,'2015-05-29','2015-06-13',14,3760.00,16,12,5,4),
(80,'2015-05-28','2015-06-16',4,64.00,NULL,12,3,5),
(81,'2015-05-27','2015-06-16',22,440.00,NULL,12,1,2),
(82,'2015-05-30','2015-07-04',13,182.00,NULL,12,2,5),
(83,'2015-05-27','2015-06-30',31,970.00,2,12,6,3),
(84,'2015-05-29','2015-07-09',28,1720.00,3,12,5,4),
(85,'2015-05-28','2015-06-18',41,1670.00,22,12,6,2),
(86,'2015-02-07','2015-02-24',22,308.00,NULL,13,2,4),
(87,'2015-02-06','2015-02-16',28,448.00,NULL,13,3,5),
(88,'2015-02-08','2015-02-22',5,170.00,24,13,7,1),
(89,'2016-04-17','2016-05-26',43,860.00,NULL,14,1,5),
(90,'2016-04-15','2016-05-29',23,4920.00,20,14,5,4),
(91,'2016-04-17','2016-05-21',25,375.00,7,14,8,1),
(92,'2016-04-15','2016-05-27',2,32.00,NULL,14,3,5),
(93,'2016-04-18','2016-05-20',41,1230.00,NULL,14,4,1),
(94,'2016-04-16','2016-05-11',43,860.00,NULL,14,1,5),
(95,'2016-04-17','2016-05-18',2,28.00,NULL,14,2,5),
(96,'2016-04-16','2016-05-11',40,800.00,NULL,14,1,5),
(97,'2016-04-15','2016-05-18',26,390.00,10,14,8,4),
(98,'2016-05-27','2016-06-09',20,300.00,1,15,8,3),
(99,'2016-05-28','2016-06-06',37,555.00,24,15,8,3),
(100,'2016-05-27','2016-06-24',29,1050.00,9,15,6,2),
(101,'2016-05-26','2016-06-12',7,470.00,13,15,6,2),
(102,'2016-05-27','2016-06-04',20,320.00,NULL,15,3,3),
(103,'2016-05-28','2016-06-13',34,544.00,NULL,15,3,3),
(104,'2016-05-29','2016-06-26',24,315.00,15,15,7,1),
(105,'2016-05-26','2016-06-19',41,1230.00,NULL,15,4,1),
(106,'2016-06-01','2016-06-26',23,322.00,NULL,16,2,5),
(107,'2016-06-02','2016-06-12',21,294.00,NULL,16,2,5),
(108,'2016-06-01','2016-06-28',23,970.00,14,17,6,2),
(109,'2016-06-06','2016-06-27',26,364.00,NULL,17,2,5),
(110,'2016-06-06','2016-07-05',40,1440.00,12,17,6,2),
(111,'2016-06-05','2016-07-03',41,574.00,NULL,17,2,4),
(112,'2016-06-08','2016-07-06',46,644.00,NULL,17,2,5),
(113,'2016-06-07','2016-07-02',13,235.00,21,17,7,1),
(114,'2016-06-06','2016-06-13',14,196.00,NULL,17,2,4),
(115,'2016-06-07','2016-07-12',6,96.00,NULL,17,3,5),
(116,'2016-05-26','2016-06-20',48,595.00,23,18,7,1),
(117,'2016-05-27','2016-06-05',44,660.00,15,18,8,4),
(118,'2016-05-26','2016-06-13',40,560.00,NULL,18,2,4),
(119,'2016-05-28','2016-06-13',12,3080.00,13,18,5,4),
(120,'2016-05-27','2016-06-22',16,320.00,NULL,18,3,5),
(121,'2016-05-29','2016-06-30',47,940.00,NULL,18,1,5),
(122,'2016-05-26','2016-06-04',33,455.00,25,18,6,3),
(123,'2016-05-27','2016-06-13',7,210.00,NULL,18,4,1),
(124,'2016-06-03','2016-06-13',2,40.00,NULL,19,1,2),
(125,'2016-06-03','2016-06-21',5,3400.00,16,19,5,4),
(126,'2016-06-02','2016-07-02',30,420.00,NULL,19,2,4),
(127,'2016-06-03','2016-07-12',13,195.00,9,19,8,2),
(128,'2016-06-04','2016-07-09',22,1120.00,23,19,6,2),
(129,'2016-06-04','2016-06-19',31,930.00,NULL,19,4,1),
(130,'2016-06-06','2016-06-19',12,180.00,3,19,8,5),
(131,'2016-06-04','2016-06-20',29,435.00,9,19,8,5),
(132,'2016-06-02','2016-06-12',43,1290.00,NULL,19,4,1),
(133,'2016-06-05','2016-06-19',16,320.00,NULL,19,1,2),
(134,'2016-06-03','2016-06-20',11,220.00,NULL,19,1,2),
(135,'2016-06-06','2016-07-02',20,600.00,NULL,20,4,1),
(136,'2016-06-08','2016-06-18',11,154.00,NULL,20,2,4),
(137,'2016-06-07','2016-06-29',25,315.00,13,20,7,3),
(138,'2016-06-10','2016-06-21',32,448.00,NULL,20,2,5),
(139,'2016-06-12','2016-06-29',36,540.00,23,20,8,1),
(140,'2016-06-07','2016-07-09',44,560.00,24,20,7,1),
(141,'2016-06-09','2016-06-20',15,225.00,5,20,8,4),
(142,'2016-06-08','2016-06-25',21,336.00,NULL,20,3,5),
(143, '2016-06-10', '2016-06-10', 55, '825.00', NULL, 21, 9, 5),
(144, '2016-06-11', '2016-06-11', 45, '675.00', NULL, 22, 9, 5);

INSERT INTO Fattura (ID, dataEmissione, imponibile, aliquota, incarico) VALUES
(1, '2015-02-26', '926.00', '22.00', 13),
(2, '2015-07-10', '11330.00', '21.00', 12),
(3, '2015-10-29', '4298.00', '22.00', 11),
(4, '2015-03-22', '6168.00', '20.00', 7),
(5, '2015-03-14', '2690.00', '22.00', 6),
(6, '2015-07-06', '11065.00', '22.00', 5),
(7, '2015-12-16', '8835.00', '21.00', 4),
(8, '2016-06-28', '675.00', '22.00', 22),
(9, '2016-06-30', '825.00', '22.00', 21);


DROP VIEW IF EXISTS query1;
DROP VIEW IF EXISTS query2;
DROP VIEW IF EXISTS query3;
DROP VIEW IF EXISTS query4;
DROP VIEW IF EXISTS query5;
DROP VIEW IF EXISTS query6;
DROP VIEW IF EXISTS query7;
DROP VIEW IF EXISTS query8;
DROP VIEW IF EXISTS query9;

CREATE VIEW query1 AS
  SELECT C.Id as IdCliente, C.Nominativo, I.Id AS IdIncarico, I.DataInizio
  FROM Cliente as C JOIN IncarichiNonTerminati AS I on C.Id=I.Cliente;
      
      
CREATE VIEW query2 AS
  SELECT DISTINCT M.ID AS IdMansione, M.Descrizione, F.ID as IdFattura
  FROM Mansione as M join Lavorazione as L on M.ID=L.Mansione JOIN Incarico as I on L.Incarico=I.ID JOIN Fattura as F on I.ID=F.Incarico;
        
CREATE VIEW query3 AS
  SELECT C.ID as IdCliente, count(*) AS NumeroIncarichi
  FROM Cliente AS C JOIN Incarico AS I  ON C.ID=I.Cliente
  WHERE YEAR(I.DataInizio)=YEAR(NOW()) AND MONTH(I.DataInizio)=MONTH(NOW())
  GROUP BY IdCliente
  HAVING NumeroIncarichi>=1;

CREATE VIEW query4 AS
  SELECT YEAR(DataEmissione) AS Anno, SUM(Imponibile) as Totale, AVG(Imponibile) AS MediaFatturato
  FROM Fattura
  GROUP BY Anno;
        
CREATE VIEW query5 AS
  SELECT INC.ID AS IdIncarico, INC.DataInizio, SUM(LAV.quantitaHW) AS TotalePezzi
  FROM Incarico as INC JOIN Lavorazione as LAV on INC.ID=LAV.Incarico 
  WHERE INC.ID IN(
          SELECT I.ID
          FROM Incarico as I JOIN Lavorazione as L ON I.ID=L.Incarico JOIN Mansione as M on M.ID=L.Mansione 
          WHERE M.Tipo='S'
          )
    AND INC.ID IN(
          SELECT I.ID
          FROM Incarico as I JOIN Lavorazione as L ON I.ID=L.Incarico JOIN Mansione as M on M.ID=L.Mansione 
          WHERE M.Tipo='H'
          GROUP BY I.ID
          HAVING count(*)>=2 AND SUM(quantitaHW)>=50
          )
  GROUP BY IdIncarico, INC.DataInizio;
            
            
CREATE VIEW query6 AS
SELECT Cli.ID AS IdCliente, Cli.Nominativo, AVG(Imponibile) AS MediaImponibile
FROM Cliente AS Cli JOIN Incarico as Inc ON Cli.ID=Inc.Cliente JOIN Fattura as Fat ON Fat.Incarico=Inc.ID
WHERE NOT EXISTS(
								SELECT Lav.Mansione FROM Lavorazione AS Lav WHERE Lav.Incarico=Inc.ID AND EXISTS (SELECT L.Mansione	
								FROM Lavorazione AS L JOIN IncarichiNonTerminati AS I on I.ID=L.Incarico JOIN Cliente AS C ON I.Cliente=C.ID 
								WHERE C.Tipo='I' AND Lav.Mansione=L.Mansione)
								)
AND Inc.ID NOT IN (SELECT ID FROM IncarichiNonTerminati)
GROUP BY Cli.ID, Cli.Nominativo
HAVING count(*)>=2 AND MediaImponibile>500;

CREATE VIEW query7 AS
  SELECT * FROM Incarico AS i1 WHERE(
                  SELECT COUNT(*) FROM Lavorazione AS l3 WHERE l3.incarico = i1.ID AND l3.mansione NOT IN
                    (
                    SELECT l4.mansione FROM Lavorazione AS l4 WHERE l4.incarico = i1.ID AND l4.ID <> l3.ID)
                  ) = (SELECT COUNT(*) FROM Mansione);

CREATE VIEW query8 AS
  SELECT SUM(f1.imponibile) FROM Fattura AS f1 JOIN Incarico AS i1 ON i1.ID=f1.incarico JOIN Lavorazione as l1 ON l1.incarico=i1.ID
  WHERE (i1.dataInizio + INTERVAL 7 DAY) <= (l1.dataFine);

CREATE VIEW query9 AS
  SELECT DISTINCT i1.ID AS idIncarico, d1.Nome, d1.Cognome FROM Incarico AS i1
  JOIN Lavorazione AS l1 ON l1.incarico=i1.ID JOIN Dipendente as d1 ON l1.dipendente=d1.ID
  WHERE (l1.dataInizio > (CURDATE() - INTERVAL 365 DAY))
  AND EXISTS (SELECT * FROM Lavorazione AS l2 JOIN Abilitazione AS a2 ON l2.mansione = a2.mansione
              WHERE l2.incarico = i1.ID AND a2.dipendente <> d1.ID)
  AND (SELECT SUM(l3.ore) FROM Lavorazione AS l3 WHERE l3.dipendente = d1.ID AND l3.incarico = i1.ID) > 100
  ORDER BY idIncarico;


UPDATE Incarico SET dataFine = '2015-12-16' WHERE ID = 4;
UPDATE Incarico SET dataFine = '2015-07-04' WHERE ID = 5;
UPDATE Incarico SET dataFine = '2015-03-14' WHERE ID = 6;
UPDATE Incarico SET dataFine = '2015-03-22' WHERE ID = 7;
UPDATE Incarico SET dataFine = '2015-10-23' WHERE ID = 11;
UPDATE Incarico SET dataFine = '2015-07-10' WHERE ID = 12;
UPDATE Incarico SET dataFine = '2015-02-24' WHERE ID = 13;
UPDATE Incarico SET dataFine = '2016-06-25' WHERE ID = 21;
UPDATE Incarico SET dataFine = '2016-06-20' WHERE ID = 22;