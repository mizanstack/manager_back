<?php

function ext_type_image_or_other($ext){
	$image_type_array = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
	if(in_array($ext, $image_type_array)){
		return 'image';
	}
	return 'other';
}
function remove_dots($string){
	return str_replace(".", "", $string);
}
function replace_hyphen_with_spaces($string){
	return str_replace(' ', '-', $string);
}
function replace_underscore_with_spaces($string){
	return str_replace(' ', '_', $string);
}

function remove_space_dots_replace_underscore($string){
	$lower_case = strtolower($string);
	$remove_dots = remove_dots($lower_case);
	$remove_space = replace_underscore_with_spaces($remove_dots);
	return $remove_space;
}
function remove_space_dots_replace_hyphen($string){
	$lower_case = strtolower($string);
	$remove_dots = remove_dots($lower_case);
	$remove_space = replace_hyphen_with_spaces($remove_dots);
	return $remove_space;
}

function formated_date($date){
	return \Carbon\Carbon::parse($date)->toFormattedDateString();
}

function removeExt($path)
{
    $basename = basename($path);
    return strpos($basename, '.') === false ? $path : substr($path, 0, - strlen($basename) + strlen(explode('.', $basename)[0]));
}

function takeExt($path){
	// dd($path);
	$array = explode(".", $path);
	return end($array);

}

function add_text_before_ext($text='', $name_with_extention){
	$out = removeExt($name_with_extention) . $text;
	$ext_name = takeExt($name_with_extention);
	$out .=  $ext_name ? '.' . $ext_name : '';
	return $out;
}



?>