function logOut(urlPart) {
  var xhr = new XMLHttpRequest();

  xhr.open("POST", "/controllers/logOut.php", true);
  xhr.send();

  xhr.onreadystatechange = function() {
    if (this.readyState === 4) {
      if (this.status === 200) {
        window.location.replace("/index.php" + urlPart);
      }
    }
  };

  return false;
}