function deleteLike(postId, userId) {
  var xhr = new XMLHttpRequest();
  var url = "/controllers/deleteLike.php?post_id=" + postId + "&user_id=" + userId;

  xhr.open("DELETE", url, true);
  xhr.send();

  xhr.onreadystatechange = function() {
    if (this.readyState === 4) {
      if (this.status === 200) {
        var bla = "#likes_" + postId;
        var element = document.querySelector("#likes_" + postId);
        element.innerHTML = parseInt(element.innerHTML) - 1;
      }
    }
  };

  return false;
}
