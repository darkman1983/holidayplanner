<?php

/**
 * Sets template variables and returns the view model for requested actions
 * 
 * @author Timo Stepputtis
 *
 */
class ErrorModel extends BaseModel
{    
    
    /**
     * Sets the pagetitle and returns the viewModel
     * 
     * @param array $request
     * @return ViewModel
     */
    public function badURL($request)
    {
        $this->viewModel->set("pageTitle","Error - Bad URL");
        
        return $this->viewModel;
    }
    
     /**
     * Sets the pagetitle and returns the viewModel
     * 
     * @param array $request
     * @return ViewModel
     */
    public function badUsername($request)
    {
    	$this->viewModel->set("pageTitle","Error - Bad Username");
    	
    	return $this->viewModel;
    }
    
    /**
     * Sets the pagetitle and returns the viewModel
     *
     * @param array $request
     * @return ViewModel
     */
    public function badPassword($request)
    {
    	$this->viewModel->set("pageTitle","Error - Bad Password");
    	
    	return $this->viewModel;
    }
    
    /**
     * Sets the pagetitle and returns the viewModel
     *
     * @param array $request
     * @return ViewModel
     */
    public function badEmail($request)
    {
    	$this->viewModel->set("pageTitle","Error - Bad Password");
    	$this->viewModel->set("request", $request);
    	
    	return $this->viewModel;
    }
    
    /**
     * Sets the pagetitle and returns the viewModel
     *
     * @param array $request
     * @return ViewModel
     */
    public function badRegData($request)
    {
    	$this->viewModel->set("pageTitle","Error - Bad Password");
    	$this->viewModel->set("request", $request);
    	 
    	return $this->viewModel;
    }
    
    /**
     * Sets the pagetitle and returns the viewModel
     *
     * @param array $request
     * @return ViewModel
     */
    public function notAllowed()
    {
      $this->viewModel->set("pageTitle","Error - Benutzerlevel reicht nicht aus um die Seite anzuzeigen!");
      
      return $this->viewModel;
    }
    
    /**
     * Sets the pagetitle and returns the viewModel
     *
     * @param array $request
     * @return ViewModel
     */
    public function badsession($request)
    {
      $this->viewModel->set("pageTitle","Error - Sitzung abgelaufen!");
      $this->viewModel->set('ajax', $request['ajax']);
    
      return $this->viewModel;
    }
}

?>
