setInterval(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("notif").innerHTML = "+" + String(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET", "notifikacije.php", true);
    xmlhttp.send();
}, 1000);