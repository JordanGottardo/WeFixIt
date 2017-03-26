function checkClientePrivato()
{
	with(document.formCliente)
	{
		if (nominativo.value=="")
		{
			alert("Compila il campo Nominativo");
			nominativo.focus();
			return false;
		}
		if (codFiscale.value=="")
		{
			alert("Compila il campo Codice fiscale");
			codFiscale.focus();
			return false;
		}
		if (indirizzo.value=="")
		{
			alert("Compila il campo Indirizzo");
			indirizzo.focus();
			return false;
		}
		if (citta.value=="")
		{
			alert("Compila il campo Città");
			citta.focus();
			return false;
		}
		if (telefono.value=="")
		{
			alert("Compila il campo Telefono");
			telefono.focus();
			return false;
		}
	}
}

function checkImpresa()
{
	with(document.formCliente)
	{
		if (nominativo.value=="")
		{
			alert("Compila il campo Nominativo")
			nominativo.focus();
			return false;
		}
		if (pIva.value=="")
		{
			alert("Compila il campo Partita Iva")
			codFiscale.focus();
			return false;
		}
		if (indirizzo.value=="")
		{
			alert("Compila il campo Indirizzo")
			indirizzo.focus();
			return false;
		}
		if (citta.value=="")
		{
			alert("Compila il campo Città")
			citta.focus();
			return false;
		}
		if (telefono.value=="")
		{
			alert("Compila il campo Telefono")
			telefono.focus();
			return false;
		}
	}
}

function checkIncarico()
{
	with(document.formIncarico)
	{
		if (dataIni.value=="")
		{
			alert("Compila il campo Data inizio")
			dataIni.focus();
			return false;
		}
	}
}

function checkFattura()
{
	with(document.formFattura)
	{
		if (data.value=="")
		{
			alert("Compila il campo Data")
			data.focus();
			return false;
		}
		if (aliquota.value=="")
		{
			alert("Compila il campo Aliquota")
			aliquota.focus();
			return false;
		}
	}
}

function checkLavorazione()
{
	with(document.formLavorazione)
	{
		if (dataIni.value=="")
		{
			alert("Compila il campo Data inizio")
			dataIni.focus();
			return false;
		}
		if (dataFine.value=="")
		{
			alert("Compila il campo Data fine")
			dataFine.focus();
			return false;
		}
		if (ore.value=="")
		{
			alert("Compila il campo Ore")
			ore.focus();
			return false;
		}
		
	}
}

function checkSoftware()
{
		with(document.formMansione)
	{
		if (descrizione.value=="")
		{
			alert("Compila il campo Descrizione")
			descrizione.focus();
			return false;
		}
		if (prezzo.value=="")
		{
			alert("Compila il campo Prezzo orario")
			prezzo.focus();
			return false;
		}
	}	
}

function checkHardware()
{
		with(document.formMansione)
	{
		if (descrizione.value=="")
		{
			alert("Compila il campo Descrizione")
			descrizione.focus();
			return false;
		}
		if (prezzo.value=="")
		{
			alert("Compila il campo Prezzo orario")
			prezzo.focus();
			return false;
		}
		if (costoHW.value=="")
		{
			alert("Compila il campo Costo HW")
			costoHW.focus();
			return false;
		}
	}	
}

function checkDipendente()
{
		with(document.formDipendente)
	{
		if (nome.value=="")
		{
			alert("Compila il campo Nome")
			nome.focus();
			return false;
		}
		if (cognome.value=="")
		{
			alert("Compila il campo Cognome")
			cognome.focus();
			return false;
		}
		if (dataAssunzione.value=="")
		{
			alert("Compila il campo Data assunzione")
			dataAssunzione.focus();
			return false;
		}
	}	
}

function checkAbilitazione()
{
	with(document.formAbilitazione)
	{
		if (dataIni.value=="")
		{
			alert("Compila il campo Data inizio")
			dataIni.focus();
			return false;
		}
	}
}

function checkFunzione1()
{
	with(document.formFunzione1)
	{
		if (citta.value=="")
		{
			alert("Compila il campo Citta")
			citta.focus();
			return false;
		}
	}
}

function checkFunzione2()
{
	with(document.formFunzione2)
	{
		if (X.value=="")
		{
			alert("Compila il campo X")
			X.focus();
			return false;
		}
		if (Y.value=="")
		{
			alert("Compila il campo Y")
			Y.focus();
			return false;
		}
	}
}

function checkProcedura1()
{
	with(document.formProcedura1)
	{
		if (percentuale.value=="")
		{
			alert("Compila il campo Percentuale")
			percentuale.focus();
			return false;
		}
		if (limite.value=="")
		{
			alert("Compila il campo Limite")
			limite.focus();
			return false;
		}
	}
}