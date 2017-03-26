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