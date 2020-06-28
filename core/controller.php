<?php
namespace FCH;

// main Controller which routes all pages in the correct way
class Controller{
	private $_actionName = null;
	private $_controllerName = null;
	protected $_params = [];

	//constructor for the controller
    public function __construct($actionName = null, $controllerName = null){
		$this->_actionName = lcfirst  ($actionName);
		$this->_controllerName = lcfirst  ($controllerName);
	}

	//generate the index-page
	public function renderHTML(){
		$viewPath = $this->viewPath($this->_controllerName, $this->_actionName);

		if(file_exists($viewPath)){
			extract($this->_params);
			
			$body = '';

			// output buffering
			ob_start();{
				include $viewPath;
			}
			//Get current buffer contents and delete current output buffer
			$body = ob_get_clean();

			if(isset($noLayout) && $noLayout === true) {
				echo $body;
			}else{
				include __DIR__ . '/../views/layout.php';
			}
		}else{
            sendHeaderByControllerAndAction('pages', 'errorPage');
		}
	}

    protected function viewPath($controllerName, $actionName = null){
        return __DIR__ . '/../views/'.$controllerName.'/'.$actionName.'.php';
    }

}