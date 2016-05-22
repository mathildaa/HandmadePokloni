function telefonValidacija(ulaz)
{
	var drzava = document.getElementById('zemlja').value.toLowerCase(); // Selektovana dzava
	
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "https://restcountries.eu/rest/v1/alpha?codes=" + drzava, true);
	
	ajax.onreadystatechange = function() {// Anonimna funkcija
		
		if (ajax.readyState == 4 && ajax.status == 404)
			document.getElementById("rezultat").innerHTML = "Greska: nepoznat URL";
		
		
		var json = JSON.parse(ajax.responseText);
		var pozivni = json[0].callingCodes;
		var uneseni = document.getElementById('telefon').value;
		
		
		if(uneseni.startsWith("+" + pozivni) == false)
		{
			ulaz.style.backgroundColor = "red";
			document.getElementById("telefonOK").value = "false";
		}
	/*	else if(uneseni.match(/^[0-9]+$/) == null)
		{
			ulaz.style.backgroundColor = "red";
		    document.getElementById("telefonOK").value = "true";
		}*/
		else 
		{
			ulaz.style.backgroundColor = "white";
			document.getElementById("telefonOK").value = "true";
		}
	}

	ajax.send();
	
}