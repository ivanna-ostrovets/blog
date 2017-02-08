var getUrLParameter = function(field, url) {
  var href = url ? url : window.location.href;
  var reg = new RegExp('[?&]' + field + '=([^&#]*)', 'i');
  var parameter = reg.exec(href);

  return parameter ? parameter[1] : null;
};