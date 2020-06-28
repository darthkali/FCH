<?php
namespace FCH;

// controller for all UserActions
class UserController extends Controller{

    public function actionUsers(){
        //Title from the Page
        $this->_params['title'] = 'Mitglieder und Spieler';

        //Filter Settings
        $filterFunction = '';
        $filterSort = 'ORDER BY FUNCTION_FCH_ID';
        $this->_params['valueFilter'] = 0;
        $this->_params['valueSort'] = 1;

        // check if the User has selected a Filter. Otherwise go on with the standard Filter
        if(isset($_POST['functionFCHUser']) && $_POST['functionFCHUser'] != 0){
            $filterFunction = ' and FUNCTION_FCH_ID = '. $_POST['functionFCHUser'];
            $this->_params['valueFilter'] = $_POST['functionFCHUser'];
        }

        //Generate the ORDER BY Clause for the Database
        if(isset($_POST['sortByUser'])){
            $filterSort = User::generateSortClauseForUserPage($_POST['sortByUser']);
            $this->_params['valueSort'] = $_POST['sortByUser'];
        }

        //Generate theUserList because of the generatet Sort and Filter Options
        $userList = User::find('END_DATE is null' . $filterFunction, 'getUserMemberHistory', $filterSort);

        $this->_params['userList'] = $userList;
        $this->_params['allFunctions'] = Function_FCH::find();
    }

