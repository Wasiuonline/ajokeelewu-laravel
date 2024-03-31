<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class GeneralHelper{

    const BASIC_HEADER = "hskhbdjhdsbfvbfkjvbdskjbkjdsfbv";
	const APP_CURR = "&#8358;";
	const GEN_NAME = "Ajoke Elewu";

    public static function DetToken($det_token)
    {
        if(self::BASIC_HEADER == $det_token){
            return true;
        }
    }

    public static function DetUser($det_token, $user_id)
    {
        if(self::BASIC_HEADER == $det_token && auth()->user()->id == $user_id){
            return true;
        }
    }

	public static function gen($data)
	{
		switch ($data) {
			case "date":
				return date("Y-m-d", time());
			case "date_time":
				return date("Y-m-d H:i:s", time());
			case "ticket_id":
				return date("YmdHis", time());
			case "trans_ref":
				return "ajo" . time() . rand(100,999) . "ke";
			case "rand_no":
				return rand(1000, 9999);
			case "regards":
				return "<p>&nbsp;</p><p>Regards,<br>" . self::GEN_NAME . " Team.</p>";
		}
	}

    public static function in_table($table, $where, $return)
	{
		$result = (!empty($table)) ? DB::table($table)->where($where)->value($return) : 0;
		return $result;
	}
	public static function in_table_count($table, $where)
	{
		$result = (!empty($table)) ? DB::table($table)->where($where)->get()->count() : 0;
		return $result;
	}

	public static function sub_date($data)
	{
		return date_format(date_create($data), "l F jS, Y");
	}
	public static function min_sub_date($data)
	{
		return date_format(date_create($data), "d/m/Y");
	}
	public static function full_date($data)
	{
		return date_format(date_create($data), "l F jS, Y h:i:s A");
	}
	public static function min_full_date($data)
	{
		return date_format(date_create($data), "d/m/Y h:i:s A");
	}
    public static function break_long($data, $prefix = "", $suffix = "")
	{
		$broken_data = $prefix . wordwrap($data, 15, "<br />", true) . $suffix;
		return $broken_data;
	}
    
    public static function det_all_images($data, $to_url = 0)
	{
		$file_name = array();
		$data = public_path("images/{$data}");
		$file_array = File::glob($data);
		if ($file_array) {
			foreach ($file_array as $value) {
				$temp_name = explode("/", $value);
				$temp_name = array_slice($temp_name, -2, 2, false);
				$file_name[] = $to_url ? URL::to("images/" . implode("/", $temp_name)) : "images/" . implode("/", $temp_name);
			}
			return $file_name;
		}
	}

	public static function det_image($data, $index)
	{
		$file_name = "";
		$data = public_path("images/{$data}");
		$file_array = File::glob($data);
		if ($file_array) {
			$file_array = explode("/", $file_array[$index]);
			$file_array = array_slice($file_array, -2, 2, false);
			$file_name = "images/" . implode("/", $file_array);
		} else {
			$file_name = "images/post.jpg";
		}
		return $file_name;
	}

	public static function decode_content($data){
	return html_entity_decode($data, ENT_QUOTES);
	}
	
	public static function formatPrice($amount){
	$amountOriginal = $amount;
	if($amountOriginal != ""){
	$sign_left = ($amountOriginal < 0)?"(":"";
	$sign_right = ($amountOriginal < 0)?")":"";
	$amountOriginal = $sign_left . number_format(abs($amountOriginal), 2, '.', ',') . $sign_right;
	}
	return $amountOriginal;
	}
	
	public static function formatQty($amount){
	$amountOriginal = $amount;
	if($amountOriginal != ""){
	$amountOriginal = number_format($amountOriginal, 0, '', ',');
	}
	return $amountOriginal;
	}
		

}