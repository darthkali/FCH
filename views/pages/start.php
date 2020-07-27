<div class="Content" id="fadeInIndexPage">
    <div class="pictureRaster">
        <div>
                <div class="startContent">
                    <h1>Ein Dank an unsere Mitglieder!</h1><br>
                    <h2>Ohne Mitglieder - kein Verein!</h2><br>
                    <p>
                        Liebe Mitglieder, <br><br>
                        wir möchten uns in dieser schwierigen Zeit bei Euch für Eure Treue und Unterstützung bedanken. <br><br>
                        Hätte unser Verein keine Mitglieder mehr, da alle aufgrund der Corona-Pandemie austreten würden, gäbe es den FC Hannover nach 15 Jahren nicht mehr. Wir sind auf Eure Solidarität angewiesen. <br>
                        Nochmals herzlichen Dank dafür!<br>
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

