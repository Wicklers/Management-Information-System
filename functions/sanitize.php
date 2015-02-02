<?php
function escape($string) {
		return htmlentities(trim($string), ENT_QUOTES, 'UTF-8');
	}
?>