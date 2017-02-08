function deleteImage(element) {
  var xhr = new XMLHttpRequest();
  var parameter = getUrLParameter("id");
  var url = "/controllers/deleteImage.php?id=" + parameter;

  xhr.open("DELETE", url, true);
  xhr.send();

  xhr.onreadystatechange = function() {
    if (this.readyState == 4) {
      if (this.status == 200) {
        element.className += " hidden";

        var newImageButton = document.querySelector("#new_image");
        newImageButton.className = newImageButton.className.replace(" hidden", "");

        var image_preview = document.querySelector("#image_preview");
        image_preview.parentNode.removeChild(image_preview);
      }
    }
  };

  return false;
}
