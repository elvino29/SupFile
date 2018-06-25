$(document).ready(function () {
 var url = window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
 //var id = document.getElementById('mydropzone').dataset.home;
// var tokenup = document.getElementById('mydropzone').dataset.token;

 console.log(id);
 console.log(token);
 var myDropzone = new Dropzone("#mydropzone", {
     url: url + "/webservice/upload/"+id,
     withCredentials: false,
     headers: {"Authorization": tokenup}
 });



});