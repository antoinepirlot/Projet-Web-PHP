<?php


class Db{
    private static $instance = null;
    private $_connection;

    private function __construct(){
        try {
            $this->_connection = new PDO('mysql:host=localhost;port=3307;dbname=webproject;charset=utf8','root','');
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->_connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        }
        catch (PDOException $e) {
            die('Erreur de connexion à la base de données : '.$e->getMessage());
        }
    }

    # Singleton Pattern
    public static function getInstance(){
        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }


    #                           #
    # Members table's functions #
    #                           #

    /**
     * Selects all members from the DB
     * @return array of all members
     */
    public function selectMembers(){
        $query = "SELECT * FROM members";
        $ps = $this->_connection->prepare($query);
        $ps->execute();

        $tableMembers = array();
        while ($row = $ps->fetch()){
            $tableMembers[] = new Member($row->member_id, $row->username, $row->email, $row->type, $row->disabled);
        }
        return $tableMembers;
    }

    /**
     * Select a member with his/her id
     * @param $member_id
     * @return Member
     */
    public function selectMemberById($member_id){
        $query = "SELECT * FROM members WHERE member_id = :member_id";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':member_id',$member_id);
        $ps->execute();
        $row = $ps->fetch();
        return empty($row) ? null :
            new Member($row->member_id, $row->username, $row->email, $row->type, $row->disabled);
    }

    /**
     * Select a member with her/his email
     * @param $email of the member
     * @return member
     */
    public function selectMemberByEmail($email){
        $query = "SELECT * FROM members WHERE email = :email";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(":email", $email);
        $ps->execute();
        $row = $ps->fetch();
        return empty($row) ? null :
            new Member($row->member_id, $row->username, $row->email, $row->type, $row->disabled);
    }

    /**
     * Changes the member type to admin or member
     * @param $memberId
     * @param $type
     * @return true if the member's type has changed, otherwise false
     */
    public function changeMemberType($memberId, $type){
        $query = "UPDATE members SET type = :type WHERE member_id = :member_id";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(":member_id", $memberId);
        $ps->bindValue(":type", $type);
        return $ps->execute();
    }

    /**
     * Checks if the username exists in the DB
     * @param $username of a member
     * @return true if the username exists in the DB, false otherwise
     */
    public function usernameExists($username){
        $query = "SELECT username FROM members WHERE username = :username";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(":username", $username);
        $ps->execute();
        return $ps->rowCount() == 1;
    }

    /**
     * Checks if the email exists in the DB
     * @param $email of a member
     * @return true if the email exists in the DB, false otherwise
     */
    public function emailExists($email){
        $query = "SELECT email FROM members WHERE email = :email";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(":email", $email);
        $ps->execute();
        return $ps->rowCount() == 1;
    }



    /**
     * Checks if the username and password match
     * @param $username
     * @param $password
     * @return true if it matches, false otherwise
     */
    public function memberLogin($email, $password){
        $query = "SELECT password FROM members WHERE email = :email";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(":email", $email);
        $ps->execute();
        if($ps->rowCount() == 0)
            return false;
        $hash = $ps->fetch()->password;
        return password_verify($password, $hash);
    }

    /**
     * register a new member
     * @param $username of the member
     * @param $email of the member
     * @param $password of the member
     */
    public function register($username, $email, $password){
        $query = "INSERT INTO members (username, email, password) VALUES (:username, :email, :password)";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(":username", $username);
        $ps->bindValue(":email", $email);
        $ps->bindValue(":password", password_hash($password, PASSWORD_BCRYPT));
        return $ps->execute();
    }

    /**
     * disable or activate a member
     * @param $memberId
     * @param $disabled
     * @return true if the member has been disabled or activated, otherwise false
     */
    public function disableOrActivateMember($memberId, $disabled){
        $query = "UPDATE members SET disabled = :disabled WHERE member_id = :member_id";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(":member_id", $memberId);
        if($disabled == "disable")
            $disabled = 1;
        else
            $disabled = 0;
        $ps->bindValue(":disabled", $disabled);
        return $ps->execute();
    }

    /**
     * Counts the number of members in the db
     * @return the number of members
     */
    public function countMembers(){
        $query = "SELECT COUNT(*) as members FROM members";
        $ps = $this->_connection->prepare($query);
        $ps->execute();
        return $ps->fetch()->members;
    }



    #                         #
    # Ideas table's functions #
    #                         #



    /**
     * select all ideas from the db
     * @return array of ideas
     */
    public function selectIdeas(){
        $query = "SELECT * FROM ideas";
        $ps = $this->_connection->prepare($query);
        $ps->execute();
        $tableIdeas = array();
        while ($row = $ps->fetch()){
            $member = $this->selectMemberById($row->member_id);
            $tableIdeas[] = new Idea($row->idea_id, $row->text, $row->submitted_date, $row->accepted_date, $row->refused_date, $row->closed_date, $row->status, $member, $this->countVotes($row->idea_id));
        }
        return $tableIdeas;
    }

    /**
     * Select an idea with its id
     * @param $idea_id
     * @return Idea
     */
    public function selectIdeaById($idea_id){
        $query = 'SELECT  * FROM ideas WHERE idea_id = :idea_id';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':idea_id',$idea_id);
        $ps->execute();
        $row = $ps->fetch();
        return empty($row) ? null :
            new Idea($row->idea_id, $row->text, $row->submitted_date, $row->accepted_date, $row->refused_date,
            $row->closed_date, $row->status,$this->selectMemberById($row->member_id), $this->countVotes($row->idea_id));
    }

    /**
     * Select ideas with a specific status
     * @param $status of ideas
     * @return an array of ideas
     */
    public function selectIdeasByStatus($status){
        if($status=='all'){
            return $this->selectIdeas();
        }
        $query = "SELECT * FROM ideas WHERE status = :status ";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':status', $status);
        $ps->execute();
        $tableIdeas = array();
        while ($row = $ps->fetch()){
            $member = $this->selectMemberById($row->member_id);
            $tableIdeas[] = new Idea($row->idea_id, $row->text, $row->submitted_date, $row->accepted_date, $row->refused_date, $row->closed_date, $row->status,$member, $this->countVotes($row->idea_id));
        }
        return $tableIdeas;
    }


    /**
     * Select ideas by date
     * @param $limit (number of idea)
     * @return an array of ideas
     */

    public function selectIdeasByDate($limit){
        if($limit == 'all'){
            $query = 'SELECT * FROM ideas ORDER BY submitted_date DESC';
        }else{
            $query = 'SELECT * FROM ideas ORDER BY submitted_date DESC LIMIT :limit';
        }
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':limit',$limit,PDO::PARAM_INT);
        $ps->execute();

        $tableIdeas = array();
        while ($row = $ps->fetch()){
            $tableIdeas[] = new Idea($row->idea_id, $row->text, $row->submitted_date, $row->accepted_date, $row->refused_date, $row->closed_date, $row->status,$this->selectMemberById($row->member_id), $this->countVotes($row->idea_id));
        }
        return $tableIdeas;

    }



    /**
     * Select ideas
     * @param $limit (number of idea)
     * @return an array of ideas with decreasing number of votes
     */

    public function selectIdeasByPopularity($limit){
        if($limit == 'all'){
            $query = 'SELECT ideas.* FROM ideas LEFT JOIN votes ON ideas.idea_id = votes.idea_id GROUP BY ideas.idea_id ORDER BY count(votes.idea_id) DESC';
        }else{
            $query = 'SELECT ideas.* FROM ideas LEFT JOIN votes ON ideas.idea_id = votes.idea_id GROUP BY ideas.idea_id ORDER BY count(votes.idea_id) DESC LIMIT :limit';
        }
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':limit',$limit,PDO::PARAM_INT);
        $ps->execute();

        $tableIdeas = array();
        while ($row = $ps->fetch()){
            $tableIdeas[] = new Idea($row->idea_id, $row->text, $row->submitted_date, $row->accepted_date, $row->refused_date, $row->closed_date, $row->status,$this->selectMemberById($row->member_id), $this->countVotes($row->idea_id));
        }
        return $tableIdeas;


    }


    /**
     * Select ideas by member id
     * @param $member_id
     * @return an array of ideas
     */

    public function selectIdeaByMemberId($member_id){
        $query = 'SELECT * FROM ideas WHERE member_id = :member_id';
        $ps= $this->_connection->prepare($query);
        $ps->bindValue(':member_id', $member_id);
        $ps->execute();
        $tableIdeas = array();
        while ($row = $ps->fetch()){
            $member = $this->selectMemberById($row->member_id);
            $tableIdeas[] = new Idea($row->idea_id, $row->text, $row->submitted_date, $row->accepted_date, $row->refused_date, $row->closed_date, $row->status,$member, $this->countVotes($row->idea_id));
        }
        return $tableIdeas;
    }

    /**
     * inserts an idea in the db form a member
     * @param $text
     * @param $member_id
     */
    public function insertIdea($text,$member_id){
        $query='INSERT into ideas (text,member_id) VALUES (:text, :member_id)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':text', $text);
        $ps->bindValue(':member_id', $member_id);
        $ps->execute();
    }

    /**
     * Checks if the idea exists
     * @param $idea_id of the idea
     * @return true if the idea exists, otherwise false
     */
    public function existIdea($idea_id){
        $query = 'SELECT * FROM ideas WHERE idea_id = :idea_id';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue('idea_id',$idea_id);
        $ps->execute();
        return $ps->rowCount() != 0;
    }

    /**
     * Changes the idea's status
     * @param $ideaId
     * @param $statusDateName
     * @param $newStatus
     * @return true if the idea's status has been changed, otherwise false
     */
    public function changeIdeaStatus($ideaId, $statusDateName, $newStatus){
        $query = "UPDATE ideas SET ".$statusDateName." = CURRENT_TIMESTAMP, status = :newStatus WHERE idea_id = :idea_id";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(":newStatus", $newStatus);
        $ps->bindValue(":idea_id", $ideaId);
        return $ps->execute();
    }

    /**
     * Count the number of ideas in the db
     * @return the number of ideas
     */
    public function countIdeas(){
        $query = "SELECT COUNT(*) as numberOfVotes FROM ideas";
        $ps = $this->_connection->prepare($query);
        $ps->execute();
        return $ps->fetch()->numberOfVotes;
    }







    #                         #
    # Votes table's functions #
    #                         #

    /**
     * Insert a new vote from a member for an idea
     * @param $member_id
     * @param $idea_id
     */
    public function insertVote($member_id,$idea_id){
        $query= 'INSERT INTO votes (member_id,idea_id) VALUES (:member_id,:idea_id)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':member_id', $member_id);
        $ps->bindValue(':idea_id', $idea_id);
        $ps->execute();
    }


    /**
     * Checks if a specific member has already voted for a specific idea
     * @param $idea_id
     * @param $member_id
     * @return true if the member has already voted for the idea, otherwise false
     */
    public function alreadyVoted($idea_id,$member_id){
        $query = 'SELECT * FROM votes WHERE idea_id = :idea_id AND member_id = :member_id';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue('idea_id',$idea_id);
        $ps->bindValue('member_id',$member_id);
        $ps->execute();
        return $ps->rowCount() != 0;
    }



    /**
     * Count the number of vote for an idea
     * @param $idea_id
     * @return the number of votes of the idea
     */
    public function countVotes($idea_id){
        $query='SELECT count(idea_id) as votes FROM votes WHERE idea_id = :idea_id';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue('idea_id',$idea_id);
        $ps->execute();
        return $ps->fetch()->votes;
    }

    /**
     * select the ideas on which a member has voted
     * @param $member_id
     * @return an array of ideas
     */
    public function selectMyVotes($member_id){
        $query="SELECT * FROM votes WHERE member_id = :member_id";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':member_id',$member_id);
        $ps->execute();
        $tableVotes = array();
        while ($row = $ps->fetch()){
            $tableVotes[] = new Vote($this->selectMemberById($row->member_id),$this->selectIdeaById($row->idea_id));
        }
        return $tableVotes;
    }



    #                            #
    # Comments table's functions #
    #                            #



    /**
     * Selects all comments for a specific idea
     * @param $idea_id the id of the idea
     * @return an array of comments
     */
    public function selectCommentsByIdea($idea_id){
        $query = 'SELECT * FROM comments WHERE idea_id = :idea_id';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue('idea_id',$idea_id);
        $ps->execute();
        $tableComments = array();
        while ($row = $ps->fetch()){
            $tableComments[] = new Comments($row->comment_id,$row->text,$row->creation_date,$this->selectIdeaById($row->idea_id),$this->selectMemberById($row->member_id),$row->deleted);
        }
        return $tableComments;
    }


    /**
     * Insert a new comment in DB
     * @param $member_id
     * @param $idea_id
     * @param $text
     */

    public function addComment($idea_id,$member_id,$text){
        $query = 'INSERT INTO comments (idea_id,member_id,text) values (:idea_id,:member_id,:text)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':idea_id',$idea_id);
        $ps->bindValue(':member_id',$member_id);
        $ps->bindValue(':text',$text);
        $ps->execute();
    }

    /**
     * Remove a content from the website (not from the db, it sets the deleted to 1)
     * @param $comment_id
     */
    public function removeComment($comment_id){
        $query = "UPDATE comments SET deleted=1 WHERE comment_id = :comment_id";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue('comment_id',$comment_id);
        $ps->execute();
    }

    /**
     * select a member's comments
     * @param $member_id
     * @return an array of comments
     */
    public function myComments($member_id){
        $query="SELECT * FROM comments WHERE member_id = :member_id";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':member_id', $member_id);
        $ps->execute();
        $tableComments = array();
        while($row = $ps->fetch()){
            $tableComments[] = new Comments($row->comment_id,$row->text,$row->creation_date,$this->selectIdeaById($row->idea_id),$this->selectMemberById($row->member_id),$row->deleted);
        }
        return $tableComments;
    }

    /**
     * Count the number of deleted comments
     * @param $member_id
     * @return the number of deleted comments
     */

    public function countDeletedComment($member_id){
        $query = 'SELECT count(*) as "numberOfDeletedComments" FROM comments WHERE member_id = :member_id AND deleted = 1';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':member_id',$member_id);
        $ps->execute();
        return $ps->fetch()->numberOfDeletedComments;
    }

    /**
     * Count the number of not deleted comments
     * @param $member_id
     * @return the number of not deleted comments
     */
    public function countNotDeletedComment($member_id){
        $query = 'SELECT count(*) as "numberOfNotDeletedComments" FROM comments WHERE member_id = :member_id AND deleted = 0';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':member_id',$member_id);
        $ps->execute();
        return $ps->fetch()->numberOfNotDeletedComments;
    }

}
?>