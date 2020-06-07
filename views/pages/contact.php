<div class="SitePicture" id="fadeInImg">
    <img class="center" src="<?=PAGE_IMAGE_PATH.'mail.jpg'?>" alt = "Roter Postkasten">
</div>
<div class="Content" id="fadeIn">
    <form autocomplete="off" action="?c=pages&a=Contact" method="post" id="formContact">
        <h1>Kontakt</h1>

        <div class="error" style="display: <?=isset($eingabeError)?'':'none'?>;" id="error">
                <?foreach($eingabeError as $error) :?>
                    <?=$error?><br>
                <?endforeach;?>
            </div>


        <!-- name -->
        <div class="input">
            <label for="name">NAME</label>
            <input type = "text" id="name" name="name" placeholder="Vor- und Nachname" required
                   value = "<?=isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''?>">
            <span class="error-message" id="errorName"></span>
        </div>

        <!-- email -->
        <div class="input">
            <label for="mail">EMAIL</label>
            <input type = "email" id="mail" name="mail" placeholder="Ihre E-Mail-Adresse" required
                   value = "<?=isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : ''?>">
            <span class="error-message" id="errorMail"></span>
        </div>

        <!-- subject -->
        <div class="input">
            <label for="subject">BETREFF</label>
            <input type = "text" id="subject" name="subject" placeholder="Betreff" required
                   value = "<?=isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''?>">
            <span class="error-message" id="errorSubject"></span>
        </div>

        <!-- text -->
        <div class="input">
            <label for="text">DEIN ANLIEGEN</label>
            <textarea type = "textarea" id="text" name="text" required placeholder="Dein Anliegen"><?=isset($_POST['text']) ? htmlspecialchars($_POST['text']) : ''?></textarea>
            <span class="error-message" id="errorText"></span>
        </div>
        <!-- button -->
        <button type="submit" name="sendMail" id="sendMail">Abschicken <i class="far fa-paper-plane" aria-hidden="true"></i></button>
        <button type="reset">Löschen <i class="fa fa-times" aria-hidden="true"></i></button>
    </form>
</div>

