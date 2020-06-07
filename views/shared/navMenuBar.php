<?php
use FCH\role;
use FCH\User;
?>
<nav>
    <input type="checkbox" id="responsive-nav">
    <label for="responsive-nav" class="responsive-nav-label">&#9776;</label>
    <div class="navfloat">
        <a href="<?=$_SERVER['SCRIPT_NAME']?>/?c=pages&a=aboutUs"><i class="fas fa-info-circle" aria-hidden="true"></i>  Über uns</a>
        <a href="<?=$_SERVER['SCRIPT_NAME']?>/?c=pages&a=contact"><i class="far fa-address-card" aria-hidden="true"></i> Kontakt</a>
        <a href="<?=$_SERVER['SCRIPT_NAME']?>/?c=user&a=users"><i class="fas fa-users" aria-hidden="true"></i> Mitglieder und Spieler</a>

        <div class="dropdown">
            <button class="dropbtn"><i class="fa fa-user" aria-hidden="true"></i>
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <? if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false){?>
                    <a href="<?=$_SERVER['SCRIPT_NAME']?>/?c=user&a=login"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> Login</a>
                    <a href="<?=$_SERVER['SCRIPT_NAME']?>/?c=user&a=registration"><i class="fas fa-pencil-alt" aria-hidden="true"></i> Registrieren</a>
                <? } else {
                    $user = User::findUserBySessionUserID();
                    $roleID = $user['ROLE_ID'];
                    ?>
                    <a href="<?=$_SERVER['SCRIPT_NAME']?>/?c=user&a=profil"> <i class="fas fa-user" aria-hidden="true"></i> Profil</a>

                    <?if($roleID == role::ADMIN){?>
                        <a href="<?=$_SERVER['SCRIPT_NAME']?>/?c=user&a=userManagement"> <i class="fas fa-users" aria-hidden="true"></i> Nutzerverwaltung</a>
                    <?}?>
                    <a href="<?=$_SERVER['SCRIPT_NAME']?>/?c=user&a=logOut"> <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Abmelden</a>
                <?}?>
            </div>
        </div>
    </div>
</nav>

<div class="NavContent">
    <a href="<?=$_SERVER['SCRIPT_NAME']?>/?c=pages&a=start">
        <img src=<?=PAGE_IMAGE_PATH.'FCH_Logo_klein_trans.png'?> alt = "Logo des FC Hannover">
        <h4>FC Hannover</h4>
    </a>
</div>
