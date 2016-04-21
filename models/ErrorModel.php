<?php

class ErrorModel extends BaseModel
{    
    //data passed to the bad URL error view
    public function badURL($request)
    {
        $this->viewModel->set("pageTitle","Error - Bad URL");
        
        return $this->viewModel;
    }
    
    public function badUsername($request)
    {
    	$this->viewModel->set("pageTitle","Error - Bad Username");
    	
    	return $this->viewModel;
    }
    
    public function badPassword($request)
    {
    	$this->viewModel->set("pageTitle","Error - Bad Password");
    	
    	return $this->viewModel;
    }
    
    public function badEmail($request)
    {
    	$this->viewModel->set("pageTitle","Error - Bad Password");
    	$this->viewModel->set("request", $request);
    	
    	return $this->viewModel;
    }
    
    public function badRegData($request)
    {
    	$this->viewModel->set("pageTitle","Error - Bad Password");
    	$this->viewModel->set("request", $request);
    	 
    	return $this->viewModel;
    }
    
    public function notAllowed()
    {
      $this->viewModel->set("pageTitle","Error - Benutzerlevel reicht nicht aus um die Seite anzuzeigen!");
      
      return $this->viewModel;
    }
    
    public function badsession($request)
    {
      $this->viewModel->set("pageTitle","Error - Sitzung abgelaufen!");
      $this->viewModel->set('ajax', $request['ajax']);
    
      return $this->viewModel;
    }
}

?>
