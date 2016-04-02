function ProtekloVrijeme(datum) {
    var prosloSec = Math.floor((new Date() - datum) / 1000);
	//ako je vise od mjesec ne treba nista mijenjati
    if (prosloSec >= 2592000) { return -1; }
	
    var interval = Math.floor(prosloSec / 86400);
    if (interval == 1) {return 'Novost objavljena prije 1 dan';} 
	if (interval%10 >= 2 && interval%10 < 7 && interval<7) {return 'Novost objavljena prije ' + interval + ' dana';} 
	if (interval >= 7 && interval < 14) {return 'Novost objavljena prije 1 sedmicu';} 
    if (interval >= 14 && interval < 21) {return 'Novost objavljena prije 2 sedmice';}
    if (interval >= 22 && interval < 28) {return 'Novost objavljena prije 3 sedmice';}
    if (interval > 0 && interval <= 31) {return 'Novost objavljena prije 4 sedmice';}
    
	interval = Math.floor(prosloSec / 3600);
	if (interval >= 5 && interval <= 20) {return 'Novost objavljena prije ' + interval + ' sati';}
    if (interval%10 == 1 ) {return 'Novost objavljena prije ' + interval + " sat";} 
	if (interval%10 >= 2 && interval%10 <= 4) {return 'Novost objavljena prije ' + interval + " sata";} 
	
    interval = Math.floor(prosloSec / 60);
    if(interval >= 5 && interval <= 20) {return 'Novost objavljena prije ' + interval + ' minuta';}
	if (interval%10 == 1) {return 'Novost objavljena prije ' + interval + " minutu";}
    if (interval%10 >= 2 && interval%10 <= 4) {return 'Novost objavljena prije ' + interval + " minute";}

	return 'Novost objavljena prije par sekundi'; 
}

window.onload = function () {
    var datelabels = document.getElementsByClassName("Datum");
    var pomlabels = document.getElementsByClassName("Proslo");
    for (var i = 0; i < datelabels.length; i++) {
        var d = new Date(datelabels[i].innerHTML);
        pomlabels[i].innerHTML = datelabels[i].innerHTML;
        if(ProtekloVrijeme(d) != -1) datelabels[i].innerHTML = ProtekloVrijeme(d);
	}
}
