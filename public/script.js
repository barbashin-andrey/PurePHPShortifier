function shortify() {
    linkElem = document.getElementById("link");
    if (!linkElem.value){
        return;
    }
    const link = {
        "link": linkElem.value
    };
    linkElem.value = "";
    const xhr = new XMLHttpRequest();
    xhr.onload = () => {
        if (xhr.status == 200) {
            var res = JSON.parse(xhr.responseText);
            var shortifiedLink = `${window.location.protocol}//${window.location.host}/${res["short_path"]}`;
            document.getElementById("shortifiedLink").innerHTML = shortifiedLink;
        } else {
            console.log("Server response: ", xhr.statusText);
        }
    };
    xhr.open("POST", "/shortify.php");
    xhr.send(JSON.stringify(link));
}