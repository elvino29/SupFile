$(document).ready(function () {

$('#createdir').click(function (event) {
   var homedir = document.getElementById('newdir');
   var donnee = homedir.dataset.folder
   var token = homedir.dataset.token
    var uri = window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
  var dirname =  $("#newdir").val();
   if(dirname.length === 0){
       event.preventDefault();
   }
    var lien = uri+"/webservice/folder"
    $.ajax({
        type : 'POST',
        url  : lien ,
        headers: {'Authorization': token},
        data : {name: dirname, parentId: donnee},
        success : function(data){
            var liens = uri+"/webservice/folder"
            $.ajax({
                type : 'GET',
                url  : liens ,
                headers: {'Authorization': token},
                success : function(data){
                    var dirHtml = '';
                    var fileHtml = '';
                    $.each(data.directories, function (key, value){

                       dirHtml += "     <li>\n" +
                           "                                                    <div class=\"file-control\">\n" +
                           "                                                        <input id=\""+value.id+"\" class=\"magic-checkbox\" type=\"checkbox\">\n" +
                           "                                                        <label for=\""+value.id+"\"></label>\n" +
                           "                                                    </div>\n" +
                           "                                                    <div class=\"file-settings dropdown\">\n" +
                           "                                                        <a href=\"#\" data-toggle=\"dropdown\" class=\"dropdown-toggle\">\n" +
                           "                                                            <i class=\"pci-ver-dots\"></i></a>\n" +
                           "                                                            <ul class=\"dropdown-menu extended logout\">\n" +
                           "                                                                <li><a href=\"#\"><i class=\"fa fa-edit\"></i> Modifier</a></li>\n" +
                           "                                                                <li><a href=\"#\"><i class=\"fa fa-download\"></i>Télécharger</a></li>\n" +
                           "                                                                <li><a href=\"#\"><i class=\"fa fa-trash\"></i> Supprimer</a></li>\n" +
                           "                                                            </ul>\n" +
                           "\n" +
                           "\n" +
                           "                                                    </div>\n" +
                           "                                                    <div class=\"file-attach-icon\"></div>\n" +
                           "                                                    <a href=\"#\" class=\"file-details\">\n" +
                           "                                                        <div class=\"media-block\">\n" +
                           "                                                            <div class=\"media-left\"><i class=\"demo-psi-folder\"></i></div>\n" +
                           "                                                            <div class=\"media-body\">\n" +
                           "                                                                <p class=\"file-name\">"+value.name+"</p>\n" +
                           "                                                                <small>Created Yesterday | 22 MB</small>\n" +
                           "                                                            </div>\n" +
                           "                                                        </div>\n" +
                           "                                                    </a>\n" +
                           "                                                </li>"  ;


                    });

                    $.each(data.files, function (key, value){
                       // if (value.type.toLowerCase() in )
                        fileHtml += " <li>\n" +
                            "                                                    <div class=\"file-control\">\n" +
                            "                                                        <input id=\""+valeur.id+"\" class=\"magic-checkbox\" type=\"checkbox\">\n" +
                            "                                                        <label for=\""+valeur.id+"\"></label>\n" +
                            "                                                    </div>\n" +
                            "                                                    <div class=\"file-settings\"><a href=\"#\"><i class=\"pci-ver-dots\"></i></a></div>\n" +
                            "                                                    <div class=\"file-attach-icon\"></div>\n" +
                            "                                                    <a href=\"#\" class=\"file-details\" data-id=\"{{ valeur.id }}\">\n" +
                            "                                                        <div class=\"media-block\">\n" +
                            "                                                            <div class=\"media-left\"><i class=\"demo-pli-file-"+

                            +"\"></i></div>\n" +
                            "                                                            <div class=\"media-body\">\n" +
                            "                                                                <p class=\"file-name\">"+valeur.name+"."+ valeur.type.toLowerCase()+"</p>\n" +
                            "                                                                <small>Created 3 weeks ago | 265 KB</small>\n" +
                            "                                                            </div>\n" +
                            "                                                        </div>\n" +
                            "                                                    </a>\n" +
                            "                                                </li>"  ;


                    });



                   $("#demo-mail-list").html(dirHtml + fileHtml);

                    $("#foldermodal").modal("hide");
                },
                error : function(data) {
                    alert("echec 2");
                }
            });

        },
        error : function(data) {
            alert("echec");
        }
    });
});

});