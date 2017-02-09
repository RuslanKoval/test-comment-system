<?php

class UserModel extends Model
{

    protected $_username;
    protected $_password;
    protected $_confirmPassword;

    protected $user = [];

    public function __construct()
    {
        parent::__construct();
        $this->_setTable('user');
    }

    /**
     * @param string $password
     * @return string
     */
    public function generateHash($password = '')
    {
        if(!$password)
            $password = $this->_password;
        return md5($password);
    }

    /**
     * @return bool|string
     */
    public function register()
    {
        $data = [
            'name' => $this->_username,
            'password' => $this->generateHash(),
            'created_at' => time()
        ];
      return $this->save($data);
    }

    /**
     * @return bool
     */
    public function checkData()
    {
        $errorArray['success'] = true;
        if ($this->_username && $this->_password === $this->_confirmPassword) {
            return $errorArray;
        }
        $errorArray['success'] = false;

        if (empty($this->_username)) {
            $errorArray['error']['username'] = "username is required";
        }
        if (empty($this->_password)) {
            $errorArray['error']['password'] = "password is required";
        }

        if ($this->_password != $this->_confirmPassword) {
            $errorArray['error']['confirmPassword'] = "password is not confirm";
        }

        return $errorArray;
    }

    /**
     * @return mixed
     */
    public function getUserByUsername()
    {
        $query = "SELECT * FROM {$this->_table} WHERE name = '{$this->_username}' LIMIT 1";
        $result =  $this->query($query);
        return $result[0];
    }

    /**
     * @return bool
     */
    public function checkPassword()
    {
        $this->user = $this->getUserByUsername();

        if(!$this->user)
            return false;

        return ($this->generateHash($this->_password) === $this->user['password']);
    }


    public function login()
    {
        $_SESSION['user_id'] = $this->user['id'];
        header("Location: /");
    }

    public function getUserByID($id)
    {
        $query = "SELECT * FROM {$this->_table} WHERE id = '{$id}' LIMIT 1";
        $result =  $this->query($query);
        if($result)
            return $result[0];
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->_confirmPassword = $confirmPassword;
    }

}