    public function actionLogin(){
        //Title from the Page
        $this->_params['title'] = 'Login';

        $this->_params['errorMessage'] = 'Nutzername oder Passwort sind nicht korrekt!';
        $error = false;

        //Check the Login status from the User
        if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false){
            //check the E-Mail and Password
            if (isset($_POST['submitLogin']) && isset($_POST['email']) && isset($_POST['password'])) {
                $user = User::findUserByLoginDataFromPost() ?? null;
                //if there is an User than the Session will start and an cookie will be created
                if($user){
                    User::writeLoginDataToActiveSession(true, $user['ID']);
                    $cookieData = array("userId"=>$user['ID'], "password"=>$user['PASSWORD']);
                    isset($_POST['rememberMe']) ? User::createLongLifeCookie($cookieData): null;
                    sendHeaderByControllerAndAction('user', 'profil');
                }else{
                    $error = true;
                    User::writeLoginDataToActiveSession(false);
                }
            }
        }else{
            sendHeaderByControllerAndAction('pages', 'error');
        }
        $this->_params['errorValid'] = $error;
    }

    public function actionLogOut(){
        //cleanup because of the Login
        setcookie('userId','',-1,'/');
        setcookie('password','',-1,'/');
        setcookie('colorMode','',-1,'/');
        session_destroy();
        sendHeaderByControllerAndAction('pages', 'Start');
        exit(0);
    }

    public function actionUserManagement(){
        //Permissions for the page
        $accessUser = role::ADMIN;    // which user(role_id) has permission to join the page
        User::checkUserPermissionForPage($accessUser);

        //Title from the Page
        $this->_params['title'] = 'Nutzerverwaltung';

        //Sort Settings
        $sortMember             = 'ORDER BY FIRSTNAME';
        $sortUser               = 'ORDER BY FIRSTNAME';

        //If the user has select a sort in the Table than we generate a new ORDER BY for the Database
        //User Table
        if(isset($_GET['sortMember'])) {
            $sortMember = User::generateSortClauseForMember($_GET['sortMember']);
        }

        //Member Table
        if(isset($_GET['sortUser'])){
            $sortUser = User::generateSortClauseForUser($_GET['sortUser']);
        }

        //Generate the UserLists for the Users and Members
        $this->_params['accountsMember'] = User::find('ROLE_ID <> ' . role::USER . ' AND END_DATE is null', 'getUserMemberHistory', $sortMember);
        $this->_params['accountsUser'] = User::find('ROLE_ID = ' . role::USER, null, $sortUser);

        //when we generate a GET-Request from the DeleteQuestion Page, than we delete the User with the following ID
        if(isset($_GET['userId'])){
            MemberHistory::deleteWhere('MEMBER_ID = '.$_GET['userId']);
            User::deleteWhere('ID = '.$_GET['userId']);
            sendHeaderByControllerAndAction('user', 'userManagement');
        }
    }

    public function actionProfil(){

        if (!isset($_SESSION['userId'])){
            sendHeaderByControllerAndAction('pages', 'errorPage');
        }

        // generate Informations about the User
        //
        // decide the Informations based on 2 points:
        // the admin will change a user profil
        // or
        // a user (also the admin) will change his own profil
        $userProfilInformations = User::generateUserProfilInformations();

        $this->_params['userRole']          = $userProfilInformations['userRole'];
        $this->_params['userInformation']   = $userProfilInformations['userInformation'];
        $this->_params['title']             = $userProfilInformations['title'];
        $this->_params['colorModeChecked']  = $userProfilInformations['colorModeChecked'];
        $this->_params['userProfil']        = $userProfilInformations['userProfil'];
        $this->_params['errorMessage']      = $userProfilInformations['errorMessage'];
        $this->_params['userFunction']      = $userProfilInformations['userFunction'];
        $this->_params['allRoles']          = $userProfilInformations['allRoles'];
        $this->_params['allFunctions']      = $userProfilInformations['allFunctions'];
        $this->_params['pageTopic']         = $userProfilInformations['pageTopic'];
        $this->_params['pageSubTopic']      = $userProfilInformations['pageSubTopic'];
        $this->_params['errorMessagePassword'] = '';

        // if the user was not found, than we go to the error page.
        // so we can ensure, that the user will be found by the system and not by an edit (e.g.: in the URL) from outside
        if($this->_params['userProfil'] == null){sendHeaderByControllerAndAction('pages', 'errorPage');}

        // Permissions for the page
        // if the role from the session is not equal to one of the roles from the accessUser, then we go to the errorPage
        User::checkUserPermissionForPage($userProfilInformations['accessUser']);

        // changes from the User
        if (isset($_POST['submitProfil'])) {

            //Parameter for the Database
            $params = [
                'ID'               => ( $userProfilInformations['userProfil']['ID'] === '')  ? null : $userProfilInformations['userProfil']['ID'],
                'FIRSTNAME'        => ( $_POST['firstnameProfil']   === '')  ? null : $_POST['firstnameProfil'],
                'LASTNAME'         => ( $_POST['lastnameProfil']    === '')  ? null : $_POST['lastnameProfil'],
                'DATE_OF_BIRTH'    => ( $_POST['dateOfBirthProfil'] === '')  ? null : $_POST['dateOfBirthProfil'],
                'EMAIL'            => ( $_POST['emailProfil']       === '')  ? null : $_POST['emailProfil'],
                'PICTURE'          => null,
                'DESCRIPTION'      => null,
                'PASSWORD'         => null
            ];

            $pictureName = null;
            // generate a Filename and replace the old File(Picture) with the new one
            if(($userProfilInformations['userRole'] == Role::ADMIN or $userProfilInformations['userRole'] == Role::MEMBER)){
                if($_FILES['pictureProfil']['name'] != null) {
                    $pictureName = User::createUploadedPictureName('pictureProfil');
                    $params['PICTURE'] = $pictureName;
                }
                $params['DESCRIPTION' ] = ( $_POST['descriptionProfil'] === '')  ? null : $_POST['descriptionProfil'];
            }

            if(isset($_POST['passwordProfil'])){
                $params['PASSWORD' ] = ( $_POST['passwordProfil'] === '')  ? null : $_POST['passwordProfil'];
            }

            $newUser = new User($params);

            //Validation from the Input
            $eingabeError = [];
            if(!User::validateUser($newUser, $eingabeError)){
                $this->_params['eingabeError'] = $eingabeError;
                return false;
            }

            // Put New Image on the Server
            if(!is_null($pictureName)){
                User::putTheUploadedFileOnTheServerAndRemoveTheOldOne('pictureProfil', 'assets/images/upload/users/' , $userProfilInformations['userProfil']['PICTURE'], $pictureName);
            }

            // generate passwordHash and overwrite the clear password
            if(isset($_POST['changePasswordCheckbox'])){
                if(!User::checkPassword($_POST['passwordProfil'], $this->_params['errorMessagePassword'])){return false;}
                $newUser->__set('PASSWORD', User::generatePasswordHash($_POST['passwordProfil']));
             }

            //check that the Email doesnt exists
            if (User::checkUniqueUserEntityAndReturnID($params['EMAIL']) == $userProfilInformations['userProfil']['ID'] || User::checkUniqueUserEntityAndReturnID($params['EMAIL']) == null) {

                $newUser->save();

                $where = 'ID = ' . $_SESSION['userId'];
                $userAdmin = User::findOne($where);

                //Check which Role and Function the User has had and in which this has to be changed
                if ($userAdmin['ROLE_ID'] == Role::ADMIN) {
                    if(isset($_GET['userId'])) {
                        User::changeUserRoleAndFunction($userProfilInformations['userProfil']['ID'], $_POST['roleProfil'], $_POST['functionClubProfil']);
                    }else{
                        User::changeUserRoleAndFunction($userProfilInformations['userProfil']['ID'], $userAdmin['ROLE_ID'], $_POST['functionClubProfil']);
                    }
                }

                // check if the darkMode is enabled and create the cookie if its necessary
                if (!isset($_GET['userId'])) {
                    if (isset($_POST['colorCheckbox'])) {
                        $colorModeData = array("colorMode" => true);
                        User::createLongLifeCookie($colorModeData);
                    } else {
                        if (isset($_COOKIE['colorMode'])) {
                            $colorModeData = array("colorMode" => false);
                            User::createLongLifeCookie($colorModeData);
                        }
                    }
                }

                // based on the incoming action: send the user to his main page (Profil, UserManagemant)
                sendHeaderByControllerAndAction('user', $userProfilInformations['action']);

            } else {
                $this->_params['errorMessage'] = "Diese E-Mail wurde schon einmal verwendet. Bitte wählen Sie eine andere!";
            }
        }
    }

    public function actionRegistration(){
        //Title from the Page
        $this->_params['title'] = 'Registrieren';

        $this->_params['errorMessage'] = '';
        $this->_params['errorMessagePassword'] = '';

        if (isset($_POST['submitRegistration'])) {

            //Parameter for the Database
            $params = [
                'FIRSTNAME'        => ( $_POST['firstnameRegistration']   === '')  ? null : $_POST['firstnameRegistration']  ,
                'LASTNAME'         => ( $_POST['lastnameRegistration']    === '')  ? null : $_POST['lastnameRegistration']   ,
                'DATE_OF_BIRTH'    => ( $_POST['dateOfBirthRegistration'] === '')  ? null : $_POST['dateOfBirthRegistration'],
                'EMAIL'            => ( $_POST['emailRegistration']       === '')  ? null : $_POST['emailRegistration']      ,
                'PASSWORD'         => ( $_POST['passwordRegistration']    === '')  ? null : $_POST['passwordRegistration'],
                'ROLE_ID'          => Role::USER
            ];

            $newUser = new User($params);

            //check that the Email doesnt exists
            if (User::checkUniqueUserEntityAndReturnID($params['EMAIL']) === null) {

                // validation from the inputFields
                $eingabeError = [];
                if(!User::validateUser($newUser, $eingabeError)){
                    $this->_params['eingabeError'] = $eingabeError;
                    return false;
                }

                // check that the Password is valid and generate a password Hash with salt and pepper
                if(!User::checkPassword($_POST['passwordRegistration'], $this->_params['errorMessagePassword'])){return false;}
                $newUser->__set('PASSWORD', User::generatePasswordHash($_POST['passwordRegistration']));
                $newUser->save();

                sendHeaderByControllerAndAction('user', 'login');

            } else {
                $this->_params['errorMessage'] = "Diese E-Mail wurde schon einmal verwendet. Bitte wählen Sie eine andere!";
            }
        }
    }
}