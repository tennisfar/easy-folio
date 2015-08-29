<?php # https://github.com/mikelothar/show-all-images-in-a-folder-with-php

$sortByImageName = true;
$newestImagesFirst = false;

$imageFolder = 'img/';
$imageTypes = '{*.jpg,*.JPG,*.jpeg,*.JPEG}';
$images = glob($imageFolder . $imageTypes, GLOB_BRACE);
$count = count($images);

if ($sortByImageName) {
    $sortedImages = $images;
    natsort($sortedImages);
} else {
    $sortedImages = array();
    $count = count($images);
    for ($i = 0; $i < $count; $i++) {
        $sortedImages[date('YmdHis', filemtime($images[$i])) . $i] = $images[$i];
    }
    if ($newestImagesFirst) {
        krsort($sortedImages);
    } else {
        ksort($sortedImages);
    }
}
?>

<?php
	$image = $_GET['image'];
	$size = getimagesize($image, $info);
    
	if(isset($image['APP13'])) {
		$iptc = iptcparse($info["APP13"]);
		if (is_array($iptc)) {
			$headline = $iptc['2#105'][0];
				$headline = iconv('macintosh', 'UTF-8', $headline);
			$caption = $iptc["2#120"][0];
				$caption = iconv('macintosh', 'UTF-8', $caption);
			$time = $iptc['2#055'][0];
			$year = substr($time, 0, 4);
			$month = substr($time, 4, 2);
			$day = substr($time, -2);
			$datetaken = date('d-m-Y', mktime(0, 0, 0, $month, $day, $year));
			$city = $iptc["2#090"][0];
			$country = $iptc["2#101"][0];
			$creator = $iptc["2#080"][0];
		}
	}
?>

<?php include 'header.php'; ?>

<html>
	<div class="container">
		<div class="single-pic">
			<img src="<?php echo $image; ?>">
		</div>
		<div class="thumbnail-description">
			<?php echo $caption ?>
<!-- 
			<?php echo '<br>File ref: ' . $image . ' / ' . $datetaken; ?>
 -->
		</div>
		<div class="gallery-navigation">
			<?php
				$current_image_pos = array_search($image, $sortedImages);
				if (!$current_image_pos == 0) {
					echo '<a href="picture.php?image=' . $sortedImages[($current_image_pos-1)] . '">' . 'Previous – ' . '</a>';				
				}
				echo '<a href="index.php">Index</a>';	
				if (!($current_image_pos == ($count-1))) {
					echo '<a href="picture.php?image=' . $sortedImages[($current_image_pos+1)] . '">' . ' – Next' . '</a>';
				}
			?>
		</div>
	</div>
</div>
</body>
</html>
