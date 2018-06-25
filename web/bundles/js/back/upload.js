$(document).ready(function () {
 var url = window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
 var myDropzone = new Dropzone("#mydropzone", {
     url: url + "/webservice/upload/20",
     withCredentials: false,
     headers: {"Authorization": "eyJhbGciOiJSUzI1NiJ9.eyJ1c2VybmFtZSI6ImVsdmlubzI5IiwiZXhwIjoiMTUyODEyNjkyNyIsImlhdCI6MTUyODEyMzMyN30.w4oWd8jTDW1n7cc4GVU4Zki0FOFT7HlVBVF010bgc0vfPspOAlRU5KiTAd2HCfzRAJaDsOYrjUYM6VB1jaidKUABjNLwdJA9PXe2ulkNJxbIH43ChmbT-MixMRpGWO-AHwf3z6L8V8l2ZPx8dZIJFXE40sJpTS8th3NqBhMeB1oRj8Td7TR8K-OyCBfR3-IqQUtrGyFVEPEorQs7iSrrh8RFkF9RGWWcfKOb7JgTOvj7WUkIQaxVOLYE9OgX6YIW1xpd7ikYrAr8Fm-2XJk-fyKJuOGclE85ehdEeLy2V5DAcKXzU2pWxPev14CTTULdEgjFPTxYJuSRdf8OZwEvNg"}
 });



});