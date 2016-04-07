<?php 

class HTML {
	public  static function anchor($href, $text) {
		return "<a href = '{$href}'>{$text}</a>";
	}

	public static function items($items) {
		return "<ul><li>". implode("</li><li>", $items) . "</li><ul>";
	}

	public static function img($src, $alt) {
		return "<img src = '{$src} alt = '{$alt}'>";
	}

	public static function redirect_to($new_location) {
		header("Location: {$new_location}");
		exit();
	}

	public static function has_presence($value) {
		return isset($value) && $value !== "";
	}

	public static function has_max_length($value, $max) {
		return strlen($value) <= $max;
	}

}

