<?php
function formulaire_demande_entrante($params){
    //Gerer l'ordre d'affichage des champs
    $champs=array(
        'ambassador',
        'title',
        'isEnterprise',
        'enterpriseAutocomplete',
        'enterprise',
        'firstName',
        'lastName',
        'email',
        'mobilePhoneNumber',
        'fixedPhoneNumber',
        'address',
        'postalCode',
        'city',
        'country',
        'program',
        'campus',
        'desiredProgram',
        'program',
        'educationLevel',
        'educationLevelType',
        'educationLevelSpeciality',
        'currentEstablishmentAutocomplete',
        'currentEstablishment',
        'commentary',
        'admissionLevel',
        'consent',
        'source'
    );
    $champs_actifs=array();
    $contentform = '';
    $lang = "fr";
    if(isset($params["lang"]) && $params["lang"] != ""){
        $lang = $params["lang"];
    }
    $url_ws=$params["url-api"];
    $form = json_decode(file_get_contents($url_ws));
    //print_r($form);
    $content_after_submission=$form->content;
    $tag=$form->tag;
    $fields=$form->fields;

    $fieldToNotDisplay = array(
        "address",
        "fixedPhoneNumber",
        "campus",
        "desiredProgram",
        "program",
        "educationLevelType",
        "educationLevelSpeciality",
        "commentary",
        "source",
    );

    for ($f=0 ; $f<count($fields) ; $f++){
        $name = $fields[$f]->name;
        if(!in_array($name,$fieldToNotDisplay)) {
            $champs_actifs[$name] = $f;
            if ($name == "admissionLevel" && $params['api_call1'] != '' && $params['api_call2']) {
                $fields[$f]->values = getAllAdmissionValues($params['api_call1'], $params['api_call2']);
            }
        }
    }
    if($params['nb_colonnes'] == 2){
        $contentform .= '<style type="text/css">';
        $contentform .= '
            section.formulaire_welcome .block{
                width : 48%;
                margin-left : 1%;
                margin-right : 1%;
            }';
        $contentform .= '</style>';
    }
    if($params['couleur_1'] != ''){
        $contentform .= '<style type="text/css">';
        $contentform .= '
            section.formulaire_welcome{
                color : #'.$params['couleur_1'].';
            }
            section.formulaire_welcome .block input,
            section.formulaire_welcome .block select{
            }';
        $contentform .= '</style>';
    }
    if($params['couleur_2'] != ''){
        $contentform .= '<style type="text/css">';
        $contentform .= '
            section.formulaire_welcome h3,
            section.formulaire_welcome h2,
            section.formulaire_welcome p strong,
            section.formulaire_welcome .cta:hover,
            section.formulaire_welcome p a{
                color : #'.$params['couleur_2'].';
            }
            section.formulaire_welcome .cta{
                background-color: #'.$params['couleur_2'].';
                border: solid 2px #'.$params['couleur_2'].';
            }
            section.formulaire_welcome .block input[type=submit]{
                background-color: #'.$params['couleur_2'].';
            }';
        $contentform .= '</style>';
    }
    if($params['btnTextColor'] != ''){
        $contentform .= '<style type="text/css">';
        $contentform .= '
			#submitWelcome{
				color: '.$params['btnTextColor'].';
			}';
        $contentform .= '</style>';
    }
    if($params['btnBackColor'] != ''){
        $contentform .= '<style type="text/css">';
        $contentform .= '
			#submitWelcome{
				background-color: '.$params['btnBackColor'].';
			}';
        $contentform .= '</style>';
    }
    $plugin_url = plugin_dir_url( __FILE__ );

    $contentform .= '<section class="formulaire_welcome">';
    $contentform .= '<form method="post" name="formulaire_demande_entrante" class="welcome_form" target="'.$plugin_url.'ajax_welcome.php"> ';
    $contentform .= '<input type="hidden" name="url_ws" id="url_ws" value="'.$url_ws.'" />';
    if($params['api_call1'] != '' && $params['api_call2']){
        $contentform .= '<input type="hidden" name="api_call1" id="api_call1" value="'.$params['api_call1'].'" />';
        $contentform .= '<input type="hidden" name="api_call2" id="api_call2" value="'.$params['api_call2'].'" />';
    }

    $contentform .= '<input type="hidden" name="lang" id="lang" value="'.$lang.'" />';

    for ($c=0 ; $c<count($champs) ; $c++){
        if (array_key_exists($champs[$c], $champs_actifs)){
            $f=$champs_actifs[$champs[$c]];
            $id=$fields[$f]->id;
            $name=$fields[$f]->name;
            $type=$fields[$f]->type;
            $label=$fields[$f]->label;
            //  $contraint=$fields[$f]->contraint;
            $required=$fields[$f]->required;
            $parent=$fields[$f]->parent;
            $contentform .= '<div class="block';
            if ($name == 'consent'){
                $contentform .= ' full';
            }
            $contentform .= '"';
            /* masquer des champs  */
            //if ($name=='desiredProgram'){
            //  $contentform .= ' style="display:none;"';
            // }
            $contentform .= '>';

            if ($type == 'select'){
                $contentform .= '<label class="'.$name.'">'.$label.'</label>';
                $contentform .= '<select name="'.$name.'" id="champ_'.$name.'"';

                $contentform .= '>';
                $contentform .= '<option value="" selected>Sélectionner : '.$fields[$f]->label.'</option>';
                $values=$fields[$f]->values;
                for($v=0 ; $v<count($values) ; $v++){
                    $val_id=$values[$v]->id;
                    $val_label=$values[$v]->label;
                    $val_parent=$values[$v]->parent;
                    $val_preferred=$values[$v]->preferred;
                    $contentform .= '<option value="'.$val_id.'"';
                    if (($name == 'country') && ($val_label == 'FRANCE')){
                        $contentform .= ' selected';
                    }
                    else if (($name == 'title') && ($val_label == 'Monsieur')){
                        $contentform .= ' selected';
                    }

                    $contentform .= '>'.$val_label.'</option>';

                }
                $contentform .= '</select>';

            }
            else if (($type == 'text') && ($name == 'postalCode')){
                $contentform .= '<label>'.$label.'</label>';
                $contentform .= '<input type="number" placeholder="'.$label.'" name="'.$name.'" value="" id="champ_'.$name.'" />';
            }
            else if (($type == 'text') && ($name == 'mobilePhoneNumber')){
                $contentform .= '<label>'.$label.'</label>';
                $contentform .= '<input type="tel" placeholder="'.$label.'" name="'.$name.'" value="" id="champ_'.$name.'" />';
            }
            else if ($type == 'text'){
                $contentform .= '<label>'.$label.'</label>';
                $contentform .= '<input type="text" placeholder="'.$label.'" name="'.$name.'" value="" id="champ_'.$name.'" />';
            }
            else if ($type == 'textarea' && ($name=='commentary')){
                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $contentform .= '<input type="hidden" name="'.$name.'" value="LP ECOLE '.$actual_link.'" id="champ_'.$name.'"/>';
            }
            else if ($type == 'email'){
                $contentform .= '<label>'.$label.'</label>';
                $contentform .= '<input type="email" placeholder="'.$label.'" name="'.$name.'" value="" id="champ_'.$name.'" />';
            }
            else if ($type == 'hidden'){
                if ($name == 'source'){
                    $value=$_GET['utm_source'];
                    if ($value == ''){
                        $value='Naturel';
                    }
                }
                $contentform .= '<input type="hidden" name="'.$name.'" value="'.$value.'" id="champ_'.$name.'" />';

            }else if ($type == 'checkbox'){
                $contentform .= '<label><input type="checkbox" name="'.$name.'" id="champ_'.$name.'" />'.$label.'</label>';
            }
            $contentform .= '</div>';
        }
    }
    $plugin_url = plugin_dir_url( __FILE__ );

    $contentform .= '<div class="block full" style="text-align:center;display:none;" id="loaderWelcome"><img src="'.$plugin_url.'img/ajax-loader.gif"/></div>';
    $contentform .= '<div class="block full"><input id="submitWelcome" type="submit" name="submit" value="Envoyer" /></div>';
    $contentform .= '</form>';
    $contentform .= '</section>';

    return $contentform;

}

