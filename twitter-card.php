<?php function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }
?>

<html>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@twitterusername">
<?php 
	if(isset($headline)) echo '<meta name="twitter:title" content="' . $headline . ' – Sitename">' . "\n"; 
	else echo '<meta name="twitter:title" content="Sitename">' . "\n";
?>
<?php 
	if(isset($caption)) echo '<meta name="twitter:description" content="' . $caption . '">' . "\n"; 
	else echo '<meta name="twitter:description" content="Pictures"' . "\n";
?>
<?php 
	if(isset($image)) echo '<meta name="twitter:image" content="' . base_url() . $image . '">' . "\n"; 
	else echo '<meta name="twitter:image" content="some-fallback-twitter-card-image.jpg">' . "\n";
?>

<meta property="og:title" content="Sitename">
<meta property='og:type' content="website">
<meta property='og:url' content="http://www.yoursite.com/">
<meta property='og:site_name' content="Sitename">
<meta property='og:description' content="Pictures">
</html>
