<div class="ErrorPage">
    <h1>Ups... Da lief wohl etwas schief!</h1>
    <?$gif = crateDataOfFilesFromDirectory("assets/images/errorGif", 1);?>

    <!--print the pictures which has selected before with the '$rand_keys'-->
    <img class="ErrorImg" src="<?=ERROR_GIF_PATH.$gif?>" alt = "Errormeldung 404">
</div>