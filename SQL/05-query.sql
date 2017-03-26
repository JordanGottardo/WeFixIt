DROP VIEW IF EXISTS query1
DROP VIEW IF EXISTS query2
DROP VIEW IF EXISTS query3
DROP VIEW IF EXISTS query4
DROP VIEW IF EXISTS query5
DROP VIEW IF EXISTS query6
DROP VIEW IF EXISTS query7
DROP VIEW IF EXISTS query8
DROP VIEW IF EXISTS query9


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
	SELECT Cli.ID AS IdCliente, Cli.nominativo, AVG(Imponibile) AS MediaImponibile
	FROM Cliente AS Cli JOIN Incarico as Inc ON Cli.ID=Inc.Cliente JOIN Fattura as Fat ON Fat.Incarico=Inc.ID
	WHERE NOT EXISTS(
					SELECT Lav.Mansione FROM Lavorazione AS Lav WHERE Lav.Incarico=Inc.ID AND EXISTS (SELECT L.Mansione	
					FROM Lavorazione AS L JOIN IncarichiNonTerminati AS I on I.ID=L.Incarico JOIN Cliente AS C ON I.Cliente=C.ID 
					)
	AND Inc.ID NOT IN (SELECT ID FROM IncarichiNonTerminati)
	GROUP BY Cli.ID, Cli.Nominativo
	HAVING count(*)>=3 AND MediaImponibile>'500';

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