function getAllAdmissionValues($api_call1,$api_call2){
    $api_call1 = "https://".$api_call1."/inseecu/fr/api/form/demande-documentation";
    $api_call2 = "https://".$api_call2."/inseecu/fr/api/form/demande-documentation";
    $admissionLevel = array();
    $reponse_api=json_decode(file_get_contents($api_call1));
    $fields = $reponse_api->fields;

    foreach($fields as $field){
        if($field->name == "admissionLevel"){
            foreach($field->values as $v){
                array_push($admissionLevel,$v);
            }
        }
    }

    $reponse_api=json_decode(file_get_contents($api_call2));
    $fields = $reponse_api->fields;

    foreach($fields as $field){
        if($field->name == "admissionLevel"){
            foreach($field->values as $v){
                array_push($admissionLevel,$v);
            }
        }
    }

    return $admissionLevel;

}

add_action( 'wp_ajax_load_ecole', 'load_ecole' );
add_action( 'wp_ajax_nopriv_load_ecole', 'load_ecole' );

function load_ecole() {
    $ecole_id = intval( $_POST['ecole_id'] );
    $params = array(
        'nb_colonnes' => 1,
        'couleur_1' => '4c4c4c',
        'couleur_2' => '00737b',
        'lang' => 'fr'
    );
    $params["url-api"] = get_post_meta($ecole_id,"url-api")[0];

    echo formulaire_demande_entrante($params);die;
}

add_action( 'wp_ajax_load_brochure', 'load_brochure' );
add_action( 'wp_ajax_nopriv_load_brochure', 'load_brochure' );

function load_brochure() {
    $ecole_id = intval( $_POST['ecole_id'] );
    $brochure = get_post_meta($ecole_id,"url-brochure")[0];
    if(isset($brochure) && $brochure!="" && is_numeric($brochure)) {
        echo '<p>Merci pour votre demande d\'information</p><br/><h2 class="text-center">Programme Grande école</h2><br/><br/><a class="cta" href="'.wp_get_attachment_url($brochure).'" target="blank">Télécharger la brochure</a>';
        die;
    }
}
