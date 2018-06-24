$(document).ready(function () {
    $( function() {
    $( "#demo-mail-list" ).sortable({
        revert: true
    });
    $( "#sortable" ).draggable({
        connectToSortable: "#demo-mail-list",
        helper: "clone",
        revert: "invalid"
    });
    $( "ul, li" ).disableSelection();
    } );

$('#createdir').click(function (event) {
   var homedir = document.getElementById('newdir');
   var donnee = homedir.dataset.folder;
   var token = homedir.dataset.token;
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
            var liens = uri+"/webservice/folder";
            $.ajax({
                type : 'GET',
                url  : liens ,
                headers: {'Authorization': token},
                success : function(data){
                    var dirHtml = '';
                    var fileHtml = '';
                    $.each(data.directories, function (key, value){

                       dirHtml += " <li class=\"art-vmenu\">\n" +
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
                           "                                                    <a href=\"#\" class=\"file-details\" id=\"folderlink\" data-folder=\""+value.id+"\" data-token=\""+token+"\">\n" +
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
                       var imageTab1 = ['png','jpg','gif','bmp','jpeg'];
                       var imageTab2 = ['pdf','doc','docx','odt'];
                       var type;
                       if (imageTab1.indexOf(value.type.toLowerCase()) !== -1){
                           type = 'jpg';
                       }
                       else{
                           if (imageTab2.indexOf(value.type.toLowerCase()) !== -1) {
                               type = 'word';
                           }
                           else {
                               type = value.type.toLowerCase();
                           }
                       }

                        fileHtml += " <li id=\"sortable\">\n" +
                            "                                                    <div class=\"file-control\">\n" +
                            "                                                        <input id=\""+value.id+"\" class=\"magic-checkbox\" type=\"checkbox\">\n" +
                            "                                                        <label for=\""+value.id+"\"></label>\n" +
                            "                                                    </div>\n" +
                            "                                                    <div class=\"file-settings\"><a href=\"#\"><i class=\"pci-ver-dots\"></i></a></div>\n" +
                            "                                                    <div class=\"file-attach-icon\"></div>\n" +
                            "                                                    <a href=\"#\" class=\"file-details\" data-id=\""+value.id+"\">\n" +
                            "                                                        <div class=\"media-block\">\n" +
                            "                                                            <div class=\"media-left\"><i class=\"demo-pli-file-"+type+"\"></i></div>\n" +
                            "                                                            <div class=\"media-body\">\n" +
                            "                                                                <p class=\"file-name\">"+value.name+"."+ value.type.toLowerCase()+"</p>\n" +
                            "                                                                <small>Created 3 weeks ago | 265 KB</small>\n" +
                            "                                                            </div>\n" +
                            "                                                        </div>\n" +
                            "                                                    </a>\n" +
                            "                                                </li>"  ;


                    });



                   $("#demo-mail-list").html(dirHtml + fileHtml);
                   $("li.art-vmenu").on('dblclick', onDoubleClick);

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

var onDoubleClick = function (event) {
    var dir = $(this).find('a#folderlink');
    var donnee = dir.data('folder');
    var token = dir.data('token');

    var uri = window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');

    var lien = uri+"/webservice/folder/"+donnee

    $.ajax({
        type : 'GET',
        url  : lien ,
        headers: {'Authorization': token},
        success : function(data){
            var dirHtml = '';
            var fileHtml = '';
            $.each(data.directories, function (key, value){

                dirHtml += " <li class=\"art-vmenu\">\n" +
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
                    "                                                    <a href=\"#\" class=\"file-details\" id=\"folderlink\" data-folder=\""+value.id+"\" data-token=\""+token+"\">\n" +
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
                var imageTab1 = ['png','jpg','gif','bmp','jpeg'];
                var imageTab2 = ['pdf','doc','docx','odt','pl'];
                var type;
                if (imageTab1.indexOf(value.type.toLowerCase()) !== -1){
                    type = 'jpg';
                }
                else{
                    if (imageTab2.indexOf(value.type.toLowerCase()) !== -1) {
                        type = 'word';
                    }
                    else {
                        type = value.type.toLowerCase();
                    }
                }

                fileHtml += " <li id=\"sortable\">\n" +
                    "                                                    <div class=\"file-control\">\n" +
                    "                                                        <input id=\""+value.id+"\" class=\"magic-checkbox\" type=\"checkbox\">\n" +
                    "                                                        <label for=\""+value.id+"\"></label>\n" +
                    "                                                    </div>\n" +
                    "                                                    <div class=\"file-settings\"><a href=\"#\"><i class=\"pci-ver-dots\"></i></a></div>\n" +
                    "                                                    <div class=\"file-attach-icon\"></div>\n" +
                    "                                                    <a href=\"#\" class=\"file-details\" data-id=\""+value.id+"\">\n" +
                    "                                                        <div class=\"media-block\">\n" +
                    "                                                            <div class=\"media-left\"><i class=\"demo-pli-file-"+type+"\"></i></div>\n" +
                    "                                                            <div class=\"media-body\">\n" +
                    "                                                                <p class=\"file-name\">"+value.name+"."+ value.type.toLowerCase()+"</p>\n" +
                    "                                                                <small>Created 3 weeks ago | 265 KB</small>\n" +
                    "                                                            </div>\n" +
                    "                                                        </div>\n" +
                    "                                                    </a>\n" +
                    "                                                </li>"  ;


            });



            $("#demo-mail-list").html(dirHtml + fileHtml);
            $("ul#demo-mail-list li.art-vmenu").on('dblclick', onDoubleClick);

        },
        error : function(data) {
            alert("echec");
        }
    });
};

$("ul#demo-mail-list li.art-vmenu").dblclick(onDoubleClick);

   /* $(document).ajaxStart(function(){
        setTimeout(function () {
            $("#load").show();
        },2000);
    });
    $(document).ajaxComplete(function(){
        $("#load").hide();
    });*/

});


