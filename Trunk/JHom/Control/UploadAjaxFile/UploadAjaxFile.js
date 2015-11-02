/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  Controle d'upload de fichier en ajax
 */
var UploadAjaxFile = function(){};

/**
 * Transfert le fichiers
 */
UploadAjaxFile.Upload = function(callBackFunction, idUpload)
{
    $("#spLoading"+idUpload).show();
    $("#spUploadAjaxControl"+idUpload).hide();
    
    $("#spUploadAjaxValide"+idUpload).hide();
    $("#spUploadAjaxError"+idUpload).hide();
    
    
    alert(idUpload);
    
      $.ajaxFileUpload
        (
            {
                url:'doajaxfileupload.php', 
                secureuri:false,
                fileElementId:idUpload,
                dataType: 'json',
                data : {name : $("#hdApp"+idUpload).val(), id : $("#hdIdElement"+idUpload).val(), action : $("#hdAction"+idUpload).val()},
                success: function (data, status)
                {
                    if(typeof(data.error) != 'undefined')
                    {
                        $("#spLoading"+idUpload).hide();
                        
                        if(data.error != '')
                        {
                            $("#spUploadAjaxError"+idUpload).show();
                            $("#spUploadAjaxError"+idUpload).html(data.error);
                            alert(data.error);
                            $("#spUploadAjaxControl"+idUpload).show();
                            $("#spUploadAjaxValide"+idUpload).show();
                            
                        }else
                        {
                            eval(callBackFunction);
                           
                            $("#spUploadAjaxControl"+idUpload).show();
                            $("#spUploadAjaxValide"+idUpload).show();
                        }
                    }
                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
        );
        
        return false;
    
};
