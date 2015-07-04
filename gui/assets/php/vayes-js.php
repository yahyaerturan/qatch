<?php header('Content-Type: text/javascript; charset=UTF-8'); ?>


/*!
 * Global Definitions
 */
var BaseURL='<?=base_url();?>';
var <?=$csrf_name;?> ='<?=$csrf_hash?>';

// ------------------------------------------------------------------------

/*!
 * Global Ajax Setup
 */
$(function($){
  $.ajaxSetup({
    contentType:'application/x-www-form-urlencoded;
    charset=UTF-8',
    method:'POST',
    data:{<?= $csrf_name;?>:'<?=$csrf_hash;?>'},
    statusCode:{
      403:function(){
        Interact.show('<?=lang("i18n_global_ajax_setup_403_message");?>');
        setTimeout(function(){
          if(window.parent){window.parent.location.href = '<?=base_url();?>'}
          else{window.location.href = '<?=base_url();?>'}
        },2000);
        return false;
      },
      404:function(){
        Interact.show('<?=lang("i18n_global_ajax_setup_404_message");?>');
        return false;
      },
      500:function(xhr){
        Interact.show('<i class="fa fa-shield v_mrm"></i> <?=lang("i18n_global_ajax_setup_500_message");?>');
        setTimeout(function(){window.location.replace(BaseURL);},6E5);
      }
    }
  });
});

// ------------------------------------------------------------------------

/*!
 * redirect()
 *
 * Redirects to given URL
 */
function redirect(url){return window.location.replace(url);}
