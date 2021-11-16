<?php

namespace App\Support;

class CsvReader
{
	public static function read($filepath, $function)
	{
		$handle = fopen($filepath, 'r');

		if($handle)
		{
			while ($line = fgets($handle))
			{
				$values = str_getcsv($line);
				if(is_callable($function))
				{
					$function($values);
				}
			}
		}

		fclose($handle);
	}
}