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
(8, 'H', 'Pulizia PC', '15.00', '0.00');

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
(5,8,'2006-10-20');

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
(20,'2016-06-06',NULL,7);

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
(142,'2016-06-08','2016-06-25',21,336.00,NULL,20,3,5);

UPDATE Incarico SET dataFine = '2015-12-16' WHERE ID = 4;
UPDATE Incarico SET dataFine = '2015-07-04' WHERE ID = 5;
UPDATE Incarico SET dataFine = '2015-03-14' WHERE ID = 6;
UPDATE Incarico SET dataFine = '2015-03-22' WHERE ID = 7;
UPDATE Incarico SET dataFine = '2015-10-23' WHERE ID = 11;
UPDATE Incarico SET dataFine = '2015-07-10' WHERE ID = 12;
UPDATE Incarico SET dataFine = '2015-02-24' WHERE ID = 13;

INSERT INTO Fattura (ID, dataEmissione, imponibile, aliquota, incarico) VALUES
(1, '2015-02-26', '926.00', '22.00', 13),
(2, '2015-07-10', '11330.00', '21.00', 12),
(3, '2015-10-29', '4298.00', '22.00', 11),
(4, '2015-03-22', '6168.00', '20.00', 7),
(5, '2015-03-14', '2690.00', '22.00', 6),
(6, '2015-07-06', '11065.00', '22.00', 5),
(7, '2015-12-16', '8835.00', '21.00', 4);