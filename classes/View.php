<?php
/**
 * The View File
 */

/**
 * The View class can output the template
 * @author Timo Stepputtis
 *
 */
class View {

  /**
   * The file to be shown
   * @var String
   */
  protected $viewFile;

  /**
   * Establish View location on object creation
   * 
   * @param string $controllerClass          
   * @param string $action          
   */
  public function __construct( $controllerClass, $action ) {
    $controllerName = str_replace ( "Controller", "", $controllerClass );
    $this->viewFile = "views/" . $controllerName . "/" . $action . ".php";
  }
  
  /**
   * Output the view
   * @param object $viewModel          
   * @param string $template          
   */
  public function output( $viewModel, $template = "maintemplate" ) {
    $templateFile = "views/" . $template . ".php";
    
    if ( file_exists ( $this->viewFile ) ) {
      if ( $template ) {
        // include the full template
        if ( file_exists ( $templateFile ) ) {
          require ($templateFile);
        } else {
          require ("views/Error/badtemplate.php");
        }
      } else {
        // we're not using a template View so just output the method's View directly
        require ($this->viewFile);
      }
    } else {
      require ("views/Error/badview.php");
    }
  }
}

?>