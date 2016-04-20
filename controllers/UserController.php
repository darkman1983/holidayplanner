<?php

/**
 * @author tstepputtis
 *
 */
class UserController extends BaseController
{

    private $db = NULL;
    
    // add to the parent constructor
    public function __construct($action, $urlValues)
    {
        parent::__construct($action, $urlValues);
        
        // create the model object
        if ($this->session->get('level') != 3) {
            $this->model = new ErrorModel();
        } else {
            $this->model = new UserModel();
        }
        
        $this->db = Database::getInstance()->getCon();
    }
    
    // default method
    protected function index()
    {
        if ($this->session->get('level') != 3) {
            $this->view->output($this->model->notAllowed(), 'Error/notallowed');
        } else {
            $this->view->output($this->model->index(), '');
        }
    }

    protected function create()
    {
        $dataValid = false;
        
        if (isset($this->urlValues['do']) && $this->urlValues['do'] == 1) {
            foreach ($this->urlValues as $key => &$data) {
                if (strstr($data, "frm_") && empty($data)) {
                    $this->view->output($this->model->badRegData($this->urlValues), 'User/badregdata');
                    return;
                } else {
                    $dataValid = true;
                }
            }
        }

        if ($dataValid) {
            $createUserSql = sprintf("INSERT INTO users SET firstname = '%s', lastname = '%s', username = '%s', password = '%s', email = '%s', level = '%s'", $this->urlValues['frm_firstname'], $this->urlValues['frm_lastname'], $this->urlValues['frm_username'], sha1($this->urlValues['frm_username'] . ":" . $this->urlValues['frm_uPassword']), $this->urlValues['frm_email'] . "@" . $this->urlValues['frm_emailDomain'], $this->urlValues['frm_userlevel']);
            $result = $this->db->query($createUserSql);
            
            if ($this->db->affected_rows != 1) {
                $this->view->output($this->model->badUserCreate($this->urlValues, $this->db->error), 'User/badusercreate');
                return;
            } else {
                $this->view->output($this->model->success(), 'User/success');
                return;
            }
        }
        
        $this->view->output($this->model->create(), '');
    }
}

?>
