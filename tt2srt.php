<?
date_default_timezone_set("UTC");

if( !isset($argv[2]) ) die("You must set two parameters\n");
if( !file_exists($argv[1]) ) die("Input file is not exist\n");

$input = $argv[1];
$output = $argv[2];

$dane = file_get_contents($input);
$daneout = '';

preg_match_all('/t="([0-9]+)"\s+d="([0-9]+)"\s*\>([^<]+)?<\/p/ims', $dane, $match);

if(isset($match[1])){
	$nr = 1;
	foreach ($match[1] as $mm => $tt){

		$t = $match[1][$mm];
		$d = $match[1][$mm]+$match[2][$mm];
		$str = $match[3][$mm];

		$t1 = (($t/1000) - floor($t/1000))*1000;
		$d1 = (($d/1000) - floor($d/1000))*1000;

		$t1 = sprintf('%03d', $t1);
		$d1 = sprintf('%03d', $d1);

		$daneouttmp = '';
		$daneouttmp .= $nr."\n";
		$daneouttmp .= date("H:i:s",floor($t/1000)).','.$t1.' --> '.date("H:i:s",floor($d/1000)).','.$d1."\n";
		$daneouttmp .= $str."\n";
		$daneouttmp .= "\n";

		//echo $daneouttmp;

		$daneout .= $daneouttmp;
		$nr++;
	}

	file_put_contents($output, $daneout);
	
}
?>