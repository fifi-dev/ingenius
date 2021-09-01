<?php
$url_ws=$_POST["url_ws"];
$form = json_decode(file_get_contents($url_ws));
$api_call1 = '';
$api_call2 = '';
$lang = 'fr';
if(isset($_POST["api_call1"]) && $_POST["api_call1"] != "" && isset($_POST["api_call2"]) && $_POST["api_call2"] != ""){
	$api_call1 = $_POST["api_call1"];
	$api_call2 = $_POST["api_call2"];
}
if(isset($_POST["lang"])){
	$lang = $_POST["lang"];
}

$reponse['form_type']=$_POST['form_type'];

$fields=$form->fields;

if ($reponse['form_type'] == 'get_educationLevelType'){
	$educationLevel=$_POST['educationLevel'];
	$reponse['options']='<option value="">Sélectionner : Type d\'étude</option>';
	for($f=0 ; $f<count($fields) ; $f++){
		$id=$fields[$f]->id;
		$name=$fields[$f]->name;
		$parent=$fields[$f]->parent;
		if ($name == 'educationLevelType'){
            $values=$fields[$f]->values;
			for($v=0 ; $v<count($values) ; $v++){
				$val_id=$values[$v]->id;
				$val_label=$values[$v]->label;
				$val_parent=$values[$v]->parent;
				$val_preferred=$values[$v]->preferred;
				if ($val_parent == $educationLevel){
					$reponse['options'].='<option value="'.$val_id.'">'.$val_label.'</option>';
				}
			}
		}
	}
}else if ($reponse['form_type'] == 'get_educationLevelSpeciality'){
	$educationLevelType=$_POST['educationLevelType'];
	$reponse['options']='<option value="">Sélectionner : Spécialité d\'étude</option>';
	for($f=0 ; $f<count($fields) ; $f++){
		$id=$fields[$f]->id;
		$name=$fields[$f]->name;
		$parent=$fields[$f]->parent;
		if ($name == 'educationLevelSpeciality'){
            $values=$fields[$f]->values;
			for($v=0 ; $v<count($values) ; $v++){
				$val_id=$values[$v]->id;
				$val_label=$values[$v]->label;
				$val_parent=$values[$v]->parent;
				$val_preferred=$values[$v]->preferred;
				if ($val_parent == $educationLevelType){
					$reponse['options'].='<option value="'.$val_id.'">'.$val_label.'</option>';
				}
			}
		}
	}
}else{
	$reponse['erreurs']=array();
	//Laisser vide pour utiliser le message de remerciement welcome
	$reponse['message']='';
	$data=array();
	for($f=0 ; $f<count($fields) ; $f++){
		$id=$fields[$f]->id;
		$name=$fields[$f]->name;
		$type=$fields[$f]->type;
		$label=$fields[$f]->label;
		$contraint=$fields[$f]->contraint;
		$required=$fields[$f]->required;
		$parent=$fields[$f]->parent;

		if ($required){
			if (strlen($_POST[$name]) < 1 ){
				$reponse['erreurs'][] = $name;
			}else{
				if ($name == 'email'){
					if (!filter_var($_POST[$name], FILTER_VALIDATE_EMAIL)){ $reponse['erreurs'][] = 'email'; }
				}
				// traiter contraintes
			}
		}
		$data[$name]=$_POST[$name];
	}
	
	
	if (count($reponse['erreurs']) < 1){
		// Method: POST, PUT, GET etc
		// Data: array("param" => "value") ==> index.php?param=value

		function CallAPI($method, $url, $data = false){
		    $curl = curl_init();

		    switch ($method){
		        case "POST":
		            curl_setopt($curl, CURLOPT_POST, 1);

		            if ($data)
		                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		            break;
		        case "PUT":
		            curl_setopt($curl, CURLOPT_PUT, 1);
		            break;
		        default:
		            if ($data)
		                $url = sprintf("%s?%s", $url, http_build_query($data));
		    }

		    // Optional Authentication:
		    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		    $result = curl_exec($curl);

		    curl_close($curl);

		    return $result;
		}
		
		if($api_call1 != '' && $api_call2 != ''){
			$api_call1_full = "https://".$api_call1."/inseecu/".$lang."/api/form/full/demande-documentation";
			$api_call2_full = "https://".$api_call2."/inseecu/".$lang."/api/form/full/demande-documentation";
			$api_call1 = "https://".$api_call1."/inseecu/".$lang."/api/form/demande-documentation";
			$api_call2 = "https://".$api_call2."/inseecu/".$lang."/api/form/demande-documentation";
			
			$values_bachelor = array();
			$values_master = array();
			
			$admissionLevel = array();
			$reponse_api=json_decode(CallAPI('GET', $api_call1, $data));
			$fields = $reponse_api->fields;
			
			foreach($fields as $field){
				foreach($field->values as $v){
					if($field->name == "admissionLevel"){
						array_push($admissionLevel,$v);
					}
					if(!isset($values_bachelor[$field->name])){
						$values_bachelor[$field->name] = array();
					}
					array_push($values_bachelor[$field->name],$v);
					
				}
			}
			
			$reponse_api=json_decode(CallAPI('GET', $api_call2, $data));
			$fields = $reponse_api->fields;
			
			foreach($fields as $field){
				foreach($field->values as $v){
					if($field->name == "admissionLevel"){
						array_push($admissionLevel,$v);
					}
					if(!isset($values_master[$field->name])){
						$values_master[$field->name] = array();
					}
					array_push($values_master[$field->name],$v);
				}
			}
			
			$currentAdmissionLevel = $_POST["admissionLevel"];
			$labelAdmission = "";
			foreach($admissionLevel as $adlvl){
				if($adlvl->id == $currentAdmissionLevel){
					$labelAdmission = $adlvl->label;
				}
			}
			
			if(strpos($labelAdmission,"Bachelor") !== false){
				foreach($data as $keyData => $d){
					if(isset($values_master[$keyData])){
						foreach($values_master[$keyData] as $vm){
							if($vm->id == $d){
								$saveTmpLabel = $vm->label;
								foreach($values_bachelor[$keyData] as $vb){
									if($vb->label == $saveTmpLabel){
										$data[$keyData] = $vb->id;
									}
								}
							}
						}
					}
				}
				$reponse_api=json_decode(CallAPI('POST', $api_call1_full, $data));
			}else{
				
				foreach($data as $keyData => $d){
					if(isset($values_bachelor[$keyData])){
						foreach($values_bachelor[$keyData] as $vm){
							if($vm->id == $d){
								$saveTmpLabel = $vm->label;
								foreach($values_master[$keyData] as $vb){
									if($vb->label == $saveTmpLabel){
										$data[$keyData] = $vb->id;
									}
								}
							}
						}
					}
				}
				
				$reponse_api=json_decode(CallAPI('POST', $api_call2_full, $data));
			}
		}else{
			$reponse_api=json_decode(CallAPI('POST', $url_ws, $data));
		}
		
		//var_dump($data);die;
		$reponse['success'] = $reponse_api->success;
		if ($reponse['message'] == ''){
			$reponse['message']=$reponse_api->message;
		}

		$reponse['tag']=$reponse_api->tag;
	}
	//print_r($reponse);
}

echo json_encode($reponse);