<?php
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

?>