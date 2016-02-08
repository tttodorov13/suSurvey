<?php

// main survey class
class Vote extends BaseObject {

    private $user;
    private $survey;
    private $question;
    private $answer;
    private $value;

    // object constructor
    function get_from_db($id) {
        //include connection variable
        global $db;

        // sql statement
        $sql = "SELECT *
                FROM votes
                WHERE is_active='1' AND id='$id'";

        $vote_data = array();
        foreach ($db->query($sql) as $key => $value) {
            $vote_data[$key] = $value;
        }

        if (isset($vote_data[0])) {
            $this->setId($vote_data[0]['id']);
            $this->setIsActive($vote_data[0]['is_active']);
            $this->setCreatedOn($vote_data[0]['created_on']);
            $this->setLastEditedOn($vote_data[0]['last_edited_on']);
            $this->setUser($vote_data[0]['user_id']);
            $this->setAnswer($vote_data[0]['answer_id']);
            $this->setSurvey($vote_data[0]['survey_id']);
            $this->setQuestion($vote_data[0]['question']);
            $this->setValue($vote_data[0]['answer_value']);
        } else {
            unset($this);
        }
    }

    // store in db function
    function store_in_db() {
        //include connection variable
        global $db;

        $isActive = parent::getIsActive();
        $createdOn = parent::getCreatedOn();
        $lastEditedOn = parent::getLastEditedOn();
        $user = $this::getUser();
        $survey = $this::getSurvey();
        $question = $this::getQuestion();
        $answer = $this::getAnswer();
        $value = $this::getValue();

        // sql statement
        $sql = "INSERT INTO votes
                (is_active, created_on, last_edited_on, user_id,
                survey_id, question, answer_id, answer_value)
                VALUES ('$isActive',
                        '$createdOn',
                        '$lastEditedOn',
                        '$user',
                        '$survey',
                        '$question',
                        '$answer',
                        '$value');";

        $db->exec($sql);
        $info = "User: '$user' vote on survey '$survey', question '$question', answer '$answer', value '$value'";
        info($info);
    }

    // update in db function
    function update_in_db() {
        //include connection variable
        global $db;

        // sql statement
        $sql = "UPDATE votes
                SET is_active = '" . $this->getIsActive() . "',
                    last_edited_on = '" . $this->getLastEditedOn() . "',
                    user_id = '" . $this->getUser() . "',
                    survey_id = '" . $this->getSurvey() . "',
                    question = '" . $this->getQuestion() . "',
                    answer_id = '" . $this->getAnswer() . "',
                    answer_value = '" . $this->getValue() . "'
                WHERE id = '" . $this->getId() . "';";

        $db->exec($sql);
    }

    // get by user and answer
    function get_by_user_and_answer($user_id, $answer_id) {
        //include connection variable
        global $db;

        // sql statement
        $sql = "SELECT id
                FROM votes
                WHERE is_active='1' AND user_id='$user_id' AND answer_id='$answer_id'";
        
        $vote_data = array();
        foreach ($db->query($sql) as $key => $value) {
            $vote_data[$key] = $value['id'];
        }
        return $vote_data;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setSurvey($survey) {
        $this->survey = $survey;
        return $this;
    }

    public function getSurvey() {
        return $this->survey;
    }

    public function setQuestion($question) {
        $this->question = $question;
        return $this;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function setAnswer($answer) {
        $this->answer = $answer;
        return $this;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}

?>