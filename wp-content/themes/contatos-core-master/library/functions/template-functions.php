<?php
/**
 * Template Functions
 *
 * Contains template functions used in theme
 *
 * @package RoloPress
 * @subpackage Functions
 */

/**
 * Displays a summarized version of contact information
 *
 * @param int $contact_id
 * @return <type>
 *
 * @since 0.1
 */
/*
function rolo_contact_header($contact_id) {
    if (!$contact_id) {
        return false;
    }

    $contact = get_post_meta($contact_id, 'rolo_contact');
    $contact = $contact[0];
?>
        <div class="bloco">
    <ul id="hcard-<?php echo basename(get_permalink());?>" class="item-header">
                        
                        <?php
                        $gravatar_default = ROLOPRESS_IMAGES . "/icons/gravatar-default.jpg";
                        echo get_avatar( ($contact['rolo_contact_email']), 96, $gravatar_default ); ?>
                        <li><a class="fn" href="<?php the_permalink();?>"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></a></li>
                        <li>
                        <?php 
                        if ($contact['rolo_contact_title'] != "") { ?>
                                <span class="title" id="rolo_contact_title"><?php echo $contact['rolo_contact_title'];?></span><?php }
                        if (get_the_term_list($contact_id, 'company') != "") { ?>
                                <span class="org"><?php echo get_the_term_list($contact_id, 'company', ''); ?></span><?php }
                        ?>
            </li>
                        <?php if ($contact['rolo_contact_email'] != "") { ?><li class="email url-field"><a class="email" href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?> </a><span id="rolo_contact_email" class="edit-icon" style=""><?php echo $contact['rolo_contact_email']; ?></span></li><?php } ?>

                        <?php rolopress_after_contact_header();?> 
    </ul><!-- hcard -->
</div><!-- .bloco -->
<?php
}
*/
function rolo_contact_header($contact_id) {

        if (!$contact_id) {
                return false;
        }

    // $contact = get_post_meta($contact_id, 'rolo_contact', true);
        $contact = get_post_custom($contact_id);

        $contact_name = $contact['rolo_contact_first_name'][0].' '.$contact['rolo_contact_last_name'][0];
        $contact_city = $contact['rolo_city'][0];

	$contact_local = $contact['rolo_contact_local'][0];
	$contact_local_city = $contact['rolo_contact_local_city'][0];
	$contact_role = $contact['rolo_contact_role'][0];
	
	$contact_company = $contact['rolo_contatos'][0];
	if($contact_company) {
		$p = get_post($contact_company);
		$contact_company = $p->post_title;
	}

	$contact_party = $contact['rolo_contact_party'][0];

        $contact_email = $contact['rolo_contact_email'][0];
        $contact_website = $contact['rolo_contact_website'][0];

        $contact_others = $contact['rolo_contact_others'][0];
        $contact_address = $contact['rolo_contact_address'][0];
        $contact_phone = $contact['rolo_contact_phone'][0];

        $contact_uf = $contact['rolo_uf'][0];

        $contact_redes_fb = $contact['rolo_contact_redes_fb'][0];
        $contact_redes_tw = $contact['rolo_contact_redes_tw'][0];
        $contact_redes_in = $contact['rolo_contact_redes_in'][0];
        $contact_redes_out = $contact['rolo_contact_redes_out'][0];

        if(is_single()) {
            if(!$contact_redes_fb)
                $contact_redes_fb = 'Link para Facebook';
            if(!$contact_redes_tw)
                $contact_redes_tw = 'Link para Twitter';
            if(!$contact_redes_in)
                $contact_redes_in = 'Link para LinkedIn';
            if(!$contact_redes_out)
                $contact_redes_out = 'Link para Outra Rede';    
        }
        
        if(!is_single()) {
            $redes  = ($contact_redes_fb ? '<span id="rolo_contact_redes_fb" class="resposta resposta-redes">'.$contact_redes_fb.'</span>' : '');
            $redes .= ($contact_redes_tw ? '<span id="rolo_contact_redes_tw" class="resposta resposta-redes">'.$contact_redes_tw.'</span>' : '');
            $redes .= ($contact_redes_in ? '<span id="rolo_contact_redes_in" class="resposta resposta-redes">'.$contact_redes_in.'</span>' : '');
            $redes .= ($contact_redes_out ? '<span id="rolo_contact_redes_out" class="resposta resposta-redes">'.$contact_redes_out.'</span>' : '');
            
            if(!$redes)
                $redes = '<span id="rolo_contact_redes" class="resposta vazio"></span>';
        } else {
            $redes  = '<span id="rolo_contact_redes_fb" class="resposta resposta-redes">'.$contact_redes_fb.'</span>';
            $redes .= '<span id="rolo_contact_redes_tw" class="resposta resposta-redes">'.$contact_redes_tw.'</span>';
            $redes .= '<span id="rolo_contact_redes_in" class="resposta resposta-redes">'.$contact_redes_in.'</span>';
            $redes .= '<span id="rolo_contact_redes_out" class="resposta resposta-redes">'.$contact_redes_out.'</span>';
        }

        

        $contact_tel = $contact['rolo_contact_telefone'][0];
        $contact_tel_alt = $contact['rolo_contact_telefone_alt'][0];

        if($contact_tel == "(_) _____-____")
            $contact_tel = '';
        if($contact_tel_alt == "(_) _____-____")
            $contact_tel_alt = '';

        $contact_end = $contact['rolo_contact_endereco'][0];

        $contact_contato = $contact['rolo_contact_contato_facil'][0];

        $contact_update = $contact['rolo_contact_update'][0];
                if(!$contact_update) {
                        $contact_update = get_the_time( 'd/m/Y', $contact_id );                
                }
        $contact_update_src = $contact['rolo_contact_update_src'][0];

        $post_id = get_post($post->ID); // get current contact id
    $slug = $post_id->post_name; // define slug as $slug

   if(current_user_can( 'edit_posts' )) {
		$enable = 'enabled';
   }

    ?>
	
<!-- Bloco Contatos -->

    <div class="bloco card-<?php echo basename( get_permalink() );?>">
    <h2 class="title_single">
    <?php echo (is_search() ? '<div class="div-deleta"><input class="deleta" type="checkbox" name="multiple[]" rel="'.get_the_title().'" value="'.get_the_ID().'" /></div>' : ''); ?>
        <span class="title_single_contact"></span>
        <?php if ( is_single() ) : ?>
			<span class="blue"><?php echo $contact_name;?></span>
        <?php else : ?>
			<a class="blue" href="<?php the_permalink(); ?>"><?php echo $contact_name;?></a>
		<?php endif; ?>    
    </h2>

    <?php if ( is_single() ) : ?>
		
		<div id="item-avatar" class="item-image <?php echo $enable; ?>"  data-overlayid="alterar-avatar">
        <?php /* Contact */ echo rolo_get_avatar_image( $contact_id, 'avatar' ); ?>
    
        <div class="contenthover alterar-avatar">
            <span><?php _e('Change Image', 'rolopress'); ?></span>
        </div><!-- #alterar-avatar -->
        </div><!-- .item-image -->

    <?php else : ?>

		<div id="item-avatar" class="item-image <?php echo $enable; ?>">
			<?php /* Contact */ echo rolo_get_avatar_image( $contact_id, 'avatar' ); ?>
		</div><!-- .item-image -->

    <?php endif; ?>
    
    <div class="item-col-1 width-40 item-form">
        <div class="cada-linha ano">
			<span class="title title-bloco-1 grey"><?php _e('City of Residence ', 'rolopress'); ?></span>
            <span id="rolo_city" class="resposta <?php echo ($contact_city ? '' : 'vazio'); ?>"><?php echo $contact_city; ?></span>
        </div><!-- .cada-linha -->

        <div class="cada-linha uf">
			<span class="title title-bloco-1 grey"><?php _e('State ', 'rolopress'); ?></span>
            <span id="rolo_uf" class="resposta <?php echo ($contact_uf ? '' : 'vazio'); ?>"><?php echo $contact_uf; ?></span>
        </div><!-- .cada-linha -->
        
        <div class="cada-linha legal">
            <span class="title title-bloco-1 grey"><?php _e('Company that Operates ', 'rolopress'); ?></span>
            <span id="rolo_contact_company" class="resposta blue <?php echo ($contact_company ? '' : 'vazio'); ?>"><?php echo $contact_company; ?></span>
        </div><!-- .cada-linha -->
        
        <div class="cada-linha cargo">
			<span class="title title-bloco-1 grey"><?php _e('Role ', 'rolopress'); ?></span>
            <span id="rolo_contact_role" class="resposta <?php echo ($contact_role ? '' : 'vazio'); ?>"><?php echo $contact_role; ?></span>
        </div><!-- .cada-linha -->

        <div class="cada-linha obs">
            <span class="title title-bloco-1 grey"><?php _e('Observation ', 'rolopress'); ?></span>
            <span id="rolo_contact_others" class="resposta <?php echo ($contact_others ? '' : 'vazio'); ?>"><?php echo wpautop( $contact_others ); ?></span>
        </div><!-- .cada-linha -->
        
		<?php if(is_single()) : ?>
			
			<div class="cada-linha data data-alt">
				<span class="title title-bloco-1 grey"><?php _e('Date of Information ', 'rolopress'); ?></span>
				<span id="rolo_contact_update" class="resposta <?php echo ($contact_update ? '' : 'vazio'); ?>"><?php echo $contact_update; ?></span>
				<div class="ajuda-in" title="Essa data é gerada automaticamente ao criar o contato, mas caso seja necessário poderá alterá-la posteriormente."></div>
			</div><!-- .cada-linha -->

            <div class="cada-linha data">
                <span class="title title-bloco-1 grey"><?php _e('Asked Source ', 'rolopress'); ?></span>
                <span id="rolo_contact_update_src" class="resposta <?php echo ($contact_update_src ? '' : 'vazio'); ?>"><?php echo $contact_update_src; ?></span>
            </div><!-- .cada-linha -->

			<div class="cada-linha data">
				<span class="title title-bloco-1 grey"><?php _e('Political Positioning ', 'rolopress'); ?></span>
				<span id="rolo_contact_party" class="resposta <?php echo ($contact_party ? '' : 'vazio'); ?>"><?php echo $contact_party; ?></span>
			</div><!-- .cada-linha -->

            <div class="cada-linha upload">
                <?php
                    if ( isset( $_POST['html-delete'] ) ) {
                        if ( isset( $_POST['attachment_ids'] ) ) {
                            foreach ($_POST['attachment_ids'] as $id_contact) {
                            wp_delete_attachment($id_contact, true);
                            }
                                if ($errors) {
                                    echo "<span class=\"msg-upload-erro\">Houve algum problema ao excluir o arquivo. Tente novamente.</span>";
                                    } else {
                                    echo "<span class=\"msg-upload-ok\">O arquivo selecionado foi excluído com sucesso.</span>";
                                }
                        }
                    }
                ?> 
                <?php
                    if ( isset( $_POST['html-upload'] ) && !empty( $_FILES ) ) {
                        require_once(ABSPATH . 'wp-admin/includes/admin.php');
                        $id_contact = media_handle_upload('async-upload', $contact_id);
                        unset($_FILES);
                        if ( is_wp_error($id_contact) ) {
                            $errors['upload_error'] = $id_contact;
                            $id_contact = false;
                        }
                    
                        if ($errors) {
                            echo "<span class=\"msg-upload-erro\">Houve algum problema ao enviar seu arquivo. Tente novamente.</span>";
                        } else {
                            echo "<span class=\"msg-upload-ok\">Seu arquivo foi adicionado com sucesso.</span>";
                        }
                    }
                ?>
                <span class="sub-titulo-form">Enviar arquivos</span>
                <form id="file-form" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                    <p id="async-upload-wrap">
                    <label for="async-upload"></label>
                    <input class="campo-upload" type="file" id="async-upload" name="async-upload"> <input type="submit" value="Upload" name="html-upload">
                    </p>
                
                    <p>
                    <input type="hidden" name="post_id" id="post_id" value="$contact_id" />
                    <?php wp_nonce_field('client-file-upload'); ?>
                    <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                    </p>
                
                    <p>
                    <input class="botao-upload" type="submit" value="Save all changes" name="save" style="display: none;">
                    </p>
                </form>
            
            </div><!-- .cada-linha -->
                        
            
            <?php
                $img_args = array(
                'post_type' => 'attachment',
                'numberposts' => -1,
                'post_status' => null,
                'post_parent' => $contact_id
                );
            $attachments = get_posts( $img_args );
            if ( $attachments ) { ?>
            
            <div class="cada-linha galeria">
             
            <span class="sub-titulo-form">Galeria de arquivos</span>
            <form id="file-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
            
                <?php
				echo '<ul class="galeria-anexos">';				
                foreach ( $attachments as $attachment ) {
                    //dump($attachment);
                    echo '<li class="'.$c.'"><input class="check-delete" type="checkbox" id="attachment_id" name="attachment_ids[]" value="'.$attachment->ID.'" />';
                    if ( $attachment->post_mime_type == 'application/pdf' ) {
                        echo '<a href="' . wp_get_attachment_url( $attachment->ID ) . '" target="_blank"><img src="' . get_template_directory_uri() . '/img/icon-pdf.jpg"></a>';
                    } else {
                        echo '<a href="'.wp_get_attachment_url($attachment->ID).'" rel="shadowbox" title="'.$attachment->post_excerpt.'" target="_blank">';
                        echo wp_get_attachment_image( $attachment->ID, 'thumb-anexo' );
                        echo '</a>';
                    }
                   
                   echo '</li>';
                  }
                echo '</ul>';
                ?>
                
                <br />
                <input class="botao-deletar-anexo" type="submit" value="Delete" name="html-delete">
            
            </form>
            
            </div><!-- .cada-linha -->        
			<?php } ?>
		
		<?php endif; ?>
	
    
    </div><!-- .item-col-1 -->
        
    <div class="item-col-2 width-40 item-form">
                
		<div class="cada-linha email">
			<span class="title title-bloco-4"><?php _e('E-mail ', 'rolopress'); ?></span>
			<span id="rolo_contact_email" class="resposta <?php echo ($contact_email ? '' : 'vazio'); ?>"><?php echo $contact_email;?></span>
		</div><!-- .cada-linha -->

		<div class="cada-linha endereco">
			<span class="title title-bloco-4"><?php _e('Address ', 'rolopress'); ?></span>
			<span id="rolo_contact_endereco" class="resposta-endereco resposta <?php echo ($contact_end ? '' : 'vazio'); ?>"><?php echo $contact_end; ?></span>
		</div><!-- .cada-linha -->
               
        <div class="cada-linha telefone">
            <span class="title title-bloco-4"><?php _e('Phones ', 'rolopress'); ?></span>
				<div class="box-telefone">
					<span id="rolo_contact_telefone" class="resposta <?php echo ($contact_tel ? '' : 'vazio'); ?>"><?php echo $contact_tel;?></span>   
					<span id="rolo_contact_telefone_alt" class="resposta <?php echo ($contact_tel_alt ? '' : 'vazio'); ?>"><?php echo $contact_tel_alt;?></span>      
				</div><!-- box-telefone -->
        </div><!-- .cada-linha -->

			<?php if(is_single()) : ?>
		
			<div class="cada-linha website url-field group">
			   <span class="title title-bloco-4"><?php _e('Website ', 'rolopress'); ?></span>
			   <span id="rolo_contact_website" class="resposta <?php echo ($contact_website ? '' : 'vazio'); ?>"><?php echo $contact_website; ?></span>
               <div class="ajuda-in" title="Adicione o endereço completo, com o http:// e o retante do endereço."></div>
			</div><!-- .cada-linha -->
				   
			<?php endif; ?>
            <?php if(is_single()) {
				$class_redes = "box-redes-single";
            	
			} else {
				$class_redes = "box-redes";
			}?>
                
        <div class="cada-linha redes">
            <span class="title title-bloco-4"><?php _e('Social Networks ', 'rolopress'); ?></span>
            <div class="<?php echo $class_redes; ?>"><?php echo $redes; ?></div>
        </div><!-- .cada-linha -->
        
        <div class="cada-linha contato">
            <span class="title title-bloco-4"><?php _e('Easiest way<br/ >to Contact ', 'rolopress'); ?></span>
            <span id="rolo_contact_contato_facil" class="resposta <?php echo ($contact_contato ? '' : 'vazio'); ?>"><?php echo $contact_contato; ?></span>
        </div><!-- .cada-linha -->

        <?php if(is_single()) : ?>
	        <a class="botao-imprimir" href="javascript:window.print()">Imprimir Contato</a>
        <?php endif; ?>
        
    </div><!-- .item-col-2 width-40 item-form -->
</div><!-- .bloco -->


<?php
}
/**
 * Displays a contact detail information
 *
 * @param int $contact_id
 * @return <type>
 *
 * @since 0.1
 */
