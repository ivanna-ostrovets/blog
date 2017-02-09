function toggleLike(postId, userId) {
  var xhr = new XMLHttpRequest();
  var url = "/controllers/toggleLike.php?post_id=" + postId + "&user_id=" + userId;

  xhr.open("POST", url, true);
  xhr.send();

  xhr.onreadystatechange = function() {
    if (this.readyState === 4) {
      if (this.status === 200) {
        const response = JSON.parse(this.response);

        var element = document.querySelector("#likes_" + postId);
        element.innerHTML = response.likesCount;

        var button = element.parentElement;

        if (response.hasLike) {
          button.className = button.className + " btn-success";
        } else {
          button.className = button.className.replace(" btn-success", "");
        }
      }
    }
  };

  return false;
}
