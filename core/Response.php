<?php


namespace core;


class Response
{
	const TYPE_JSON = 'application/json';

	public static function setContantType($type): void
	{
		header('content-type: ' . $type);
	}

}