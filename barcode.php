<?php

/*
 *  Author:  David S. Tufts
 *  Company: Rocketwood.LLC
 *	  www.rocketwood.com
 *  Date:	05/25/2003
 *  Usage:
 *	  <img src="/barcode.php?text=testing" alt="testing" />
 * 
 *  Modified 2014/05/13 to support code128c barcodes
 */
	
	// Get pararameters that are passed in through $_GET or set to the default value
	$text = (isset($_GET["text"])?$_GET["text"]:"0");
	$size = (isset($_GET["size"])?$_GET["size"]:"20");
	$orientation = (isset($_GET["orientation"])?$_GET["orientation"]:"horizontal");
	$code_type = (isset($_GET["codetype"])?$_GET["codetype"]:"code128");
	$code_string = "";

	// Translate the $text into barcode the correct $code_type
	if ( strtolower($code_type) == "code128" ) {
		// Must not change order of array elements as the checksum depends on the array's key to validate final code
		if (is_numeric($text)) {
			$code_c_array = array ( '00' => '212222', '01' => '222122', '02' => '222221', '03' => '121223', '04' => '121322', '05' => '131222', '06' => '122213', '07' => '122312', '08' => '132212', '09' => '221213', 10 => '221312', 11 => '231212', 12 => '112232', 13 => '122132', 14 => '122231', 15 => '113222', 16 => '123122', 17 => '123221', 18 => '223211', 19 => '221132', 20 => '221231', 21 => '213212', 22 => '223112', 23 => '312131', 24 => '311222', 25 => '321122', 26 => '321221', 27 => '312212', 28 => '322112', 29 => '322211', 30 => '212123', 31 => '212321', 32 => '232121', 33 => '111323', 34 => '131123', 35 => '131321', 36 => '112313', 37 => '132113', 38 => '132311', 39 => '211313', 40 => '231113', 41 => '231311', 42 => '112133', 43 => '112331', 44 => '132131', 45 => '113123', 46 => '113321', 47 => '133121', 48 => '313121', 49 => '211331', 50 => '231131', 51 => '213113', 52 => '213311', 53 => '213131', 54 => '311123', 55 => '311321', 56 => '331121', 57 => '312113', 58 => '312311', 59 => '332111', 60 => '314111', 61 => '221411', 62 => '431111', 63 => '111224', 64 => '111422', 65 => '121124', 66 => '121421', 67 => '141122', 68 => '141221', 69 => '112214', 70 => '112412', 71 => '122114', 72 => '122411', 73 => '142112', 74 => '142211', 75 => '241211', 76 => '221114', 77 => '413111', 78 => '241112', 79 => '134111', 80 => '111242', 81 => '121142', 82 => '121241', 83 => '114212', 84 => '124112', 85 => '124211', 86 => '411212', 87 => '421112', 88 => '421211', 89 => '212141', 90 => '214121', 91 => '412121', 92 => '111143', 93 => '111341', 94 => '131141', 95 => '114113', 96 => '114311', 97 => '411113', 98 => '411311', 99 => '113141', 'CODE B' => '114131', 'CODE A' => '311141', 'FNC 1' => '411131', 'Start A' => '211412', 'Start B' => '211214', 'Start C' => '211232', 'Stop' => '2331112' );
			$chksum = 105;
			// Switch to 128C
			$code_keys = array_keys($code_c_array);
			$code_values = array_flip($code_keys);
			
			for ( $X = 2; $X <= strlen($text); $X+=2 ) {
				$activeKey = substr( $text, ($X-2), 2);
				$code_string .= $code_c_array[$activeKey];
				$chksum += $code_values[$activeKey] * ($X/2);
			}
			$code_string .= $code_c_array[$code_keys[($chksum%103)]];
			$code_string = "211232" . $code_string . "2331112";
		} else {
			$code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
			$chksum = 104;
			$code_keys = array_keys($code_array);
			$code_values = array_flip($code_keys);
			for ( $X = 1; $X <= strlen($text); $X++ ) {
				$activeKey = substr( $text, ($X-1), 1);
				$code_string .= $code_array[$activeKey];
				$chksum=($chksum + ($code_values[$activeKey] * $X));
			}
			$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
			$code_string = "211214" . $code_string . "2331112";
		}
	} elseif ( strtolower($code_type) == "code39" ) {
		$code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");

		// Convert to uppercase
		$upper_text = strtoupper($text);

		for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
			$code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
		}

		$code_string = "1211212111" . $code_string . "121121211";
	} elseif ( strtolower($code_type) == "code25" ) {
		$code_array1 = array("1","2","3","4","5","6","7","8","9","0");
		$code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");

		for ( $X = 1; $X <= strlen($text); $X++ ) {
			for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
				if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
					$temp[$X] = $code_array2[$Y];
			}
		}

		for ( $X=1; $X<=strlen($text); $X+=2 ) {
			if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
				$temp1 = explode( "-", $temp[$X] );
				$temp2 = explode( "-", $temp[($X + 1)] );
				for ( $Y = 0; $Y < count($temp1); $Y++ )
					$code_string .= $temp1[$Y] . $temp2[$Y];
			}
		}

		$code_string = "1111" . $code_string . "311";
	} elseif ( strtolower($code_type) == "codabar" ) {
		$code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
		$code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");

		// Convert to uppercase
		$upper_text = strtoupper($text);

		for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
			for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
				if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
					$code_string .= $code_array2[$Y] . "1";
			}
		}
		$code_string = "11221211" . $code_string . "1122121";
	}

	// Pad the edges of the barcode
	$code_length = 20;
	for ( $i=1; $i <= strlen($code_string); $i++ )
		$code_length = $code_length + (integer)(substr($code_string,($i-1),1));

	if ( strtolower($orientation) == "horizontal" ) {
		$img_width = $code_length;
		$img_height = $size;
	} else {
		$img_width = $size;
		$img_height = $code_length;
	}

	$image = imagecreate($img_width, $img_height);
	$black = imagecolorallocate ($image, 0, 0, 0);
	$white = imagecolorallocate ($image, 255, 255, 255);

	imagefill( $image, 0, 0, $white );

	$location = 10;
	for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
		$cur_size = $location + ( substr($code_string, ($position-1), 1) );
		if ( strtolower($orientation) == "horizontal" )
			imagefilledrectangle( $image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black) );
		else
			imagefilledrectangle( $image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black) );
		$location = $cur_size;
	}
	// Draw barcode to the screen
	header ('Content-type: image/png');
	imagepng($image);
	imagedestroy($image);
?>
