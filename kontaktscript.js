function validate(f) {
    //form validation
    if (f.value == null || f.value == "") f.style.backgroundColor = "#F78B9E";
	else if (f.className != 'submit') f.style.backgroundColor = "white";
	
	if (f.id == "email")
        if (!validirajMail(f.value)) f.style.backgroundColor = "#F78B9E";
        else f.style.backgroundColor = "white";
	
	if (f.id == "url")
        if (!validirajUrl(f.value)) f.style.backgroundColor = "#F78B9E"; 
        else f.style.backgroundColor = "white";

	if (f.id == "tel")
        if (!validirajTel(f.value)) f.style.backgroundColor = "#F78B9E"; //nije baš crveno ali crvena mi previše odudara od stranice...
        else f.style.backgroundColor = "white";
 }
 

function validirajMail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validirajUrl(url) {
    var re = /https:+\/+\/+\S+/;
	var re2 = /http:+\/+\/+\S+/
    return re.test(url) || re2.test(url);
}

function validirajTel(tel) {
    var re = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.\/]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{3}$/;
    return re.test(tel);
}