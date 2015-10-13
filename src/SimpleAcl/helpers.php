<?php

if (! function_exists('access')) {
	function access()
	{
		return new SimpleAcl\SimpleAcl;
	}
}