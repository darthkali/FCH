<?php
namespace FCH;

class PagesController extends Controller{

    public function actionStart(){
        $this->_params['title'] = 'Startseite';
    }

    public function actionAboutUs(){
        $this->_params['title'] = 'Unser Team';
    }

    public function actionContact(){
        $this->_params['title'] = 'Kontakt';

        if (isset($_POST['sendMail'])) {

            $params = [
                'NAME'      => ($_POST['name']      === '') ? null : $_POST['name'],
                'EMAIL'     => ($_POST['mail']      === '') ? null : $_POST['mail'],
                'SUBJECT'   => ($_POST['subject']   === '') ? null : $_POST['subject'],
                'TEXT'      => ($_POST['text']      === '') ? null : $_POST['text']
            ];

            $newContact = new Contact($params);
            // validation from the inputFields
            $eingabeError = [];

            if(!Contact::validateContact($newContact, $eingabeError)){
                $this->_params['eingabeError'] = $eingabeError;
                return false;
            }

            $header = array();
            $header[] = "MIME-Version: 1.0";
            $header[] = "Content-type: text/plain; charset=utf-8";
            $header[] = "From: FCH-Kontaktformular <fchformular@web.de>";
            $header[] = "Reply-To: " . $_POST['mail'];
            $msg = "Gesendet am: " . date("d.m.Y H:i:s") . "\r\nGesendet von: " . $_POST['name'] . " <" . $_POST['mail'] . ">\r\n\r\n" . $_POST['text'];

            //TODO: Kann erst genutzt werden, wenn der Mailserver eingerichtet ist
            //mail("bratwurststinkt@web.de", utf8_decode($_POST['subject']), $msg, implode("\r\n", $header));
            sendHeaderByControllerAndAction('pages', 'start');
        }
    }

    public function actionImprint(){
        $this->_params['title'] = 'Impressum';
    }

    public function actionDataprotection(){
        $this->_params['title'] = 'Datenschutz';
    }

    public function actionErrorPage(){
        $this->_params['title'] = 'Fehler';
    }

    public function actionDeleteQuestion(){

        $this->_params['title'] = 'Registrieren';
        //Permissions for the page

        $accessUser = Role::ADMIN;    // which user(role_id) has permission to join the page

        $this->_params['title'] = 'Wollen Sie den Nutzer:';
        $user = User::findOne('ID = ' . $_GET['userId']);
        $this->_params['Name'] = User::getFullName($user['FIRSTNAME'], $user['LASTNAME']);
        $this->_params['hrefTarget'] = '?c=user&a=userManagement';
        $this->_params['hrefDelete'] = '&userId=' . $_GET['userId'];

        User::checkUserPermissionForPage($accessUser);
    }
}