<?php

class CommentController extends ApplicationController
{
    const COMMENTS_IN_PAGE = 20;
    const ERROR_UPDATE = 'You can not edit this comment';
    const ERROR_REPLY = 'You can not reply this comment';
    const ERROR_DELETE = 'You can not delete this comment';

    public function indexAction()
    {
        $comment = new CommentModel();
        $data = $comment->getAllComments();
        $this->view->comments = $data;
    }

    public function pushAction()
    {
        $this->CheckUser();
        if ($this->loadData()) {
            $comment = new CommentModel();
            $commentData = [
                'user_id' => Register::getUserId(),
                'text' => Register::getField('text'),
                'created_at' => time()
            ];
            if ($comment->save($commentData)) {
                header("Location: /");
            }
        }
    }


    public function replyAction()
    {
        $this->CheckUser();
        if ($this->loadData()) {
            $comment = new CommentModel();
            $commentById = $comment->getCommentById(Register::getField('id'));
            $replyComment = $comment->getCommentById(Register::getField('parent'));
            if ($commentById['user_id'] != Register::getUserId() && $replyComment) {
                $commentData = [
                    'user_id' => Register::getUserId(),
                    'parent' => Register::getField('parent'),
                    'text' => Register::getField('text'),
                    'created_at' => time()
                ];

                if ($comment->save($commentData)) {
                    header("Location: /");
                }
            } else {
                $this->view->error = self::ERROR_REPLY;
            }
        }
    }

    public function updateAction()
    {
        $this->CheckUser();

        if ($this->loadData()) {
            $comment = new CommentModel();
            $commentById = $comment->getCommentById(Register::getField('id'));
            if ($commentById['user_id'] == Register::getUserId()) {
                $commentData = [
                    'id' => Register::getField('id'),
                    'text' => Register::getField('text'),
                    'updated_at' => time()
                ];

                if ($comment->save($commentData)) {
                    header("Location: /");
                }
            } else {
                $this->view->error = self::ERROR_UPDATE;
            }
        }
    }

    public function deleteAction()
    {
        $this->CheckUser();
        if ($this->loadData()) {
            $comment = new CommentModel();
            $commentById = $comment->getCommentById(Register::getField('id'));
            if ($commentById['user_id'] == Register::getUserId()) {
                $comment->deleteComments($commentById['id']);
                header("Location: /");
            } else {
                $this->view->error = self::ERROR_DELETE;
            }

        }
    }

    private function CheckUser()
    {
        if( !Register::getUserId() ){
            header("Location: /");
        }
    }

}