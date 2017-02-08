function addLike(postId, userId) {
  var xhr = new XMLHttpRequest();
  var url = "/controllers/addLike.php?post_id=" + postId + "&user_id" + userId;

  xhr.open("POST", url, true);
  xhr.send();

  xhr.onreadystatechange = function() {
    if (this.readyState === 4) {
      if (this.status === 200) {
        var element = document.querySelector("#likes_" + postId);
        element.innerHTML = parseInt(element.innerHTML) + 1;
      }
    }
  };

  return false;
}
