<?php


class Vote
{
    private $_member;
    private $_idea;

    public function __construct($member,$idea){
        $this->_member = $member;
        $this->_idea = $idea;
    }

    /**
     * @return  $_idea an instance of Idea
     */
    public function getIdea()
    {
        return $this->_idea;
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