function rolo_contact_details($contact_id) {
        if (!$contact_id) {
                return false;
        }

        $contact = get_post_meta($contact_id, 'rolo_contact', true);
        ?>
        <form id="contact-form">
                <input type="hidden" name="rolo_post_id" id="rolo_post_id" value ="<?php echo $contact_id;?>" />
                <ul id="vcard-<?php echo basename(get_permalink());?>" class="vcard">

                        <li class="vcard-export"><a class="url-field" href="http://h2vx.com/vcf/<?php the_permalink();?>"><span><?php _e('Export vCard', 'rolopress'); ?></span></a></li>
                        
                        <li class="fn"><?php echo $contact['rolo_contact_first_name'] . ' ' . $contact['rolo_contact_last_name'];?></li>
                        
                        <?php if ($contact['rolo_contact_title'] != "") { ?>
                        <li class="title" id="rolo_contact_title"><?php echo $contact['rolo_contact_title'];?></li><?php }
                        ?>
                        <?php if (get_the_term_list($contact_id, 'company') != "") { ?>
                        <li class="org"><span class="value"><?php echo get_the_term_list($contact_id, 'company', ''); ?></span></li><?php }
                        ?>

                        <?php $rolo_contact_full_address = $contact['rolo_contact_address'] . get_the_term_list($contact_id, 'city', '', '', '') . get_the_term_list($contact_id, 'state', '', '', '') . get_the_term_list($contact_id, 'zip', '', '', '') . get_the_term_list($contact_id, 'country', '', '', '');
                        if ($rolo_contact_full_address != "") { ?>
                        <li class="map"><a class="url-field" href="http://maps.google.com/maps?f=q&source=s_q&geocode=&q=<?php echo $contact['rolo_contact_address'] . " " . rolo_get_term_list($contact_id, 'city') . " " . rolo_get_term_list($contact_id, 'state') . " " . rolo_get_term_list($contact_id, 'country')  . " " . rolo_get_term_list($contact_id, 'zip');?> "><span><?php _e('Map', 'rolopress'); ?></span></a></li><?php }
                        ?>

                        <li>
                                <ul class="adr group">
                                        <span class="type hide">Home</span><!-- certain hcard parsers need this -->
                                        <?php
                                        if ($contact['rolo_contact_address'] != "") { ?><li class="street-address" id="rolo_contact_address"><?php echo $contact['rolo_contact_address']; ?></li><?php }
                                        if (get_the_term_list($contact_id, 'city', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('City', 'rolopress'); ?></span><?php echo get_the_term_list($contact_id, 'city', '', '', '');?><span id="city" class="locality edit-icon" style=""><?php echo rolo_get_term_list($contact_id, 'city'); ?></span></li><?php }
                                        if (get_the_term_list($contact_id, 'state', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('State', 'rolopress'); ?></span><?php echo get_the_term_list($contact_id, 'state', '', '', '');?><span id="state" class="region edit-icon" style=""><?php echo rolo_get_term_list($contact_id, 'state'); ?></span></li><?php }
                                        if (get_the_term_list($contact_id, 'zip', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('Zip', 'rolopress'); ?></span><?php echo get_the_term_list($contact_id, 'zip', '', '', '');?></a><span id="zip" class="postal-code edit-icon" style=""><?php echo rolo_get_term_list($contact_id, 'zip'); ?></span></li><?php }
                                        if (get_the_term_list($contact_id, 'country', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('Country', 'rolopress'); ?></span><?php echo get_the_term_list($contact_id, 'country', '', '', '');?><span id="country" class="country-name edit-icon" style=""><?php echo rolo_get_term_list($contact_id, 'country'); ?></span></li><?php }
                                        ?>
                                </ul>
                        </li>
                        
                        <?php if ($contact['rolo_contact_email'] != "") { ?><li class="email-address url-field group"><a class="email" href="mailto:<?php echo $contact['rolo_contact_email'];?>"><?php echo $contact['rolo_contact_email'];?> </a><span id="rolo_contact_email" class="edit-icon" style=""><?php echo $contact['rolo_contact_email']; ?></span></li><?php } ?>
                        <li>
                                <ul class="tel group">
                                        <?php
                                        if ($contact['rolo_contact_phone_Mobile'] != "") { ?><li class="tel tel-mobile"><span class="type"><?php _e('Mobile', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Mobile"><?php echo $contact['rolo_contact_phone_Mobile']; ?></span></li> <?php }
                                        if ($contact['rolo_contact_phone_Home'] != "") { ?><li class="tel tel-home"><span class="type"><?php _e('Home', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Home"><?php echo $contact['rolo_contact_phone_Home']; ?></span></li><?php }
                                        if ($contact['rolo_contact_phone_Work'] != "") { ?><li class="tel tel-work"><span class="type"><?php _e('Work', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Work"><?php echo $contact['rolo_contact_phone_Work']; ?></span></li><?php }
                                        if ($contact['rolo_contact_phone_Fax'] != "") { ?><li class="tel tel-fax"><span class="type"><?php _e('Fax', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Fax"><?php echo $contact['rolo_contact_phone_Fax']; ?></span></li><?php }
                                        if ($contact['rolo_contact_phone_Other'] != "") { ?><li class="tel tel-other"><span class="type"><?php _e('Other', 'rolopress'); ?></span>: <span class="value" id="rolo_contact_phone_Other"><?php echo $contact['rolo_contact_phone_Other']; ?></span></li><?php }
                                        ?>
                                </ul>
                        </li>
                        <li>
                                <ul class="im social group">
                                        <?php
                                        if ($contact['rolo_contact_im_Yahoo'] != "") { ?><li class="social social-yahoo url-field"><span class="type"><?php _e('Yahoo', 'rolopress'); ?></span> <a class="yahoo" href="ymsgr:sendIM?<?php echo $contact['rolo_contact_im_Yahoo']; ?>"><?php echo $contact['rolo_contact_im_Yahoo']; ?></a><span id="rolo_contact_im_Yahoo" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_Yahoo']; ?></span></li><?php }
                                        if ($contact['rolo_contact_im_MSN'] != "") { ?><li class="social social-msn url-field"><span class="type"><?php _e('MSN', 'rolopress'); ?></span> <a class="msn" href="msnim:chat?contact=<?php echo $contact['rolo_contact_im_MSN']; ?>"><?php echo $contact['rolo_contact_im_MSN']; ?></a><span id="rolo_contact_im_MSN" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_MSN']; ?></span></li><?php }
                                        if ($contact['rolo_contact_im_AOL'] != "") { ?><li class="social social-aim url-field"><span class="type"><?php _e('AIM', 'rolopress'); ?></span> <a class="aim" href="aim:goIM?<?php echo $contact['rolo_contact_im_AOL']; ?>"><?php echo $contact['rolo_contact_im_AOL']; ?></a><span id="rolo_contact_im_AOL" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_AOL']; ?></span></li><?php }
                                        if ($contact['rolo_contact_im_GTalk'] != "") { ?><li class="social social-gtalk url-field"><span class="type"><?php _e('GTalk', 'rolopress'); ?></span> <a class="gtalk" href="gtalk:chat?jid=<?php echo $contact['rolo_contact_im_GTalk']; ?>"><?php echo $contact['rolo_contact_im_GTalk']; ?></a><span id="rolo_contact_im_GTalk" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_GTalk']; ?></span></li><?php }
                                        if ($contact['rolo_contact_im_Skype'] != "") { ?><li class="social social-skype url-field"><span class="type"><?php _e('Skype', 'rolopress'); ?></span> <a class="skype" href="skype:=<?php echo $contact['rolo_contact_im_Skype']; ?>"><?php echo $contact['rolo_contact_im_Skype']; ?></a><span id="rolo_contact_im_Skype" class="edit-icon" style=""><?php echo $contact['rolo_contact_im_Skype']; ?></span></li><?php }
                                        if ($contact['rolo_contact_twitter'] != "") { ?><li class="social social-twitter url-field"><span class="type"><?php _e('Twitter', 'rolopress'); ?></span> <a class="twitter" href="http://www.twitter.com/<?php echo $contact['rolo_contact_twitter']; ?>"><?php echo $contact['rolo_contact_twitter']; ?></a><span id="rolo_contact_twitter" class="edit-icon" style=""><?php echo $contact['rolo_contact_twitter']; ?></span></li><?php }
                                        ?>
                                </ul>
                        </li>
                        <?php if ($contact['rolo_contact_website'] != "") { ?><li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span><a class="url" href="http://<?php echo $contact['rolo_contact_website']; ?>"><?php echo $contact['rolo_contact_website']; ?></a><span id="rolo_contact_website" class="edit-icon" style=""><?php echo $contact['rolo_contact_website']; ?></span></li><?php } ?>

                        <?php if ($contact['rolo_contact_post_tag'] != "" ) { ?>
                        <li class="tags url-field"><span class="type"><?php _e('Tags', 'rolopress');?></span>
                                <?php $post_tags = get_the_tags();
                                $tag_list = '';
                                $i = 0;
                                foreach ( $post_tags as $pt ) {
                                        $tag_list .= $pt->name;
                                        if ( $i+1<sizeof($post_tags) )
                                                $tag_list        .= ', ';
                                        $i++;
                                }
                                $tag_links        = get_the_term_list($cid, 'post_tag', '', ',','');
                                $tag_links        = explode(', ', $tag_links );
                                ?>

                                <ul class="tags group">
                                        <?php foreach ( $tag_links as $i=>$tag ): ?>
                                        <li class="url-field">
                                                <?php echo $tag; ?>
                                                <?php if ($i+1==sizeof($tag_links)): ?>
                                                <span id="post_tag" class="edit-icon" style=""><?php echo $tag_list; ?></span>
                                        <?php endif; ?>
                                </li>
                                <?php if ($i+1<sizeof($tag_links)): echo ', '; endif ?>
                        <?php endforeach; ?>
                </ul>
                <?php } ?>
        </li>                

        <?php rolopress_after_contact_details();?>
</ul><!-- vcard -->
</form>
<?php
}

/**
 * Displays a summarized version of company information
 *
 * @param <type> $company_id
 * @return <type>
 *
 * @since 0.1
 */
function rolo_company_header($company_id) {

        if (!$company_id) {
                return false;
        }

        if($_POST['taxonomia'] && is_single())
            rolo_update_modified_taxonomy( $_POST, $company_id );

    // $company = get_post_meta($company_id, 'rolo_company', true);
        $company = get_post_custom($company_id);

        $company_name = $company['rolo_company_name'][0];
        if(!$company_name)
            $company_name = $company['name'][0];
        $company_year = $company['rolo_company_year'][0];
        $company_legal = $company['rolo_company_legal'][0];
        $company_email = $company['rolo_company_email'][0];
        $company_website = $company['rolo_company_website'][0];

        $company_source = $company['rolo_company_source'][0];
        $company_tags = $company['rolo_company_post_tag'][0];
        $company_others = $company['rolo_company_others'][0];
        $company_address = $company['rolo_company_address'][0];
        $company_phone = $company['rolo_company_phone'][0];

        $company_city = $company['rolo_city'][0];
        $company_uf = $company['rolo_uf'][0];

        $company_redes = unserialize($company['rolo_company_redes'][0]);

        $company_redes_fb = $company['rolo_company_redes_fb'][0];
        $company_redes_tw = $company['rolo_company_redes_tw'][0];
        $company_redes_in = $company['rolo_company_redes_in'][0];
        $company_redes_out = $company['rolo_company_redes_out'][0];

        if(!$company_redes_fb)
            $company_redes_fb = 'Link para Facebook';
        if(!$company_redes_tw)
            $company_redes_tw = 'Link para Twitter';
        if(!$company_redes_in)
            $company_redes_in = 'Link para LinkedIn';
        if(!$company_redes_out)
            $company_redes_out = 'Link para Outra Rede';

        $redes  = '<span id="rolo_company_redes_fb" class="resposta resposta-redes">'.$company_redes_fb.'</span>';
        $redes .= '<span id="rolo_company_redes_tw" class="resposta resposta-redes">'.$company_redes_tw.'</span>';
        $redes .= '<span id="rolo_company_redes_in" class="resposta resposta-redes">'.$company_redes_in.'</span>';
        $redes .= '<span id="rolo_company_redes_out" class="resposta resposta-redes">'.$company_redes_out.'</span>';


        $company_tel = $company['rolo_company_telefone'][0];
        $company_tel_alt = $company['rolo_company_telefone_alt'][0];

        if($company_tel == "(_) _____-____")
            $company_tel = '';
        if($company_tel_alt == "(_) _____-____")
            $company_tel_alt = '';

        $company_end = $company['rolo_company_endereco'][0];
        $company_contato = $company['rolo_company_contato_facil'][0];

        $company_update = $company['rolo_company_update'][0];
                if(!$company_update) {
                        $company_update = get_the_time( 'd/m/Y', $company_id );                
                }

        $company_update_src = $company['rolo_company_update_src'][0];

        $post_id = get_post($post->ID); // get current company id
    $slug = $post_id->post_name; // define slug as $slug

    $company_contatos = unserialize($company['rolo_contatos'][0]);

    if(current_user_can( 'edit_posts' )) {
                   $enable = 'enabled';
   }

    ?>
    <?php //* Inicio do Bloco de Company Single */?>
    <div class="bloco">

            <div id="hcard-<?php echo basename(get_permalink());?>" class="item-header">

            <h2 class="title_single">
                <span class="title_single_company"></span><span class="blue"><?php echo $company_name;?></span>
            </h2>

		<div id="item-avatar" class="item-image <?php echo $enable; ?>"  data-overlayid="alterar-avatar">
        <?php /* Contact */ echo rolo_get_avatar_image( $contact_id, 'avatar' ); ?>
    
        <div class="contenthover alterar-avatar">
            <span><?php _e('Change Image', 'rolopress'); ?></span>
        </div><!-- #alterar-avatar -->
        </div><!-- .item-image -->
    
                    <div class="item-col-1 width-40 item-form">
						<div class="cada-linha ano-alt">
							<span class="title title-bloco-1 grey"><?php _e('Year of Creation ', 'rolopress'); ?></span>
							<span id="rolo_company_year" class="resposta <?php echo ($company_year ? '' : 'vazio'); ?>"><?php echo $company_year; ?></span>
							<div class="ajuda-in" title="<?php _e('Year in which the institution was created', 'rolopress'); ?>."></div>
						</div><!-- .cada-linha -->
						<div class="cada-linha">
							<span class="title title-bloco-1 grey"><?php _e('Legally Constituted? ', 'rolopress'); ?></span>
							<span id="rolo_company_legal" class="resposta <?php echo ($company_legal ? '' : 'vazio'); ?>"><?php echo $company_legal; ?></span>
                        </div><!-- .cada-linha -->
						<div class="cada-linha">
							<span class="title title-bloco-1 grey"><?php _e('Observation ', 'rolopress'); ?></span>
							<span id="rolo_company_others" class="resposta resposta-textarea <?php echo ($company_others ? '' : 'vazio'); ?>"><?php echo wpautop( $company_others ); ?></span>
						</div><!-- .cada-linha -->
                        <div class="cada-linha data-alt">
							<span class="title title-bloco-1 grey"><?php _e('Date of Information ', 'rolopress'); ?></span>
							<span id="rolo_company_update" class="resposta <?php echo ($company_update ? '' : 'vazio'); ?>"><?php echo $company_update; ?></span>
							<div class="ajuda-in" title="Data gerada automaticamente ao adicionar o contato. Poderá alterar a mesma posteriormente."></div>
						</div><!-- .cada-linha -->

                        <div class="cada-linha">
                            <span class="title title-bloco-1 grey"><?php _e('Asked Source ', 'rolopress'); ?></span>
                            <span id="rolo_company_update_src" class="resposta <?php echo ($company_update_src ? '' : 'vazio'); ?>"><?php echo $company_update_src; ?></span>
                        </div><!-- .cada-linha -->
                        
                <div class="cada-linha upload">
                    <?php
                        if ( isset( $_POST['html-delete'] ) ) {
                            if ( isset( $_POST['attachment_ids'] ) ) {
                                foreach ($_POST['attachment_ids'] as $id_company) {
                                wp_delete_attachment($id_company, true);
                                }
                                    if ($errors) {
                                        echo "There was an error deleting your file.";
                                        } else {
                                        echo "Your file has been deleted.";
                                    }
                            }
                        }
                    ?> 
                    <?php
                        if ( isset( $_POST['html-upload'] ) && !empty( $_FILES ) ) {
                            require_once(ABSPATH . 'wp-admin/includes/admin.php');
                            $id_company = media_handle_upload('async-upload', $company_id);
                            unset($_FILES);
                            if ( is_wp_error($id_company) ) {
                                $errors['upload_error'] = $id_company;
                                $id_company = false;
                            }
                        
                            if ($errors) {
                                echo "<p>There was an error uploading your file.</p>";
                            } else {
                                echo "<p>Your file has been uploaded.</p>";
                            }
                        }
                    ?>
                    <span class="sub-titulo-form">Enviar arquivos</span>
                    <form id="file-form" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                        <p id="async-upload-wrap">
                        <label for="async-upload"></label>
                        <input class="campo-upload" type="file" id="async-upload" name="async-upload"> <input type="submit" value="Upload" name="html-upload">
                        </p>
                    
                        <p>
                        <input type="hidden" name="post_id" id="post_id" value="$company_id" />
                        <?php wp_nonce_field('client-file-upload'); ?>
                        <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                        </p>
                    
                        <p>
                        <input class="botao-upload" type="submit" value="Save all changes" name="save" style="display: none;">
                        </p>
                    </form>
                
                </div><!-- .cada-linha -->
                            
                
                <?php
                    $img_args = array(
                    'post_type' => 'attachment',
                    'numberposts' => -1,
                    'post_status' => null,
                    'post_parent' => $company_id
                    );
                    
                $attachments = get_posts( $img_args );
                if ( $attachments ) { ?>
                
                <div class="cada-linha galeria">
                 
                <span class="sub-titulo-form">Galeria de arquivos</span>
                <form id="file-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                
                    <?php
					echo '<ul class="galeria-anexos">';
                    foreach ( $attachments as $attachment ) {
                        //dump($attachment);
                        echo '<li class="'.$c.'"><input class="check-delete" type="checkbox" id="attachment_id" name="attachment_ids[]" value="'.$attachment->ID.'" />';
                        if ( $attachment->post_mime_type == 'application/pdf' ) {
                            echo '<a href="' . wp_get_attachment_url( $attachment->ID ) . '" target="_blank"><img src="' . get_template_directory_uri() . '/img/icon-pdf.jpg"></a>';
                        } else {
                            echo '<a href="'.wp_get_attachment_url($attachment->ID).'" rel="shadowbox" title="'.$attachment->post_excerpt.'" target="_blank">';
                            echo wp_get_attachment_image( $attachment->ID, 'thumb-anexo' );
                            echo '</a>';
                        }
                       
                       echo '</li>';
                      }
					echo '</ul>';
                    ?>
                    
                    <br />
                    <input class="botao-deletar-anexo" type="submit" value="Delete" name="html-delete">
                
                </form>
                
                </div><!-- .cada-linha -->        
                <?php } ?>

            </div><!-- .item-col-1 width-40 item-form -->
            <div class="item-col-2 width-40 item-form">
                
				<div class="cada-linha">
                    <span class="title title-bloco-2 grey"><?php _e( 'E-mail ', 'rolopress' ); ?></span>
                    <span id="rolo_company_email" class="resposta <?php echo ($company_email ? '' : 'vazio'); ?>"><?php echo $company_email;?></span>
				</div><!-- .cada-linha -->

				<div class="cada-linha endereco">
                    <span class="title title-bloco-2 grey"><?php _e('Address ', 'rolopress'); ?></span>
                    <span id="rolo_company_endereco" class="resposta <?php echo ($company_end ? '' : 'vazio'); ?>"><?php echo $company_end; ?></span>
				</div><!-- .cada-linha -->

				<div class="cada-linha ano">
					<span class="title title-bloco-2 grey"><?php _e('City ', 'rolopress'); ?></span>
					<span id="rolo_city" class="resposta <?php echo ($company_city ? '' : 'vazio'); ?>"><?php echo $company_city; ?></span>
				</div><!-- .cada-linha -->                        

				<div class="cada-linha uf">
					<span class="title title-bloco-2 grey"><?php _e('State ', 'rolopress'); ?></span>
					<span id="rolo_uf" class="resposta <?php echo ($company_uf ? '' : 'vazio'); ?>"><?php echo $company_uf; ?></span>
				</div><!-- .cada-linha -->                            

				<div class="cada-linha telefone">
					<span class="title title-bloco-2 grey"><?php _e('Phone ', 'rolopress'); ?></span>
						<div class="box-telefone">
							<span id="rolo_company_telefone" class="resposta <?php echo ($company_tel ? '' : 'vazio'); ?>"><?php echo $company_tel;?></span>
							<span id="rolo_company_telefone_alt" class="resposta <?php echo ($company_tel_alt ? '' : 'vazio'); ?>"><?php echo $company_tel_alt;?></span>
						</div><!-- .box-telefone -->
				</div><!-- .cada-linha -->

				<div class="cada-linha">
					<div class="website url-field group">
						<span class="title title-bloco-2 grey"><?php _e('Website ', 'rolopress'); ?></span>
						<span id="rolo_company_website" class="resposta <?php echo ($company_website ? '' : 'vazio'); ?>"><?php echo $company_website; ?></span>
                        <div class="ajuda-in" title="Adicione o endereço completo, com o http:// e o retante do endereço."></div>
					</div>
				</div><!-- .cada-linha -->

				<?php if(is_single()) : ?>
				<div class="cada-linha">
						<div class="redes">
								<span class="title title-bloco-2 grey"><?php _e('Social Networks ', 'rolopress'); ?></span>
								<div class="box-redes"><?php echo $redes; ?></div>
						</div>
				</div><!-- .cada-linha -->
				<?php endif; ?>
                
				<div class="cada-linha">
					<div class="contato">
						<span class="title title-bloco-2 grey"><?php _e('Easiest way<br />to Contact ', 'rolopress'); ?></span><span id="rolo_company_contato_facil" class="resposta <?php echo ($company_contato ? '' : 'vazio'); ?>"><?php echo $company_contato; ?></span>
					</div>
				</div><!-- .cada-linha -->

			</div><!-- .item-col-2 item-form -->
                    
                        <?php if( is_single() ) : ?>
                    <hr>
                                    <?php rolo_company_members_list($company_id); ?>
                                <hr>
                                        
                                        <div class="taxonomias item-form">
                                                <div class="item-col-1 width-45">
                                                        <?php 
                                                        require_once(ABSPATH . 'wp-admin/includes/template.php');

                                                        echo '<div class="caracterizacao">';
                                                        echo '<h3 class="inline">'. __('Institutional Characterization', 'rolopress').'</h3>';
                                                        echo '<ul>';
                                                                wp_terms_checklist( $company_id, array( 'taxonomy' => 'caracterizacao', 'checked_ontop' => false ) );
                                                        echo '</ul>';
                                                        echo '</div>';

                                                        if(current_user_can('publish_posts')) {
                                                            echo '<form class="form-outros" name="caracterizacao" action="" method="post" onsubmit="return verificar(this)"><input id="outro" class="input-outros" type="text" name="nova" placeholder="Outro" value"" />';
                                                                wp_dropdown_categories(array('class' => 'select-outros', 'taxonomy' => 'caracterizacao', 'hierarchical' => true, 'hide_empty' => 0, 'show_option_none' => 'Escolha uma Opção', 'depth' => 1 ));
                                                            echo '<input type="hidden" name="taxonomia" value="caracterizacao" />';
                                                            echo '<div class="ajuda-in" title="Preencha esse campo caso os itens acima não contemplem sua categorização."></div>';
                                                            echo '<br /><input class="botao-ok" type="submit" value="OK" /></form>';
                                                        }

                                                        echo '<div class="interesse">';
                                                        echo '<h3 class="inline">'. __('Areas of Interest', 'rolopress').'</h3>';
                                                        echo '<ul>';
                                                                wp_terms_checklist( $company_id, array('taxonomy' => 'interesse', 'checked_ontop' => false ) );
                                                        echo '</ul>';
                                                        echo '</div>';

                                                        if(current_user_can('publish_posts')) {
                                                            echo '<form class="form-outros" name="interesse" action="" method="post" onsubmit="return verificar(this)"><input id="outro"  class="input-outros" type="text" name="nova" placeholder="Outro" value"" />';
                                                                wp_dropdown_categories(array('class' => 'select-outros', 'taxonomy' => 'interesse', 'hierarchical' => true, 'hide_empty' => 0, 'show_option_none' => 'Escolha uma Opção', 'depth' => 1 ));
                                                            echo '<input type="hidden" name="taxonomia" value="interesse" />';
															echo '<div class="ajuda-in" title="Preencha esse campo caso os itens acima não contemplem sua categorização."></div>';
                                                            echo '<br /><input class="botao-ok" type="submit" value="OK" /></form>';
                                                        }
                                                        ?>
                                                </div>
                                                <div class="item-col-2">
                                                        <?php
                                                        echo '<div class="abrangencia">';
                                                        echo '<h3 class="inline">'. __('Scope of Practice', 'rolopress').'</h3>';
                                                        echo '<ul>';
                                                                wp_terms_checklist( $company_id, array('class' => 'select-outros', 'taxonomy' => 'abrangencia', 'checked_ontop' => false ) );
                                                        echo '</ul>';
                                                        echo '</div>';

                                                        if(current_user_can('publish_posts')) {
                                                            echo '<form class="form-outros" name="abrangencia" action="" method="post" onsubmit="return verificar(this)"><input id="outro"  class="input-outros" type="text" name="nova" placeholder="Outro" value"" />';
                                                                wp_dropdown_categories(array('class' => 'select-outros', 'taxonomy' => 'abrangencia', 'hierarchical' => true, 'hide_empty' => 0, 'show_option_none' => 'Escolha uma Opção', 'depth' => 1));
                                                            echo '<input type="hidden" name="taxonomia" value="abrangencia" />';
															echo '<div class="ajuda-in" title="Preencha esse campo caso os itens acima não contemplem sua categorização."></div>';
                                                            echo '<br /><input class="botao-ok" type="submit" value="OK" /></form>';
                                                        }

														// Espaços de Participação
                                                        echo '<div class="participacao">';
                                                        echo '<h3 class="inline">'. __('Spaces of Participation', 'rolopress').'</h3>';
                                                        echo '<ul>';
                                                                wp_terms_checklist( $company_id, array('class' => 'select-outros', 'taxonomy' => 'participacao', 'checked_ontop' => false ) );
                                                        echo '</ul>';
                                                        echo '</div>';

                                                        if(current_user_can('publish_posts')) {
                                                            echo '<form class="form-outros" name="participacao" action="" method="post" onsubmit="return verificar(this)"><input id="outro"  class="input-outros" type="text" name="nova" placeholder="Especifique" value"" />';
                                                                wp_dropdown_categories(array('class' => 'select-outros', 'taxonomy' => 'participacao', 'hierarchical' => true, 'hide_empty' => 0, 'show_option_none' => 'Espaço de Participação', 'depth' => 1 ));
                                                            echo '<input type="hidden" name="taxonomia" value="participacao" />';
															echo '<div class="ajuda-in" title="Especifique o Espaço de Participação."></div>';
                                                            echo '<br /><input class="botao-ok" type="submit" value="OK" /></form>';                                                        
                                                        }
                                                        ?>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="impactos">
                                                <div class="item-col-1 width-45 item-form">
                                                        <h3 class="inline"><?php _e('Social and Environmental Impacts', 'rolopress'); ?></h3>
                                                        <?php 
                                                        $edit = 'OK';
                                                        $out = 'out';
                                                        // $company_conflito = unserialize($company['rolo_conflito'][0]); 

                                                        $checked = ''; if($company['rolo_conflito_check'][0]) { $checked = 'checked="checked"'; $edit = 'Editar'; $out = ''; }
                                                        $projeto = ''; if($company['rolo_conflito_projeto'][0]) { $projeto = $company['rolo_conflito_projeto'][0]; }
                                                        $desde = ''; if($company['rolo_conflito_desde'][0]) { $desde = $company['rolo_conflito_desde'][0]; }
                                                        $instancia = ''; if($company['rolo_conflito_instancia'][0]) { $instancia = $company['rolo_conflito_instancia'][0]; }
                                                        $fim = ''; if($company['rolo_conflito_equacionado'][0]) { $fim = 'checked="checked"'; }
                                                        $obs = ''; if($company['rolo_conflito_observacoes'][0]) { $obs = $company['rolo_conflito_observacoes'][0]; }                

                                    if(current_user_can('publish_posts')) {
                                        $inp = true;
                                    }
                                                        ?>
                            
                            <div class="cada-linha">
								<span class="title title-bloco-8 grey"><?php _e('You are in conflict with large <br /> projects and / or protected areas? ', 'rolopress'); ?></span>
                                <span id="rolo_conflito" class="rolo_conflito resposta">
                                <?php 
                                    if(current_user_can('publish_posts')) {
                                        echo '<input type="checkbox" class="rolo_conflito check" '.$checked.' />';
                                    } elseif ($checked) {
                                        _e('Yes', 'rolopress') . '</span>';
                                    } else {
                                        _e('-', 'rolopress') . '</span>';
                                    }
                                        
                                    ?>
                            </div><!-- .cada-linha -->

							<div class="cada-linha">
								<span class="title title-bloco-8 grey"><?php _e('Which Project?', 'rolopress'); ?></span>
								<span class="rolo_conflito resposta <?php echo ($projeto ? '' : 'vazio'); ?>"><?php echo $projeto; ?></span>
								<input type="text" class="input_conflito out no-print" value="<?php echo $projeto; ?>"/>
                            </div><!-- .cada-linha -->

							<div class="cada-linha">
								<span class="title title-bloco-8 grey"><?php _e('Since when does it occur?', 'rolopress'); ?></span>
                                <span class="rolo_conflito resposta <?php echo ($desde ? '' : 'vazio'); ?>"><?php echo $desde; ?></span>
                                <input type="text" class="input_conflito out no-print" value="<?php echo $desde; ?>"/>
                            </div><!-- .cada-linha -->

                            <div class="cada-linha">
                                <span class="title title-bloco-8 grey"><?php _e('The case was taken to some instance?', 'rolopress'); ?></span>
                                <span class="rolo_conflito resposta <?php echo ($instancia ? '' : 'vazio'); ?>"><?php echo $instancia; ?></span>
                                <input type="text" class="input_conflito out no-print" value="<?php echo $instancia; ?>"/>
                            </div><!-- .cada-linha -->
                            
                            <div class="cada-linha">
                                <span class="title title-bloco-8 grey"><?php _e('The situation was equated?', 'rolopress'); ?></span>
                                <span class="rolo_conflito resposta">
                                <?php 
                                    if(current_user_can('publish_posts')) {
                                        echo '<input type="checkbox" class="input_conflito" '. $fim .'/>';
                                    } elseif ($fim) {
                                        _e('Yes', 'rolopress') . '</span>';
                                    } else {
                                        _e('-', 'rolopress') . '</span>';
                                    }
                                        
                                ?>
                            </div><!-- .cada-linha -->
                            
                            <div class="cada-linha">
                                <span class="title title-bloco-8 grey"><?php _e('Other comments on the case in question', 'rolopress'); ?></span>
                                <span class="rolo_conflito resposta <?php echo ($obs ? '' : 'vazio'); ?>"><?php echo $obs; ?></span>
                                <input type="text" class="input_conflito out no-print" value="<?php echo $obs; ?>"/>
                            </div><!-- .cada-linha -->

                            <?php if(current_user_can( 'publish_posts' )) : ?>
							 <input type="button" class="input_conflito botao-edit <?php echo $out; ?> button no-print" value="<?php echo $edit; ?>" />
                            <?php endif; ?>
                            
						</div><!-- item-col-1 -->
                        
						<div class="item-col-2 width-45 item-form">
                            <h3 class="inline"><?php _e('Relationship with Litoral Sustentável project', 'rolopress'); ?></h3>
                            <?php 
                            $edit = 'OK';
                            $out = 'out';
                            // $company_relacao = unserialize($company['rolo_relacao'][0]); 

                            $checked = ''; if($company['rolo_relacao_check'][0]) { $checked = 'checked="checked"'; $edit = __('Edit', 'rolopress'); $out = ''; }
                            $local = ''; if($company['rolo_relacao_local'][0]) { $local = $company['rolo_relacao_local'][0]; }
                            $apoio = ''; if($company['rolo_relacao_apoio'][0]) { $apoio = 'checked="checked"'; }
                            $conflito = ''; if($company['rolo_relacao_conflito'][0]) { $conflito = $company['rolo_relacao_conflito'][0]; }
                            ?>

                            <div class="cada-linha">
								<span class="title title-bloco-7 grey"><?php _e('Participated in any event the Project?', 'rolopress'); ?></span>
                                <span class="rolo_relacao resposta">
                                    <?php 
                                    if(current_user_can('publish_posts')) {
                                        echo '<input type="checkbox" class="rolo_relacao_check" '. $checked .'/>';
                                    } elseif ($checked) {
                                        _e('Yes', 'rolopress') . '</span>';
                                    } else {
                                        _e('-', 'rolopress') . '</span>';
                                    }
                                        
                                ?>
							</div><!-- .cada-linha -->
                            
                            <div class="cada-linha">
								<span class="title title-bloco-7 grey"><?php _e('Locale', 'rolopress'); ?></span>
                                <span class="rolo_relacao resposta <?php echo ($local ? '' : 'vazio'); ?>"><?php echo $local; ?></span>
                                <input type="text" class="input_relacao out no-print" value="<?php echo $local; ?>"/>
							</div><!-- .cada-linha -->
                                                       
                            <div class="cada-linha">
								<span class="title title-bloco-7 grey"><?php _e('Has supported / released the project?', 'rolopress'); ?></span>
                                <span class="rolo_relacao resposta">
                                    <?php 
                                    if(current_user_can('publish_posts')) {
                                        echo '<input type="checkbox" class="input_relacao" '. $apoio .'/>';
                                    } elseif ($apoio) {
                                        _e('Yes', 'rolopress') . '</span>';
                                    } else {
                                        _e('-', 'rolopress') . '</span>';
                                    }
                                        
                                ?>
                            </div><!-- .cada-linha -->
                            
							<div class="cada-linha">
                                <span class="title title-bloco-7 grey"><?php _e('Have a history of conflict with the project? <br /> What reason?', 'rolopress'); ?></span>
                                <span class="rolo_relacao resposta <?php echo ($conflito ? '' : 'vazio'); ?>"><?php echo $conflito; ?></span>
                                <input type="text" class="input_relacao out no-print" value="<?php echo $conflito; ?>" />
                            </div><!-- .cada-linha -->

                            <?php if(current_user_can( 'publish_posts' )) : ?>
                            <input type="button" class="input_relacao botao-edit <?php echo $out; ?> button no-print" value="<?php echo $edit; ?>" />
                            <?php endif; ?>
                                                
                        </div><!-- .item-col-2 width-40 -->
                        
                                        </div><!-- .impactos -->                                


                                <?php //* Fim do Bloco de Company */?>

                                <?php rolopress_after_company_header();?>
                        <?php endif; ?>
                        
		<?php if(is_single()) : ?>
	        <a class="botao-imprimir" href="javascript:window.print()">Imprimir Contato</a>
        <?php endif; ?>
                        
                        </div><!-- .bloco -->
                </div><!-- hcard -->                
                <?php
                
        }

function rolo_company_header_list($company_id) {

        if (!$company_id) {
                return false;
        }

    // $company = get_post_meta($company_id, 'rolo_company', true);
        $company = get_post_custom($company_id);

        $company_name = $company['rolo_company_name'][0];
        if(!$company_name)
            $company_name = $company['name'][0];
        $company_email = $company['rolo_company_email'][0];
        $company_website = $company['rolo_company_website'][0];

        $company_source = $company['rolo_company_source'][0];
        $company_tags = $company['rolo_company_post_tag'][0];
        $company_others = $company['rolo_company_others'][0];
        $company_address = $company['rolo_company_address'][0];
        $company_phone = $company['rolo_company_phone'][0];

        $atuacao = get_the_terms( $company_id, 'abrangencia' );

        if($atuacao) {
                foreach ($atuacao as $a) {
                        $atuacao_terms[] = $a->name;
                }

                $atuacao_terms = join(', ', $atuacao_terms);        
        }

        $interesses = get_the_terms( $company_id, 'interesse' );

        if($interesses) {
                foreach ($interesses as $a) {
                        $interesse_terms[] = $a->name;
                }

                $interesse_terms = join(', ', $interesse_terms);        
        }        

        $participacao = get_the_terms( $company_id, 'participacao' );

        if($participacao) {
                foreach ($participacao as $a) {
                        $participacao_terms[] = $a->name;
                }

                $participacao_terms = join(', ', $participacao_terms);        
        }        

        // $relacao = unserialize($company['rolo_relacao_check'][0]); 
        
        $participou = 'Não'; if($company['rolo_relacao_check'][0]) { $participou = 'Sim'; }
        $apoio = 'Não'; if($company['rolo_relacao_apoio'][0]) { $apoio = 'Sim'; }        

        $company_tel = $company['rolo_company_telefone'][0];
        $company_tel_alt = $company['rolo_company_telefone_alt'][0];

        if($company_tel == "(_) _____-____")
            $company_tel = '';
        if($company_tel_alt == "(_) _____-____")
            $company_tel_alt = '';

        $company_end = $company['rolo_company_endereco'][0];
        $company_contato = $company['rolo_company_contato_facil'][0];
        
        $company_update = $company['rolo_company_update'][0];
                if(!$company_update) {
                        $company_update = get_the_time( 'd/m/Y', $company_id );                
                }

        $post_id = get_post($post->ID); // get current company id
		$slug = $post_id->post_name; // define slug as $slug

    // $atuacao = get_post_taxonomies( $post );

    $company_contatos = unserialize($company['rolo_contatos'][0]);

    if(current_user_can( 'edit_posts' )) {
                   $enable = 'enabled';
    }

    ?>
    <?php //* Inicio do Bloco de Company */?>
            <div id="hcard-<?php echo basename(get_permalink());?>" class="bloco item-header">

				<h2 class="title_single">
					<?php echo (is_search() ? '<div class="div-deleta"><input class="deleta" type="checkbox" name="multiple[]" rel="'.get_the_title().'" value="'.get_the_ID().'" /></div>' : ''); ?>
					<span class="title_single_company"></span><a class="fn blue" href="<?php the_permalink();?>"><?php echo $company_name;?></a>
				</h2>

				<div id="item-avatar" class="item-image <?php echo $enable; ?>">
					<?php /* Company */ echo rolo_get_avatar_image( $contact_id, 'avatar' ); ?>
				</div><!-- .item-image -->
    
				<div class="item-col-1 width-40 item-form">
					<div class="cada-linha">
						<div class="email url-field">
							<span class="title title-bloco-1 grey"><?php _e('E-mail ', 'rolopress'); ?></span><span id="rolo_company_email" class="resposta <?php echo ($company_email ? '' : 'vazio'); ?>"><a class="email" href="mailto:<?php echo $company_email;?>"><?php echo $company_email;?> </a></span>
						</div>
					</div><!-- .cada-linha -->

					<div class="cada-linha">
						<div class="endereco">
							<span class="title title-bloco-1 grey"><?php _e('Address ', 'rolopress'); ?></span><span id="rolo_company_endereco" class="resposta <?php echo ($company_end ? '' : 'vazio'); ?>"><?php echo $company_end; ?></span>
						</div>
					</div><!-- .cada-linha -->

					<div class="cada-linha">
						<span class="title title-bloco-1 grey"><?php _e('Phones ', 'rolopress'); ?></span>
							<div class="box-telefone">
								<span id="rolo_company_telefone" class="resposta <?php echo ($company_tel ? '' : 'vazio'); ?>"><?php echo $company_tel;?></span>
								<span id="rolo_company_telefone_alt" class="resposta <?php echo ($company_tel_alt ? '' : 'vazio'); ?>"><?php echo $company_tel_alt;?></span>
							</div><!-- .box-telefone -->
					</div><!-- .cada-linha -->

					<div class="cada-linha">
						<div class="website url-field group">
							<span class="title title-bloco-1 grey"><?php _e('Website ', 'rolopress'); ?></span><span id="rolo_company_website" class="resposta <?php echo ($company_website ? '' : 'vazio'); ?>"><a class="url" href="http://<?php echo $company_website; ?>"><?php echo $company_website; ?></a></span>
                            <div class="ajuda-in" title="Adicione o endereço completo, com o http:// e o retante do endereço."></div>
						</div>
					</div><!-- .cada-linha -->

					<div class="cada-linha">
						<div class="contato">
							<span class="title title-bloco-1 grey"><?php _e('Easiest way<br />to contact ', 'rolopress'); ?></span><span id="rolo_company_contato_facil" class="resposta <?php echo ($company_contato ? '' : 'vazio'); ?>"><?php echo $company_contato; ?></span>
						</div>
					</div><!-- .cada-linha -->
						
					<div class="cada-linha obs">
						<span class="title title-bloco-1 grey"><?php _e('Observation ', 'rolopress'); ?></span>
						<span id="rolo_company_others" class="resposta resposta-textarea <?php echo ($company_others ? '' : 'vazio'); ?>"><?php echo $company_others; ?></span>
					</div><!-- .cada-linha -->

				</div><!-- .item-col-1 width-40 item-form -->
				<div class="item-col-2 width-40 item-form">
					<div class="cada-linha obs">
						<span class="title title-bloco-2 grey"><?php _e('Acting ', 'rolopress'); ?></span>
						<span id="rolo_company_others" class="resposta <?php echo ($atuacao ? '' : 'vazio'); ?>"><?php echo $atuacao_terms; ?></span>
					</div><!-- .cada-linha -->   
                         
					<div class="cada-linha obs">
						<span class="title title-bloco-2 grey"><?php _e('Interests ', 'rolopress'); ?></span>
						<span id="rolo_company_others" class="resposta <?php echo ($interesses ? '' : 'vazio'); ?>"><?php echo $interesse_terms; ?></span>
					</div><!-- .cada-linha --> 
                                                       
					<div class="cada-linha obs">
						<span class="title title-bloco-2 grey"><?php _e('Participation ', 'rolopress'); ?></span>
						<span id="rolo_company_others" class="resposta <?php echo ($participacao ? '' : 'vazio'); ?>"><?php echo $participacao_terms; ?></span>
					</div><!-- .cada-linha --> 
                           
					<div class="cada-linha obs">
						<span class="title sub-titulo-form grey"><?php _e('Relationship with Litoral Sustentável project ', 'rolopress'); ?></span>
					</div><!-- .cada-linha -->                            

					<div class="cada-linha obs">
						<span class="title title-bloco-3 grey"><?php _e('Participated in any event the Project? ', 'rolopress'); ?></span>
						<span id="rolo_company_others" class="resposta"><?php echo $participou; ?></span>
					</div><!-- .cada-linha -->                            

					<div class="cada-linha">
						<span class="title title-bloco-3 grey"><?php _e('Has supported / released the project? ', 'rolopress'); ?></span><span id="rolo_company_others" class="resposta"><?php echo $apoio; ?></span>
					</div><!-- .cada-linha -->                            
				</div><!-- .item-col-2 width-40 item-form -->

			</div><!-- hcard .bloco -->
	</a>                
<?php
                if(is_search()) {
                        rolo_company_members_list($company_id, $_POST['busca_municipio'], $_POST['busca_uf']);
                 } 
                
        }

function rolo_company_members_list($company_id, $city = false, $uf = false) {

        $company_contatos = get_post_meta( $company_id, 'rolo_contatos', true );



        if(is_search() && !$company_contatos)
                return;
?>
	<div class="contatos-btn item-form contatos-in-company">
	<table>
		<tr>
			<?php echo (is_single() && current_user_can( 'publish_posts' )) ? "<th class=\"th-remove\"></th>" : "" ?>
			<th class="contatos-item-form"><h3><?php _e('Contacts', 'rolopress'); ?></h3></th>
			<th class="contatos-item-form"><h3><?php _e('Role', 'rolopress'); ?></h3></th>
			<th class="contatos-item-form"><h3><?php _e('Phone', 'rolopress'); ?></h3></th>
			<th class="contatos-item-form"><h3><?php _e('E-mail', 'rolopress'); ?></h3></th>
		</tr>
		<?php 
			if(!$company_contatos) {
				$company_contatos = array();
			}
				
		
			foreach($company_contatos as $contato) {

				$user = get_post( $contato );

				if(has_term( 'contact', 'type', $user )) { 
					
					if(is_search()) :
						if($city) {
							if ($city != get_post_meta( $user->ID, 'rolo_city', true ) )
								continue;
						}
						if($uf != 'todos') {
							if ($uf != get_post_meta( $user->ID, 'rolo_uf', true ) )
								continue;
						}
					endif;
				?>

				<tr>
					<?php echo (is_single() && current_user_can( 'publish_posts' )) ? "<td class='td-remove'><button class='remove-contact-in-company' name='".$user->ID."'>-</button></td>" : "" ?>
					<td class="contatos-item-form-td"><a href="<?php echo get_permalink($user->ID); ?>"><?php echo $user->post_title; ?></a></td>
					<td class="contatos-item-form-td"><?php echo get_post_meta( $user->ID, 'rolo_contact_role', true ); ?></td>
					<td class="contatos-item-form-td"><?php echo get_post_meta( $user->ID, 'rolo_contact_telefone', true ); ?></td>
					<td class="contatos-item-form-td"><?php echo get_post_meta( $user->ID, 'rolo_contact_email', true ); ?></td>
				</tr>


				<?php }

			}
			
			
			
			if(is_single() && current_user_can( 'publish_posts' ))
				echo '<tr><td><button class="add-contact-in-company">+</button></td><td class="insertname" colspan="4"></td></tr>';
			
			?>
			
			</table>
		</div>
	<?php
	// endif;
}

/**
 * Displays company detail information
 *
 * @param int $company_id
 * @return <type>
 *
 * @since 0.1
 */
function rolo_company_details($company_id) {
        if (!$company_id) {
                return false;
        }

        $company = get_post_meta($company_id, 'rolo_company', true);
    $slug = $post_id->post_name; // define slug as $slug
//    print_r($company);
    ?>
    <form id="company-form">
            <input type="hidden" name="rolo_post_id" id="rolo_post_id" value ="<?php echo $company_id;?>" />
            <ul id="vcard-<?php basename(get_permalink());?>" class="vcard">

                    <li class="vcard-export"><a class="url-field" href="http://h2vx.com/vcf/<?php the_permalink();?>"><span><?php _e('Export vCard', 'rolopress'); ?></span></a></li>

                    <li>
                            <a class="fn org"
                            <?php if (is_single()) : // show proper links on single or archive company pages ?>
                            href="<?php echo get_term_link($company['rolo_company_name'], 'company'); ?>"><?php echo $company['rolo_company_name'];?>
                    <?php else: ?>
                    href="<?php the_permalink();?>"><?php echo $company['rolo_company_name'];?>
            <?php endif;?>
    </a>
</li>

<?php $rolo_company_full_address = $company['rolo_company_address'] . get_the_term_list($company_id, 'city', '', '', '') . get_the_term_list($company_id, 'state', '', '', '') . get_the_term_list($company_id, 'zip', '', '', '') . get_the_term_list($company_id, 'country', '', '', '');
if ($rolo_company_full_address != "") { ?>
<li class="map"><a class="url" href="http://maps.google.com/maps?f=q&source=s_q&geocode=&q=<?php echo $company['rolo_company_address'] . " " . rolo_get_term_list($company_id, 'city') . " " . rolo_get_term_list($company_id, 'state') . " " . rolo_get_term_list($company_id, 'country')  . " " . rolo_get_term_list($company_id, 'zip');?> "><span><?php _e('Map', 'rolopress'); ?></span></a></li><?php }
?>

<li>
        <ul class="adr group">
                <span class="type hide">Work</span><!-- certain hcard parsers need this -->
                <?php
                if ($company['rolo_company_address'] != "") { ?><li class="street-address" id="rolo_company_address"><?php echo $company['rolo_company_address']; ?></li><?php }
                if (get_the_term_list($company_id, 'city', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('City', 'rolopress'); ?></span><?php echo get_the_term_list($company_id, 'city', '', '', '');?><span id="city" class="locality edit-icon" style=""><?php echo rolo_get_term_list($company_id, 'city'); ?></span></li><?php }
                if (get_the_term_list($company_id, 'city', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('State', 'rolopress'); ?></span><?php echo get_the_term_list($company_id, 'state', '', '', '');?><span id="state" class="region edit-icon" style=""><?php echo rolo_get_term_list($company_id, 'state'); ?></span></li><?php }
                if (get_the_term_list($company_id, 'city', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('Zip', 'rolopress'); ?></span><?php echo get_the_term_list($company_id, 'zip', '', '', '');?></a><span id="zip" class="postal-code edit-icon" style=""><?php echo rolo_get_term_list($company_id, 'zip'); ?></span></li><?php }
                if (get_the_term_list($company_id, 'city', '', '', '') != "") { ?><li class="url-field"><span class="type"><?php _e('Country', 'rolopress'); ?></span><?php echo get_the_term_list($company_id, 'country', '', '', '');?><span id="country" class="country-name edit-icon" style=""><?php echo rolo_get_term_list($company_id, 'country'); ?></span></li><?php }
                ?>

        </ul>
</li>


<?php if ($company['rolo_company_email'] != "") { ?><li class="email-address url-field"><a class="email" href="mailto:<?php echo $company['rolo_company_email'];?>"><?php echo $company['rolo_company_email'];?></a><span id="rolo_company_email" class="edit-icon" style=""><?php echo $company['rolo_company_email']; ?></span></li><?php } ?>

        <li>
                <ul class="tel group">
                        <?php
                        if ($company['rolo_company_phone_Mobile'] != "") { ?><li class="tel tel-mobile"><span class="type"><?php _e('Mobile', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Mobile"><?php echo $company['rolo_company_phone_Mobile']; ?></span></li><?php }
                        if ($company['rolo_company_phone_Work'] != "") { ?><li class="tel tel-work"><span class="type"><?php _e('Work', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Work"><?php echo $company['rolo_company_phone_Work']; ?></span></li><?php }
                        if ($company['rolo_company_phone_Fax'] != "") { ?><li class="tel tel-fax"><span class="type"><?php _e('Fax', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Fax"><?php echo $company['rolo_company_phone_Fax']; ?></span></li><?php }
                        if ($company['rolo_company_phone_Other'] != "") { ?><li class="tel tel-other"><span class="type"><?php _e('Other', 'rolopress'); ?></span>: <span class="value" id="rolo_company_phone_Other"><?php echo $company['rolo_company_phone_Other']; ?></span></li><?php }
                        ?>
                </ul>
        </li>

        <li>
                <ul class="im social group">
                        <?php
                        if ($company['rolo_company_im_Yahoo'] != "") { ?><li class="social social-yahoo url-field"><span class="type"><?php _e('Yahoo', 'rolopress'); ?></span>: <a class="yahoo" href="ymsgr:sendIM?<?php echo $company['rolo_company_im_Yahoo']; ?>"><?php echo $company['rolo_company_im_Yahoo']; ?></a><span id="rolo_company_im_Yahoo" class="edit-icon" style=""><?php echo $company['rolo_company_im_Yahoo']; ?></span></li><?php }
                        if ($company['rolo_company_im_MSN'] != "") { ?><li class="social social-msn url-field"><span class="type"><?php _e('MSN', 'rolopress'); ?></span>: <a class="msn" href="msnim:chat?company=<?php echo $company['rolo_company_im_MSN']; ?>"><?php echo $company['rolo_company_im_MSN']; ?></a><span id="rolo_company_im_MSN" class="edit-icon" style=""><?php echo $company['rolo_company_im_MSN']; ?></span></li><?php }
                        if ($company['rolo_company_im_AIM'] != "") { ?><li class="social social-aim url-field"><span class="type"><?php _e('AIM', 'rolopress'); ?></span>: <a class="aim" href="aim:goIM?<?php echo $company['rolo_company_im_AOL']; ?>"><?php echo $company['rolo_company_im_AOL']; ?></a><span id="rolo_company_im_AOL" class="edit-icon" style=""><?php echo $company['rolo_company_im_AOL']; ?></span></li><?php }
                        if ($company['rolo_company_im_GTalk'] != "") { ?><li class="social social-gtalk url-field"><span class="type"><?php _e('GTalk', 'rolopress'); ?></span>: <a class="gtalk" href="gtalk:chat?jid=<?php echo $company['rolo_company_im_GTalk']; ?>"><?php echo $company['rolo_company_im_GTalk']; ?></a><span id="rolo_company_im_GTalk" class="edit-icon" style=""><?php echo $company['rolo_company_im_Yahoo']; ?></span></li><?php }
                        if ($company['rolo_company_twitter'] != "") { ?><li class="social social-twitter url-field"><span class="type"><?php _e('Twitter', 'rolopress'); ?></span> <a class="twitter" href="http://www.twitter.com/<?php echo $company['rolo_company_twitter']; ?>"><?php echo $company['rolo_company_twitter']; ?></a><span id="rolo_company_twitter" class="edit-icon" style=""><?php echo $company['rolo_company_twitter']; ?></span></li><?php }
                        ?>
                </ul>
        </li>

        <?php if ($company['rolo_company_website'] != "") { ?><li class="website url-field group"><span class="type"><?php _e('Website', 'rolopress'); ?></span> <a class="url" href="http://<?php echo $company['rolo_company_website']; ?>"><?php echo $company['rolo_company_website']; ?></a><span id="rolo_company_website" class="edit-icon" style=""><?php echo $company['rolo_company_website']; ?></span></li><?php } ?>

        <?php if ($company['rolo_company_post_tag'] != "" ) { ?>
        <li class="tags url-field"><span class="type"><?php _e('Tags', 'rolopress');?></span>
                <?php $post_tags = get_the_tags();
                $tag_list = '';
                $i = 0;
                foreach ( $post_tags as $pt ) {
                        $tag_list        .= $pt->name;
                        if ( $i+1<sizeof($post_tags) )
                                $tag_list        .= ', ';
                        $i++;
                }
                $tag_links        = get_the_term_list($cid, 'post_tag', '', ', ');
                $tag_links        = explode(', ', $tag_links );
                ?>

                <ul class="tags group">
                        <?php foreach ( $tag_links as $i=>$tag ): ?>
                        <li class="url-field">
                                <?php echo $tag; ?>
                                <?php if ($i+1==sizeof($tag_links)): ?>
                                <span id="post_tag" class="edit-icon" style=""><?php echo $tag_list; ?></span>
                        <?php endif; ?>
                </li>

                <?php if ($i+1<sizeof($tag_links)): echo ', '; endif ?>
        <?php endforeach; ?>
</ul>
<?php } ?>

</li>




<?php rolopress_after_company_details();?>
</ul><!-- vcard -->
</form>
<?php
}

/**
 *
 * @param <type> $post_id
 * @param <type> $taxonomy
 * @return <type>
 *
 * @since 1.0
 */
function rolo_get_term_list($post_id, $taxonomy) {
        $actual_terms = array();
        $terms = get_the_terms($post_id, $taxonomy);
        if (is_array($terms)) {
                foreach ( $terms as $term ) {
                        $actual_terms[] = $term->name;
                }
        }
        return join(',' , $actual_terms);
}

/**
 * Get contact url
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_url($contact_id) {
        return get_permalink($contact_id);
}

/**
 * Get contact full name
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_name($contact_id) {
        return apply_filters('rolo_contact_name', rolo_contact_first_name($contact_id) . ' ' . rolo_contact_last_name($contact_id) );
}

/**
 * Get contact first name
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_first_name($contact_id) {
        return _rolo_get_field($contact_id, 'first_name');
}

/**
 * Get contact last name
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_last_name($contact_id) {
        return _rolo_get_field($contact_id, 'last_name');
}

/**
 * Get contact email link
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_email_link($contact_id) {
        return apply_filters('rolo_email_link', 'mailto:' . _rolo_get_field($contact_id, 'email'));
}

/**
 * Get contact email
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_email($contact_id) {
        return _rolo_get_field($contact_id, 'email');
}

/**
 * Get contact mobile phone
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_mobile_phone($contact_id) {
        return _rolo_get_field($contact_id, 'mobile_phone');
}

/**
 * Get contact home phone
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_home_phone($contact_id) {
        return _rolo_get_field($contact_id, 'home_phone');
}

/**
 * Get contact work Phone
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_work_phone($contact_id) {
        return _rolo_get_field($contact_id, 'work_phone');
}

/**
 * Get contact fax
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_fax($contact_id) {
        return _rolo_get_field($contact_id, 'fax');
}

/**
 * Photo url
 * @param <type> $contact_id
 * @return <type>
 */
function rolo_contact_photo_url($contact_id) {
        return _rolo_get_field($contact_id, 'image_path');
}

/**
 * Private function used to retrieve the contact field value from custom fields
 * @global array $contact_fields
 * @param string $post_id Post whose custom field to be retrieved
 * @param string $field_name The custom field name
 * @return <type>
 */
function _rolo_get_field($post_id, $field_name) {
        global $contact_fields;

    //TODO The meta key should also be stored in the contact fields array
        $value = get_post_meta($post_id, $contact_fields[$field_name]['name'] . '_rolo_value', true);
        $value = ($value == "") ? $contact_fields[$field_name]['std'] : $value;
        return apply_filters($contact_fields[$field_name]['filter'], $value);
}

function wt_get_ID_by_page_name($page_name) {
        global $wpdb;
        $page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."'");
        return $page_name_id;
}


/**
 * Identifies taxonomy type
 *
 * Use to identify the item type and do something.
 * Example: if ( rolo_type_is( 'contact' ) ) { do something }        
 *
 * @credits: Justin Tadlock: http://wordpress.org/support/topic/281899
 */
function rolo_type_is( $type, $_post = null ) {
        if ( empty( $type ) )
                return false;

        if ( $_post )
                $_post = get_post( $_post );
        else
                $_post =& $GLOBALS['post'];

        if ( !$_post )
                return false;

        $r = is_object_in_term( $_post->ID, 'type', $type );

        if ( is_wp_error( $r ) )
                return false;

        return $r;
}

/**
 * Get the page number
 */
function get_page_number() {
        if (get_query_var('paged')) {
                print ' | ' . __( 'Page ' , 'rolopress') . get_query_var('paged');
        }
}


/**
 * For tag lists on tag archives: Returns other tags except the current one (redundant)
 */
function tag_ur_it($glue) {
        $current_tag = single_tag_title( '', '',  false );
        $separator = "\n";
        $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
        foreach ( $tags as $i => $str ) {
                if ( strstr( $str, ">$current_tag<" ) ) {
                        unset($tags[$i]);
                        break;
                }
        }
        if ( empty($tags) )
                return false;

        return trim(join( $glue, $tags ));
}


/**
 * Get Page ID by page title
 *
 * @param string $page_name Page title
 *
 * @Credits: http://www.web-templates.nu/2008/09/02/get-id-by-page-name/
 *
 * @since 0.2
 */
function rolo_get_ID_by_page_title($page_title)
{
        global $wpdb;
        $page_title_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '".$page_title."'");
        return $page_title_id;
}


/**
 * List Taxonomies
 *
 * @param string $page_name Page title
 *
 *
 */
function rolo_list_taxonomies( $args = '' ) {
        $defaults = array(
                'show_option_all' => '', 'show_option_none' => __('No categories'),
                'orderby' => 'name', 'order' => 'ASC',
                'style' => 'list',
                'show_count' => 0, 'hide_empty' => 1,
                'use_desc_for_title' => 1, 'child_of' => 0,
                'feed' => '', 'feed_type' => '',
                'feed_image' => '', 'exclude' => '',
                'exclude_tree' => '', 'current_category' => 0,
                'hierarchical' => true, 'title_li' => __( 'Categories' ),
                'echo' => 1, 'depth' => 0,
                'taxonomy' => 'category',
                'walker' => 'Walker_Category_Checklist_Rolo'
                );

        $r = wp_parse_args( $args, $defaults );

        if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] )
                $r['pad_counts'] = true;

        if ( true == $r['hierarchical'] ) {
                $r['exclude_tree'] = $r['exclude'];
                $r['exclude'] = '';
        }

        if ( !isset( $r['class'] ) )
                $r['class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];

        extract( $r );

        if ( !taxonomy_exists($taxonomy) )
                return false;

        $categories = get_categories( $r );

        $output = '';
        if ( $title_li && 'list' == $style )
                $output = '<li class="' . esc_attr( $class ) . '">' . $title_li . '<ul>';

        if ( empty( $categories ) ) {
                if ( ! empty( $show_option_none ) ) {
                        if ( 'list' == $style )
                                $output .= '<li>' . $show_option_none . '</li>';
                        else
                                $output .= $show_option_none;
                }
        } else {
                if ( ! empty( $show_option_all ) ) {
                        $posts_page = ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
                        $posts_page = esc_url( $posts_page );
                        if ( 'list' == $style )
                                $output .= "<li><a href='$posts_page'>$show_option_all</a></li>";
                        else
                                $output .= "<a href='$posts_page'>$show_option_all</a>";
                }

                if ( empty( $r['current_category'] ) && ( is_category() || is_tax() || is_tag() ) ) {
                        $current_term_object = get_queried_object();
                        if ( $current_term_object && $r['taxonomy'] === $current_term_object->taxonomy )
                                $r['current_category'] = get_queried_object_id();
                }

                if ( $hierarchical ) {
                        $depth = $r['depth'];
                } else {
                        $depth = -1; // Flat.
                }


                $output .= walk_category_tree( $categories, $depth, $r );
        }

        if ( $title_li && 'list' == $style )
                $output .= '</ul></li>';

        $output = apply_filters( 'wp_list_categories', $output, $args );

        if ( $echo )
                echo $output;
        else
                return $output;
}


?>