<div class="Content" id="fadeInIndexPage">
    <div class="pictureRaster">
        <div>
                <div class="startContent">
                    <h1>Herzlich Willkommen beim FC Hannover</h1><br>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                        At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor
                        sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et
                        accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<br>
                    </p>
                </div>

            <div class="startLogo">
                <img src=<?=PAGE_IMAGE_PATH.'FCH_Logo_klein_trans.png'?> alt = "Logo des FC Hannover">
            </div>

        </div>
        <hr>
        <ul>
            <?$images = crateDataOfFilesFromDirectory("assets/images/pictureRaster/", 12);?>
<!--            print the pictures which has selected before with the '$rand_keys'-->
            <?foreach($images as $datei) : ?> <!-- Ausgabeschleife-->
                <li><a href="<?=PICTURE_RASTER_PATH.$datei?>" target="_blank"><img src="<?=PICTURE_RASTER_PATH.$datei?>" alt = "Bilder des FC Hannover"
            <?endforeach;?>
        </ul>
    </div>
</div>

