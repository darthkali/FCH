<?php
namespace FCH;

// controller for all PageActions
class PagesController extends Controller{

    public function actionStart(){
        //Title from the Page
        $this->_params['title'] = 'Startseite';
    }

    public function actionAboutUs(){
        //Title from the Page
        $this->_params['title'] = 'Unser Team';
    }

    public function actionContact(){
        //Title from the Page
        $this->_params['title'] = 'Kontakt';

        if (isset($_POST['sendMail'])) {

            //Parameter for the Database
            $params = [
                'NAME'      => ($_POST['name']      === '') ? null : $_POST['name'],
                'EMAIL'     => ($_POST['mail']      === '') ? null : $_POST['mail'],
                'SUBJECT'   => ($_POST['subject']   === '') ? null : $_POST['subject'],
                'TEXT'      => ($_POST['text']      === '') ? null : $_POST['text']
            ];

            $newContact = new Contact($params);


            $eingabeError = []; // validation from the inputFields
            if(!Contact::validateContact($newContact, $eingabeError)){
                $this->_params['eingabeError'] = $eingabeError;
                return false;
            }

            // Settings for the Mail Client
            $header = array();
            $header[] = "MIME-Version: 1.0";
            $header[] = "Content-type: text/plain; charset=utf-8";
            $header[] = "From: FCH-Kontaktformular <fchformular@test.de>";
            $header[] = "Reply-To: " . $_POST['mail'];
            $msg = "Gesendet am: " . date("d.m.Y H:i:s") . "\r\nGesendet von: " . $_POST['name'] . " <" . $_POST['mail'] . ">\r\n\r\n" . $_POST['text'];

            //TODO: Kann erst genutzt werden, wenn der Mailserver eingerichtet ist
            //mail("testMail@test.de", utf8_decode($_POST['subject']), $msg, implode("\r\n", $header));
            sendHeaderByControllerAndAction('pages', 'start');
        }
    }

    public function actionImprint(){
        //Title from the Page
        $this->_params['title'] = 'Impressum';
    }

    public function actionDataprotection(){
        //Title from the Page
        $this->_params['title'] = 'Datenschutz';
    }

    public function actionErrorPage(){
        //Title from the Page
        $this->_params['title'] = 'Fehler';
    }

    public function actionDeleteQuestion(){

        //Permissions for the page
        $accessUser = Role::ADMIN;    // which user(role_id) has permission to join the page

        //Title from the Page
        $this->_params['title'] = 'Nutzer löschen?';
        $user = User::findOne('ID = ' . $_GET['userId']);
        $this->_params['Name'] = User::getFullName($user['FIRSTNAME'], $user['LASTNAME']);
        $this->_params['hrefTarget'] = '?c=user&a=userManagement';
        $this->_params['hrefDelete'] = '&userId=' . $_GET['userId'];

        User::checkUserPermissionForPage($accessUser);
    }
}