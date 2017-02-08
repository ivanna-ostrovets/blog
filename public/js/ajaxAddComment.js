function ajaxAddComment(form, postId, userId) {
  var xhr = new XMLHttpRequest();

  var formData = new FormData();

  formData.append("comment", form.comment.value);

  xhr.open("POST", "/controllers/addComment.php?post_id=" + postId + "&user_id=" + userId);
  xhr.send(formData);

  xhr.onreadystatechange = function() {
    if (this.readyState === 4) {
      if (this.status === 200) {
        window.location.replace("/views/showPost.php?id=" + postId);
      }
    }
  };

  return false;
}
