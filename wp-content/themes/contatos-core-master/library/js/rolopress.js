/**
 * RoloPress JavaScript functions.
 * @requires jQuery
 */

// Media upload front-end
jQuery(document).ready(function($){

    if( typeof wp != 'undefined' ) {
        var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;      

          var oldPost = wp.media.view.MediaFrame.Post;
            wp.media.view.MediaFrame.Post = oldPost.extend({
                initialize: function() {
                    oldPost.prototype.initialize.apply( this, arguments );
                    this.states.get('insert').get('library').props.set('uploadedTo', wp.media.view.settings.post.id);
                }
            });
    }
        

  

    var called = 0;
    $('.media-modal').ajaxStop(function() {
        if ( 0 == called ) {
            $('[value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
            called = 1;
        }
    });

  jQuery('.item-image.enabled').on('click', function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = jQuery(this);
    var id = button.attr('id').replace('_button', '');
    _custom_media = true;
    wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {

        jQuery.post( 
            ajax_url.ajaxurl, { 
                action : 'rolo_ajax_edit_thumbnail',
                postid : ajax_url.postid,
                att   : attachment.id
            }, function( resp ) {
                
                    jQuery("#item-avatar").html(resp);

                });

        // jQuery("#"+id).children('img').attr('src', attachment.url);

      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }

    wp.media.editor.open(button);
    return false;
  });
/*
  jQuery('.wp-core-ui .button').on('click', function(){
    console.log('oi');
    console.log(jQuery('.media-selection .selection-view li').eq(0).children('img').attr('src'));
    // _custom_media = false;
  });
*/
});

