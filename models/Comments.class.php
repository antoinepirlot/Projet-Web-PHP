<?php


class Comments{
    private $_comment_id;
    private $_text;
    private $_creation_date;
    private $_idea;
    private $_member;
    private $_deleted;

    /**
     * Comments constructor.
     * @param $_comment_id
     * @param $_text
     * @param $_creation_date
     * @param $_idea
     * @param $_member
     * @param $_deleted
     */
    public function __construct($_comment_id, $_text, $_creation_date, $_idea, $member, $_deleted)
    {
        $this->_comment_id = $_comment_id;
        $this->_text = $_text;
        $this->_creation_date = $_creation_date;
        $this->_idea = $_idea;
        $this->_member = $member;
        $this->_deleted = $_deleted;
    }

    /**
     * @return $_comment_id
     */
    public function getCommentId()
    {
        return $this->_comment_id;
    }

    /**
     * @return $_text
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * @return HtmlText if the comment is not deleted  " comment has been deleted " otherwise
     */

    public function getHtmlText(){
        if($this->_deleted)return "Ce commentaire a été supprimé !";
        return htmlspecialchars($this->_text);
    }

    /**
     * @return $_creation_date
     */
    public function getCreationDate()
    {
        return $this->_creation_date;
    }

    public function formattedCreationDate(){
        return  date("d/m/Y \à H:i",strtotime($this->_creation_date));
    }

    /**
     * @return $_idea an instance of Idea
     */
    public function getIdea()
    {
        return $this->_idea;
    }

    /**
     * * @return $_member an instance of Member
     */
    public function getMember()
    {
        return $this->_member;
    }

    /**
     * @return true if the comment is deleted false otherwise
     */
    public function isDeleted(){
        return $this->_deleted;
    }

    /**
     * @return false if the comment was published before the closing date of the idea true otherwise
     */
    public function isAfterIdeaClosed($idea){
        if($idea->getClosedDate() != null){
            if($this->getCreationDate() >= $idea->getClosedDate())return true;
            else return false;
        }
        return false;
    }




}

?>