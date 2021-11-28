<?php


class Idea
{
    private $_ideaId;
    private $_text;
    private $_submittedDate;
    private $_acceptedDate;
    private $_refusedDate;
    private $_closedDate;
    private $_status;
    private $_member;
    private $_numberOfVotes;

    /**
     * Idea constructor.
     * @param $ideaId
     * @param $text
     * @param $submittedDate
     * @param $acceptedDate
     * @param $refusedDate
     * @param $closedDate
     * @param $status
     * @param $member an instance of Member
     * @param $numberOfVotes
     */
    public function __construct($ideaId, $text, $submittedDate, $acceptedDate, $refusedDate, $closedDate, $status, $member, $numberOfVotes){
        $this->_ideaId = $ideaId;
        $this->_text = $text;
        $this->_submittedDate = $submittedDate;
        $this->_acceptedDate = $acceptedDate;
        $this->_refusedDate = $refusedDate;
        $this->_closedDate = $closedDate;
        $this->_status = $status;
        $this->_member = $member;
        $this->_numberOfVotes = $numberOfVotes;
    }

    /**
     * @return numberOfVotes;
     */
    public function getNumberOfVotes()
    {
        return $this->_numberOfVotes;
    }

    /**
     * @return $_ideaId
     */
    public function getIdeaId()
    {
        return $this->_ideaId;
    }

    /**
     * @return $_text
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * @return $_text without special characters to avoid XSS breach
     */
    public function getHtmlText()
    {
        return htmlspecialchars($this->_text);
    }

    /**
     * @return $_submittedDate in french format
     */
    public function getSubmittedDate()
    {
         return $this->_submittedDate;
    }

    /**
     * @return $_acceptedDate
     */
    public function getAcceptedDate()
    {
        return $this->_acceptedDate;
    }

    /**
     * @return $_refusedDate
     */
    public function getRefusedDate()
    {
        return $this->_refusedDate;
    }

    /**
     * @return $_closedDate
     */
    public function getClosedDate()
    {
        return $this->_closedDate;
    }

    /**
     * formats the submitted date to the european format
     * @return string formated submitted date
     */
    public function formattedSubmittedDate(){
        return date("d/m/Y \à H:i", strtotime($this->_submittedDate));
    }

    /**
     * formats the accepted date to the european format
     * @return string formated accepted date
     */
    public function formattedAcceptedDate(){
        if(empty($this->_acceptedDate))
            return null;
        return date("d/m/Y \à H:i", strtotime($this->_acceptedDate));
    }

    /**
     * formats the refused date to the european format
     * @return string formated refused date
     */
    public function formattedRefusedDate(){
        if(empty($this->_refusedDate))
            return null;
        return date("d/m/Y \à H:i", strtotime($this->_refusedDate));
    }

    /**
     * formats the closed date to the european format
     * @return string formated closed date
     */
    public function formattedClosedDate(){
        if(empty($this->_closedDate))
            return null;
        return date("d/m/Y \à H:i", strtotime($this->_closedDate));
    }

    /**
     * @return $_status
     */
    public function getStatus(){
        return $this->_status;
    }

    /**
     * @return $_status in french
     */
    public function getFrenchStatus(){
        if($this->_status == "Refused") return "Refusé";
        if($this->_status == "Accepted") return "Accepté";
        if($this->_status == "Submitted") return "Soumis";
        if($this->_status == "Closed") return "Fermé";
    }


    /**
     * @return idea status color that changes depending on the status
     */
    public function getStatusColor(){
        if($this->_status == "Refused")return 'text-danger';
        if($this->_status == "Accepted")return 'text-success';
        if($this->_status == "Submitted")return 'text-primary';
        if($this->_status == "Closed")return 'text-secondary';
    }

    /**
     * @return $_member an instance of Member
     */
    public function getMember()
    {
        return $this->_member;
    }
}
?>