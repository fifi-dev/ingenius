<?php
/*
Plugin Name: Welcome Plugin
Description: Integration Formulaire Welcome
Version: 1.0
Author: Romain Q.
*/
include ('integration.php');

class Welcome_Plugin
{
    public function __construct()
    {
		add_action( 'init',array( &$this, 'loadModule' ) );
    }
	
	public function loadModule(){
		
		add_action('wp_enqueue_scripts', array(&$this,'form_assets'));
        add_shortcode('welcome-form',array(&$this,'shortcode_form_welcome'));
	}

    public function form_assets()
    {
		$plugin_url = plugin_dir_url( __FILE__ );

        wp_enqueue_style('welcomecss', $plugin_url.'css/style_welcome.css');
        wp_enqueue_script('sha256js', $plugin_url.'js/jssha256.js');
        wp_enqueue_script('welcomejs', $plugin_url.'js/main_welcome.js', array('jquery'), '1.0', true);
        wp_localize_script( 'welcomejs', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
    }


    public function shortcode_form_welcome($atts)
    {
        extract(shortcode_atts(
            array(
                'domaine' => '',
                'form' => '',
				'btnTextColor' => '',
				'btnBackColor' => '',
				'lang' => ''
            ), $atts));

        $params = array(
            'type' => $form,
            'domaine' => $domaine,
            'nb_colonnes' => 1,
            'couleur_1' => '4c4c4c',
            'couleur_2' => '00737b',
			'lang' => 'fr'
        );
		
		if(isset($atts["btntextcolor"]) && $atts["btntextcolor"] )
			$params["btnTextColor"] = $atts["btntextcolor"];
			
			
       if(isset($atts["btnbackcolor"]) && $atts["btnbackcolor"] )
            $params["btnBackColor"] = $atts["btnbackcolor"];

        if(isset($atts["lang"]) && $atts["lang"] )
			$params["lang"] = $atts["lang"];

		$plugin_url = plugin_dir_url( __FILE__ );


		if(file_exists($plugin_url.'css/custom/'.$domaine.'.css') && file_get_contents($plugin_url.'css/custom/'.$domaine.'.css') != false){
			wp_enqueue_style('customwelcomecss', $plugin_url.'css/custom/'.$domaine.'.css');
		}
        $post = get_post();
        $post_id = $post->ID;

        $ecole_id = get_post_meta($post_id,"ecole-programme");
        $ecole_id = $ecole_id[0];
        if(isset($ecole_id) && is_numeric($ecole_id)){
            $params["url_brochure"] = get_post_meta($ecole_id,"url-brochure")[0];
            $params["url-api"] = get_post_meta($ecole_id,"url-api")[0];
        }
        if(isset($params["url_brochure"]) &&  $params["url_brochure"] != "" && isset($params["url-api"]) &&  $params["url-api"] != "") {
            return formulaire_demande_entrante($params);
        }else{
            $ecoles = get_posts(array("post_type"=>"ecoles","numberposts"=>-1));
            $contentform = '<style>.formulaire_welcome{padding:0 !important;}</style>';
            $contentform .= '<section><form><select id="select-ecole" style="width:100%">';
            $contentform .= '<option value="">Sélectionner l\'école</option>';

            foreach($ecoles as $ecole){
                $ecole_id =  $ecole->ID;
                //$brochure = get_post_meta($ecole_id,"url-brochure")[0];
                $api = get_post_meta($ecole_id,"url-api")[0];
                //echo $brochure." ".$api."<br/><br/>";
                if(/*isset($brochure) && !empty($brochure) && */isset($api) && !empty($api) && /*$brochure != "" &&*/ $api != "") {
                    $contentform .= '<option value="' . $ecole_id . '">' . $ecole->post_title . '</option>';
                }
            }

            $contentform .= '</select></form></section>';
           // $contentform .= '<input type="hidden" id="ajax-url" value="'. admin_url('admin-ajax.php') .'">';
            $contentform .= '<div id="response-form" style="margin-top:10px;"></div>';

            return $contentform;
        }
    }
	
	function getIp(){
		/*if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}*/
		$ip = $_SERVER['REMOTE_ADDR'];
		return $ip;
	}

}

if( class_exists( 'Welcome_Plugin' ) )
    $welcome_Plugin = new Welcome_Plugin();