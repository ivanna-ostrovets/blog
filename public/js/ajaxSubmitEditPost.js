function ajaxSubmitEditPost(form, id) {
  var xhr = new XMLHttpRequest();

  var formData = new FormData();

  formData.append("title", form.title.value);
  formData.append("category", form.category.value);
  formData.append("content", CKEDITOR.instances.content.getData());
  formData.append("teaser", form.teaser.value);
  formData.append("image", form.image.files[0]);

  xhr.open("POST", "/controllers/editPost.php?id=" + id);
  xhr.send(formData);

  xhr.onreadystatechange = function() {
    if (this.readyState === 4) {
      if (this.status === 200) {
        window.location.replace("/views/showPost.php?id=" + id);
      } else if (this.status === 400) {
        var errors = JSON.parse(this.response).errors;
        var errorsBox = document.querySelector("#errors");
        errorsBox.innerHTML = "";
        errorsBox.className = errorsBox.className.replace(" text-primary", "");

        errors.forEach(function(error) {
          errorsBox.innerHTML += "<p>" + error.message + "</p>";
        });
      }
    }
  };

  return false;
}