// Auto set on page load...
jQuery(document).ready(function() {

    // Acesso
    re = window.location.search;
    if (re.toLowerCase().indexOf("erro_acesso") >= 0) {
        alert('O sistema rejeitou seu acesso à seção '+jQuery.QueryString["sec"]+'. Se você acredita que isto é um erro, por favor entre em contato com o administrador do site.');
    }

    // Uniform
    jQuery('form.uniForm').uniform({
        prevent_submit : true,
        valid_class : 'valid',
        validation_class : 'validateEmail'
    });

    // Hide all hidden elements
    jQuery('.ctrlHidden').hide();

    // Bind a custom event
    jQuery('.ctrlHolder')
    .live('show', function () {
       var $this = jQuery(this) ;
       var slug = jQuery.trim($this.attr('class').replace('ctrlHolder', '').replace('ctrlHidden', '').replace('multipleInput', ''));

       jQuery ('div.' + slug + ':visible').each(function () {
           $this.find('option[value="' + jQuery(this).find('select').val() + '"]').remove();
       });

       if (jQuery('div.' + slug + ':hidden').length == 1) {
           $this.find('img.rolo_add_ctrl').hide();
       }
    })
    .live('hide', function () {
       var $this = jQuery(this) ;
       var slug = jQuery.trim($this.attr('class').replace('ctrlHolder', '').replace('ctrlHidden', '').replace('multipleInput', ''));

       if (jQuery ('div.' + slug + ':visible').length > 0) {
           jQuery ('div.' + slug + ':visible:last').find('img.rolo_add_ctrl').show();
       }
    });

    // when the add button is clicked
    jQuery('img.rolo_add_ctrl').live('click', function () {
       var $this = jQuery(this) ;
       var slug = jQuery.trim($this.parent('div.ctrlHolder').attr('class').replace('ctrlHolder', '').replace('ctrlHidden', '').replace('multipleInput', ''));
       
       $this.hide().parents('form.uniForm').find('div.' + slug + ':hidden:first').trigger('show').show();
    });

    // when the delete button is clicked
    jQuery('img.rolo_delete_ctrl').live('click', function () {
       var $this = jQuery(this) ;
       $this.parent('.ctrlHolder').children('.textInput').val('');
       $this.parent('.ctrlHolder').hide().trigger('hide');
    });

    //on focus tricks
    jQuery('div.ctrlHolder input[name="rolo_city"], div.ctrlHolder input[name="rolo_city"]').focus(function () {
        var $this = jQuery(this);
        if ($this.val() == 'City') {
            $this.val('');
        }
    });

    jQuery('div.ctrlHolder input[name="rolo_contact_state"], div.ctrlHolder input[name="rolo_company_state"]').focus(function () {
        var $this = jQuery(this);
        if ($this.val() == 'State') {
            $this.val('');
        }
    });

    jQuery('div.ctrlHolder input[name="rolo_contact_zip"], div.ctrlHolder input[name="rolo_company_zip"]').focus(function () {
        var $this = jQuery(this);
        if ($this.val() == 'Zip') {
            $this.val('');
        }
    });

    jQuery('div.ctrlHolder input[name="rolo_contact_country"], div.ctrlHolder input[name="rolo_company_country"]').focus(function () {
        var $this = jQuery(this);
        if ($this.val() == 'Country') {
            $this.val('');
        }
    });

    // Auto Complete taxonomy fields
    jQuery('input.company').suggest(wpurl + "/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=company", {multiple:false});
	jQuery('input.city').suggest(wpurl + "/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=city", {multiple:false});
	jQuery('input.state').suggest(wpurl + "/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=state", {multiple:false});
	jQuery('input.zip').suggest(wpurl + "/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=zip", {multiple:false});
	jQuery('input.country').suggest(wpurl + "/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=country", {multiple:false});
	jQuery('input.post_tag').suggest(wpurl + "/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=post_tag", {multiple:false});


    jQuery('input.rolo_conflito.check').on('change', function() {

        if (jQuery(".rolo_conflito.check:checked").length == 1) {
            jQuery('.input_conflito').removeClass('out');
        } else {
            jQuery('.input_conflito').not('.button').addClass('out');
        }

    });

    jQuery('input.rolo_relacao_check').on('change', function() {
        console.log( 'wwww');

        if( jQuery( this ).is( ':checked' ) ) {
            jQuery('.input_relacao').removeClass('out');
            jQuery( '.rolo_relacao.resposta.vazio' ).hide( 800 );
        } else {
            jQuery('.input_relacao').not('.button').addClass('out');
            jQuery( '.rolo_relacao.resposta.vazio' ).show( 800 );
        }

    });

    jQuery('.input_conflito.button, .input_relacao.button').on('click', function() {

        var cl;

        if(jQuery(this).hasClass('input_conflito')) {
            cl = '.input_conflito';
        } else {
            cl = '.input_relacao';
        }

        var list = [];
        var tags;
        var act;
        if(jQuery(this).hasClass('input_conflito')) {
            check = jQuery('.rolo_conflito.check').is(':checked');
            act = 'conflito';
            tags = jQuery('.input_conflito').not('.button');
        } else {
            check = jQuery('.rolo_relacao.check').is(':checked');
            act = 'relacao';
            tags = jQuery('.input_relacao').not('.button');
        }

        jQuery.each(tags, function() {
            
            if(jQuery(this).is('input:checked')) {
                list.push('checked');
            } else {
                list.push(jQuery(this).val());
            }
            
        });

        if(check == 1) {
            list.unshift(true);    
        } else {
            list.unshift(false);
        }
        
        jQuery.post( 
            ajax_url.ajaxurl, { 
                action : 'rolo_ajax_edit_company_other',
                act    : act,
                postid : ajax_url.postid,
                data   : list
            }, function( resp ) {
                
                    if(resp.status == 'sucesso') {
                        window.location.reload();
                    }

                });

    });
/*
    jQuery('.input_relacao.button').on('click', function() {

        var list = [];
        jQuery.each(jQuery('.input_relacao').not('.button'), function() {
            
            if(jQuery(this).is('input:checked')) {
                list.push('checked');
            } else {
                list.push(jQuery(this).val());
            }

        });

        jQuery.post( 
            ajax_url.ajaxurl, { 
                action : 'rolo_ajax_edit_company_relacao',
                data   : list
            }, function( resp ) {

                    if(resp.status == 'sucesso') {
                    }

                });

    });
*/

    var taxes = jQuery('.taxonomias li');

    jQuery.each(taxes, function(e,v) {

        if(jQuery(this).children('ul.children').length > 0) {
            jQuery(this).addClass('parent');
            jQuery(this).prepend('<span></span>');
        }

    });

    jQuery('.taxonomias .parent span').on('click', function() {

        if(jQuery(this).hasClass('open')) {
            jQuery(this).removeClass('open');
            jQuery(this).parent().children('.children').hide();
        } else {
            jQuery(this).addClass('open');
            jQuery(this).parent().children('.children').show();
        }

    });

    jQuery('.hentry .selectit input').on('change', function() {

        jQuery(this).parent().addClass('jeip-saving');

        var area = jQuery(this).parents('div').attr('class');
        var val = jQuery(this).val();
        var checked = jQuery(this).parent().find(':checked').length;
        var ajax_data = { area: area, val: val, postid: ajax_url.postid }

        jQuery.post( 
                ajax_url.ajaxurl, { 
                    action : 'rolo_ajax_edit_taxonomy',
                    data   : ajax_data,
                    check: checked
                }, function( resp ) {
                        var data = ajax_data;
                        if(resp.check.toString() == 'true') {
                            for(i=0;i<resp.parents.length;i++) {
                                jQuery('#'+data.area+'-'+resp.parents[i]).children('.selectit').children('input').click();
                            }

                        }

                        // jQuery('#'+area+'-'+data.val).parents('.parent').find('').click();
                        jQuery('#'+area+'-'+data.val).find('label').removeClass('jeip-saving');

                    });
    });

    // Autocomplete instituicoes
    var autocomp_inst = {
         source: function(request, response) {
             jQuery.post( 
                ajax_url.ajaxurl, { 
                    action : 'rolo_ajax_autocomplete',
                    type: 'instituicoes',
                    data   : request.term
                }, function( resp ) {

                    response(jQuery.map(resp, function(item) {

                        var split = item.post_title.slice(0,request.term.length);

                        if (split.toLowerCase() == request.term.toLowerCase()) {
                            return {
                                label: item.post_title,
                                value: item.ID
                            }    
                        }
                        
                    }), 'json');
                })        
        },
        minLength: 2,
        delay: 500,
        focus: function(event, ui) {
            jQuery('.ui-autocomplete-input').val(ui.item.label);
            return false;
        },
        select: function(event, ui) {
                var tr = jQuery(event.target).parents('tr');
                jQuery(tr).children().eq(0).children('button').html('OK').attr('name',ui.item.value);
                
            return false;
            }
    };

    // Autocomplete nomes
    var autocomp_nomes = {
         source: function(request, response) {
             jQuery.post( 
                ajax_url.ajaxurl, { 
                    action : 'rolo_ajax_autocomplete',
                    type: 'nomes',
                    data   : request.term
                }, function( resp ) {

                    response(jQuery.map(resp, function(item) {

                        var split = item.post_title.slice(0,request.term.length);

                        if (split.toLowerCase() == request.term.toLowerCase()) {
                            return {
                                label: item.post_title,
                                value: item.ID
                            }    
                        }
                        
                    }), 'json');
                })        
        },
        minLength: 2,
        delay: 500,
        search: function(event, ui) {
            jQuery('.ui-helper-hidden-accessible').css('display: none');
        },
        focus: function(event, ui) {
            jQuery('.ui-autocomplete-input').val(ui.item.label);
            return false;
        },
        response: function( event, ui ) {
            
            if(ui.content.length == 0) {
                var tr = jQuery(event.target).parents('tr');
                jQuery(tr).children().eq(1).find('span').css('display: block');
            }

        },
        select: function(event, ui) {
                var tr = jQuery(event.target).parents('tr');
                jQuery(tr).children().eq(0).children('button').html('OK').attr('name',ui.item.value).removeClass('remove-contact-in-company').addClass('save-contact-in-company');
                
            return false;
            }
    };


    jQuery('input').on('keypress', function() {
        // console.log('key');
        // var newrow = jQuery('<tr><td><button>-</button></td><td class="insertname" colspan="4"><input type="text" /></td></tr>');
        // jQuery('input', newrow).autocomplete(autocomp_inst);
        // jQuery(this).parents('span').append(newrow);

    });

    jQuery('.contatos-btn').on('click', 'button', function() {

        if(jQuery(this).html() == "+") {

            var newrow = jQuery('<tr><td><button class="remove-contact-in-company">-</button></td><td class="insertname" colspan="4"><input type="text" /></td></tr>');
            jQuery('input', newrow).autocomplete(autocomp_nomes);
            jQuery(this).parents('tr').before(newrow);


        } else if(jQuery(this).html() == "-") {

            var name = jQuery(this).parent().next('td').find('a').html();

            if(confirm('Remover usuário '+name+'?')) {
                jQuery(this).parents('tr').detach();

                jQuery.post( 
                    ajax_url.ajaxurl, { 
                        action : 'rolo_ajax_edit_contacts',
                        mode   : 'remove',
                        data   : jQuery(this).attr('name'),
                        company: ajax_url.postid
                    }, function( resp ) {

                        if (resp.status == 'ok') {
                            // window.location.reload();
                        };
                    })    
            }
            
        } else if(jQuery(this).html() == "OK") {
            
            jQuery.post( 
                ajax_url.ajaxurl, { 
                    action : 'rolo_ajax_edit_contacts',
                    mode   : 'add',
                    data   : jQuery(this).attr('name'),
                    company: ajax_url.postid
                }, function( resp ) {

                    if (resp.status == 'ok') {
                        window.location.reload();
                    };
                })    
        }
    });

    // jQuery(".contatos input").autocomplete(ajax_url.ajaxurl);
    jQuery('#rolo_contact_company').on('click', function() {
        es = jQuery(this);
        window.setTimeout(function() {
            este = jQuery('#edit-rolo_contact_company');
            este.autocomplete(autocomp_inst);
        }, 500);

    });
        

    // Validation for mandatory fields
    jQuery('#add_contact, #edit_contact, #add_company, #edit_company').click(function (e) {
        jQuery('div.mandatory input').each(function () {
            if (jQuery(this).val() === '') {
                jQuery('#errorMsg').show();
                jQuery(this).addClass('errorInput');
                e.preventDefault();
            } else {
                jQuery(this).removeClass('errorInput');
            }
        });
    });

    var m, este;

    jQuery('.telefone').on('click', function() {
        es = jQuery(this);
        window.setTimeout(function() {
            este = es.find('input').eq(0);
            m = este.mask("(99) 9999-9999?9");
        }, 500);

    });

    jQuery('.data-alt').on('click', function() {
        es = jQuery(this);
        window.setTimeout(function() {
            este = es.find('input').eq(0);
            m = este.mask("99/99/9999");
        }, 500);

    }); 

    jQuery('.ano-alt').on('click', function() {
        es = jQuery(this);
        window.setTimeout(function() {
            este = es.find('input').eq(0);
            m = este.mask("9999");
        }, 500);

    });        

    // Formulário de busca avançada
    jQuery('select.publicos').on('change', function() {
        
        cls = jQuery(this).val();

        jQuery('fieldset').not('.geral').hide();
        jQuery('fieldset.'+cls).show();

    });
  

    // Máscara de telefone para campos
    // jQuery('.telefone input').mask("(99) 9999-9999?9");
    /*
    .ready(function(event) {
        var target, phone, element;
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;
        phone = target.value.replace(/\D/g, '');
        element = $(target);
        element.unmask();
        if(phone.length > 10) {
            element.mask("(99) 99999-999?9");
        } else {
            element.mask("(99) 9999-9999?9");
        }
    });*/
	
	jQuery(document).ready(function(){
		jQuery('#rolo_company_website a').attr('target', '_blank');
	});
	
	jQuery(document).ready(function(){
		jQuery('.ajuda-in').tooltipster( {
			animation: 'fade',
			position: 'top-right',
		});
	});


	jQuery(document).ready(function(){
		jQuery('.menu-in').tooltipster( {
			animation: 'fade',
			position: 'bottom',
		});
	});

    // Group delete posts
    jQuery('#group-del').on('click', function() {

        var checks = jQuery('li input:checked');
        var group = [];
        var names = [];

        jQuery.each(checks, function(e,i) {

            group.push(jQuery(this).val());
            names.push(jQuery(this).attr('rel'));

        });


        if( confirm('Tem certeza que deseja excluir \n'+names.join(', ')+'?') ) {

            jQuery.post( 
                ajax_url.ajaxurl, { 
                    action : 'rolo_ajax_delete',
                    data   : group.join(','),
                }, function( resp ) {

                    if (resp.status == 'ok') {
                        alert('Registros excluidos com sucesso');

                        for(i=0;i<resp.affected.length;i++) {
                            jQuery('#entry-'+resp.affected[i]).parent('li').detach();
                        }

                    };
                })  

        }

    });

    jQuery('#group-toggle').on('click', function() {

        if(jQuery(this).val() === 'Selecionar Todos') {
            jQuery('input[type="checkbox"]').not(':checked').click();
            jQuery(this).val('Desmarcar Todos');
        } else {
            jQuery('input[type="checkbox"]:checked').click();
            jQuery(this).val('Selecionar Todos');
        }
        
        

    });
	
});

function verificar(form){
	with (form) {
		if ( outro.value ==""){
		alert("Preencha o campo para poder salvá-lo.");
		outro.focus();
		return false;
		}
	}
}

// Plugin URL Query Search
// http://stackoverflow.com/a/3855394/1001109
(function($) {
    $.QueryString = (function(a) {
        if (a == "") return {};
        var b = {};
        for (var i = 0; i < a.length; ++i)
        {
            var p=a[i].split('=');
            if (p.length != 2) continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    })(window.location.search.substr(1).split('&'))
})(jQuery);