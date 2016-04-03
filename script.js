function ProtekloVrijeme(datum) {
    var prosloSec = Math.floor((new Date() - datum) / 1000);
	//ako je vise od mjesec ne treba nista mijenjati
    if (prosloSec >= 2592000) { return -1; }
	
    var interval = Math.floor(prosloSec / 86400);
    if (interval == 1) {return 'Novost objavljena prije 1 dan';} 
	if (interval%10 >= 2 && interval%10 < 7 && interval<7) {return 'Novost objavljena prije ' + interval + ' dana';} 
	if (interval >= 7 && interval < 14) {return 'Novost objavljena prije 1 sedmicu';} 
    if (interval >= 14 && interval < 21) {return 'Novost objavljena prije 2 sedmice';}
    if (interval >= 22 && interval <= 31) {return 'Novost objavljena prije 3 sedmice';}
    
	interval = Math.floor(prosloSec / 3600);
	if (interval >= 5 && interval <= 20) {return 'Novost objavljena prije ' + interval + ' sati';}
    if (interval%10 == 1 ) {return 'Novost objavljena prije ' + interval + " sat";} 
	if (interval%10 >= 2 && interval%10 <= 4) {return 'Novost objavljena prije ' + interval + " sata";} 
	
    interval = Math.floor(prosloSec / 60);
    if(interval >= 5 && interval <= 20) {return 'Novost objavljena prije ' + interval + ' minuta';}
	if (interval%10 == 1) {return 'Novost objavljena prije ' + interval + " minutu";}
    if (interval%10 >= 2 && interval%10 <= 4) {return 'Novost objavljena prije ' + interval + " minute";}
	if(interval>=25 && interval <=30) {return 'Novost objavljena prije ' + interval + ' minuta';}
	if(interval>=35 && interval <=40){return 'Novost objavljena prije ' + interval + ' minuta';}
	if(interval>=45 && interval <=50){return 'Novost objavljena prije ' + interval + ' minuta';}
	if(interval>=55 && interval <=60){return 'Novost objavljena prije ' + interval + ' minuta';}

	return 'Novost objavljena prije par sekundi'; 
}

window.onload = function () {
    var datelabels = document.getElementsByClassName("Datum");
    var pomlabels = document.getElementsByClassName("Proslo");
    for (var i = 0; i < datelabels.length; i++) {
        var d = new Date(datelabels[i].innerHTML);
		if (i==0) d = new Date(); //da bismo imali jedan testni za danasnje novosti
		if (i==1) d = new Date(new Date() - 400000); //i jos jedan xD
		if (i==2) d = new Date(new Date() - 2*86500000); //da imamo jedan testni novosti ove sedmice - hardcode ali je ok za sad
        pomlabels[i].innerHTML = datelabels[i].innerHTML;
        if(ProtekloVrijeme(d) != -1) datelabels[i].innerHTML = ProtekloVrijeme(d);
	}
	var datelabels1 = document.getElementsByClassName("Datum1"); //opet malo hardcode-a, za testiranje
	datelabels1[0].innerHTML = new Date();
	datelabels1[1].innerHTML = new Date(new Date() - 400000)
	datelabels1[2].innerHTML = new Date(new Date() - 2*86500000) 
}

function timeSpan(datum) {
	var danas = new Date();
	if(danas.getFullYear() != datum.getFullYear()) return -1;
	if(danas.getUTCMonth() != datum.getUTCMonth()) return -1;
	if(danas.getUTCMonth() == datum.getUTCMonth()) //isti mjesec
	{
		if((danas.getDay() >= datum.getDay() || danas.getDay() == 0) && (danas.getUTCDate() - datum.getUTCDate()) <= 7) //ovo je ista sedmica 
		{console.log(datum.getUTCDate());
			if(danas.getUTCDate() == datum.getUTCDate()) {console.log(datum.getUTCDate()); return 3;}
			return 2;
		}
		
		return 1;
	} 
	return -1;
}


function dropdownChanged() {
    var x = document.getElementById("dropdown").value; 
    var posts = document.getElementsByClassName("news");
    var datelabels = document.getElementsByClassName("Datum1");
   
	if ( x == "danasnje")
	{
		for (var i = 0; i < datelabels.length; i++) {
			var d = new Date(datelabels[i].innerHTML);
			if(timeSpan(d) != 3) posts[i].style.display = 'none';
			else posts[i].style.display = 'inline-block';
		}
	}
	
	if ( x == "sedmicne")
	{
		for (var i = 0; i < datelabels.length; i++) {
			var d = new Date(datelabels[i].innerHTML);
			if(timeSpan(d) != 2 && timeSpan(d) != 3) posts[i].style.display = 'none';
			else posts[i].style.display = 'inline-block';
		}
	}
	
	if ( x == "mjesecne")
	{
		for (var i = 0; i < datelabels.length; i++) {
			var d = new Date(datelabels[i].innerHTML);
			if(timeSpan(d) == -1) posts[i].style.display = 'none';
			else posts[i].style.display = 'inline-block';
		}
	}
	
	if( x == "sve")
	{
		for (var i = 0; i < datelabels.length; i++) {
			var d = new Date(datelabels[i].innerHTML);
			posts[i].style.display = 'inline-block';
		}
	}
}

