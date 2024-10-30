jQuery(document).ready(function() {
    var ppp = 3; // Post per page
    var cat = 8;
    var pageNumber = 1;

    jQuery("#more_posts").on("click",function(){ 
        var ppp     = jQuery("#more_posts").attr("postperpage");
        var paged  = parseInt(jQuery("#more_posts").attr("paged") ) + parseInt(1);
        var category= jQuery("#more_posts").attr("category");
        var str = 'category='+category+'&paged=' + paged + '&ppp=' + ppp + '&action=loadfaq';
        jQuery("#more_posts").attr("disabled",true); // Disable the button, temp.
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: faq_ajax_script.ajaxurl,
            data: str,
        success: function(data){
            if(data==0)
            {
                jQuery("#more_posts").hide()
                jQuery(".accordion").append('No More FAQ Available');
                return false;
            }
            jQuery("#more_posts").attr("enable",true);
            jQuery("#more_posts").attr("paged",paged);
            jQuery(".accordion").append(data);
        },
        error : function(jqXHR, textStatus, errorThrown) {
        }
    });
    return false;
    });
});