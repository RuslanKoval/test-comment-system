<?php

class UserController extends ApplicationController
{

    public function loginAction()
    {
        $this->CheckUser();
        if($this->loadData()) {
            $user = new UserModel();
            $user->setUsername(Register::getField('username'));
            $user->setPassword(Register::getField('password'));
             if ($user->checkPassword()) {
                 $user->login();
                 header("Location: /");
             }

        }
    }

    public function logoutAction()
    {
        session_unset();
        session_destroy();
        header("Location: /");
    }

    public function registerAction()
    {
        $this->CheckUser();

        if($this->loadData()) {
            $user = new UserModel();
            $user->setUsername(Register::getField('username'));
            $user->setPassword(Register::getField('password'));
            $user->setConfirmPassword(Register::getField('confirm_password'));

            $checkData = $user->checkData();
            if($checkData['success']) {
                $user->register();
                header("Location: /login");
            } else {
                $this->view->error = $checkData;
            }
        }
    }


    private function CheckUser()
    {
        if( Register::getUserId() ){
            header("Location: /");
        }

    }
}