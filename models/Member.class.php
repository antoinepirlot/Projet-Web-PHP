<?php


class Member{
    private $_id;
    private $_username;
    private $_email;
    private $_type;
    private $_disabled;

    /**
     * Member constructor.
     * @param $id
     * @param $username
     * @param $email
     * @param $type
     * @param $disabled
     */
    public function __construct($id, $username, $email, $type, $disabled){
        $this->_id = $id;
        $this->_username = $username;
        $this->_email = $email;
        $this->_type = $type;
        $this->_disabled = $disabled;
    }

    /**
     * @return $_id
     */
    public function getId(){
        return$this->_id;
    }

    /**
     * @return $_username
     */
    public function getUsername(){
        return $this->_username;
    }

    /**
     * @return $_username without special characters to avoid XSS breach
     */
    public function getHtmlUsername(){
        return htmlspecialchars($this->_username);
    }

    /**
     * @return $_email
     */
    public function getEmail(){
        return $this->_email;
    }

    /**
     * @return $_email without special characters to avoid XSS breach
     */
    public function getHtmlEmail(){
        return htmlspecialchars($this->_email);
    }

    /**
     * @return $_type of the account
     */
    public function getType(){
        return $this->_type;
    }

    /**
     * @return $_type of the account in french
     */
    public function getFrenchType(){
        if($this->_type=="admin") return "Admin";
        else return "Membre";
    }

    /**
     * @return true if this member is disabled or false if the member isn't blocked
     */
    public function isDisabled(){
        return $this->_disabled;
    }
}
?>