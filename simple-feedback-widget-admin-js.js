
jQuery(document).ready(function () {
   "use strict";
      jQuery('#rekommend_settings_form1').submit(function() { 
      jQuery(this).ajaxSubmit({
         success: function(){
            var questiontext1 = jQuery("#rekommend_wp_question1").val();
            var id1 = jQuery("#rekommend_wp_id1").val();
            jQuery('#saveResult').html("<div id='saveMessage' class='rekommend_successModal'></div>");
            jQuery('#saveMessage').append("<p>Question updated successfully</p>").show();
            jQuery.get('https://www.rekommend.io/widget/change-question', { questiontext:questiontext1, id:id1 });
         }, 
         timeout: 5000
      }); 
      setTimeout("jQuery('#saveMessage').hide('slow');", 4000);
      return false; 
   });

});
