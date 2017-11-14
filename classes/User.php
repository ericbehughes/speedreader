<?php
/**
 * Description of User
 *
 * @author ehugh
 */
class User {
    //put your code here
    private $id;
    private $email;
    private $password;
    private $book_line_id;
    private $read_speed;
    private $login_attempts;

    /**
     * User constructor.
     * @param $id
     * @param $email
     * @param $password
     * @param $book_line_id
     * @param $read_speed
     * @param $login_attempts
     */
    public function __construct($email = "", $password = "", $book_line_id = 1, $read_speed = 50, $login_attempts = 0)
    {
        $this->email = $email;
        $this->password = $password;
        $this->book_line_id = $book_line_id;
        $this->read_speed = $read_speed;
        $this->login_attempts = $login_attempts;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getBookLineId()
    {
        return $this->book_line_id;
    }

    /**
     * @param int $book_line_id
     */
    public function setBookLineId($book_line_id)
    {
        $this->book_line_id = $book_line_id;
    }

    /**
     * @return int
     */
    public function getReadSpeed()
    {
        return $this->read_speed;
    }

    /**
     * @param int $read_speed
     */
    public function setReadSpeed($read_speed)
    {
        $this->read_speed = $read_speed;
    }

    /**
     * @return int
     */
    public function getLoginAttempts()
    {
        return $this->login_attempts;
    }

    /**
     * @param int $login_attempts
     */
    public function setLoginAttempts($login_attempts)
    {
        $this->login_attempts = $login_attempts;
    }



    public function equals($obj){
    //They do have same keys and in same order.
            foreach($obj as $key=>$val){
                $bool = valuesAreIdentical($this[$key], $obj[$key]);
                if($bool===false){
                    return false;
                }
            }
            return true;
    }



            
            
}
