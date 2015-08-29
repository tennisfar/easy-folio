<?php # https://github.com/mikelothar/show-all-images-in-a-folder-with-php

$sortByImageName = true;
$newestImagesFirst = false;

$imageFolder = 'img/';
$imageTypes = '{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF}';
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

<?php include 'header.php'; ?>

<html>
	<div class="container">
		<?php
		foreach ($sortedImages as $image) {
		    $image_properties = getimagesize($image, $info);      
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
			
			if (!file_exists("t_" . $imageFolder)) mkdir("t_" . $imageFolder);
			$path_image = pathinfo($image);
			$fname_image = $path_image['filename'];
			if (!file_exists("t_" . $imageFolder . "t_" . $fname_image . '.jpg')) {
				$image_properties = getimagesize($image);
				$width = $image_properties[0];
				$height = $image_properties[1];
				$image_ratio = $width / $height;
				$thumb_width = 400;
				$thumb_height = round($thumb_width / $image_ratio);
				$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
				$temp_image = imagecreatefromjpeg($image);
				imagecopyresampled($thumb, $temp_image, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
				imagejpeg($thumb, "t_" . $imageFolder . "t_" . $fname_image . '.jpg', 50);
				imagedestroy($thumb);
				imagedestroy($temp_image);
			}
		
				echo '<div class="thumbnail">';
					echo '<a href="picture.php?image=' . $image . '">';
						echo'<img src="' . "t_" . $imageFolder . "t_" . $fname_image . '.jpg' . '" alt="' . $caption . '" title="' . $caption . '">';
					echo '</a>';
					echo '<div class="thumbnail-description">';
						// echo $caption;
						// echo '<br>File ref: ' . $image . ' / ' . $datetaken ;
					echo '</div>';
				echo '</div>';
		}
		?>
	</div>
</div>

</body>
</html>
