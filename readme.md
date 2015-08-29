# Easy Folio

'Easy Folio' displays the images in a folder as a web gallery using thumbnails
generated on the fly. The large version of the image is displayed on a 
separate page with embedded IPTC caption data.

Uses code: https://github.com/mikelothar/show-all-images-in-a-folder-with-php

Needs PHP on your server in order for this to work.

Setup
- Website owner info: Modify 'header.php' to set the links as indicated.
- There is no need to modify 'index.php' and 'picture.php'.
- Upload the following files into a folder on your webserver: 
  'index.php' and 'picture.php' and 'header.php' and 'style.css' 
- Make a folder called 'img' in that same folder on the webserver.
- Put your images in .jpg-format in the 'img' folder. Recommended width is 1280px.
- The IPTC data from your photos is read, so caption your photos before upload.
  Captioning using IPTC info can be done with most photo software 
  (e.g. 'Photo Mechanic' by http://www.camerabits.com, or Adobe's PhotoShop or Lightroom).
  The current version of 'Easy Folio' reads the 'caption' and 'headline' IPTC fields.
  

Instructions
- There is nothing more to do.
    
  
Lukas Spieker

Web: http://www.lukasspieker.com

Twitter: @lukasspieker
