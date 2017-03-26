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