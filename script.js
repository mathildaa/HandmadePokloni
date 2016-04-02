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
        pomlabels[i].innerHTML = datelabels[i].innerHTML;
        if(ProtekloVrijeme(d) != -1) datelabels[i].innerHTML = ProtekloVrijeme(d);
	}
}

function timeSpan(datum) {
    var prosloSec = Math.floor((new Date() - datum) / 1000);
    if (prosloSec >= 2592000) { return -1; } //vise od mjesec
	
    var interval = Math.floor(prosloSec / 86400);
    if (interval <= 1) {return 3;}  //danas
	if (interval >= 2 && interval < 7) {return 2;}  //ove sedmice
	if (interval >= 7 && interval <= 31) {return 1;} //ovog mjeseca

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

