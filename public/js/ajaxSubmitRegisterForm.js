function ajaxSubmitRegisterForm(form) {
  var xhr = new XMLHttpRequest();

  var formData = new FormData();

  formData.append("name", form.name.value);
  formData.append("email", form.email.value);
  formData.append("password", form.password.value);
  formData.append("confirm_password", form.confirm_password.value);

  xhr.open("POST", "/controllers/registration.php");
  xhr.send(formData);

  var offset = getUrLParameter("offset");
  var category = getUrLParameter("category");
  var urlPart = "";

  if (offset && category) {
    urlPart += "?offset=" + offset + "&category=" + category;
  } else if (offset) {
    urlPart += "?offset=" + offset;
  }
  else if (category) {
    urlPart += "?category=" + category;
  }

  xhr.onreadystatechange = function() {
    if (this.readyState === 4) {
      if (this.status === 200) {
        window.location.replace("/index.php" + urlPart);
      } else if (this.status === 400) {
        var errors = JSON.parse(this.response).errors;
        var errorsBox = document.querySelector("#errors");
        errorsBox.innerHTML = "";
        errorsBox.className = errorsBox.className.replace(" hidden", "");

        errors.forEach(function(error) {
          errorsBox.innerHTML += "<p>" + error.message + "</p>";
        });
      }
    }
  };

  return false;
}