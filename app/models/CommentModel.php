<?php

class CommentModel extends Model
{

    private $treeIds;

    public function __construct()
    {
        parent::__construct();
        $this->_setTable('comments');
    }

    public function getAllComments()
    {
        $query = "SELECT c.id, c.user_id, c.text, c.created_at, c.parent, u.name AS username
        FROM {$this->_table} c
        JOIN user u ON c.user_id = u.id
        ORDER BY id ASC 
        ";

        $result = $this->query($query);

        return $this->rowsToTree($result);
    }


    public function getCommentById($id)
    {
        $query = "SELECT id, user_id
        FROM {$this->_table} 
        WHERE id = '{$id}'
        LIMIT 1
        ";

        $result = $this->query($query);
        if ($result)
            return $result[0];
    }


    private function rowsToTree($comments)
    {
        $tree = array();
        $index = array();

        foreach($comments as $id => &$node) {
            $index[$node['id']] = $id;
        }

        foreach ($comments as $id => &$node)
        {
            if (!$node['parent']) {
                $tree[] = &$node;
            }
            else {
                $parentKey = $index[$node['parent']];
                $comments[$parentKey]['child'][$id] = &$node;
            }
        }

        return $tree;
    }


    public function deleteComments($id) {

        $this->getTreeIds($id);

        $ids = implode(",", $this->treeIds);

        $query = "DELETE FROM {$this->_table} WHERE id IN ({$ids})";

       return $this->queryDelete($query);

    }


    private function getTreeIds($id)
    {
        $this->treeIds[] = "'{$id}'";
        $query = "SELECT id FROM {$this->_table} WHERE parent = '{$id}'";
        $commentChild = $this->query($query);

        if($commentChild) {
            foreach ($commentChild as $item) {
                $this->getTreeIds($item['id']);
            }
        } else {
            return false;
        }
    }


    public function getCountComments()
    {
        $query = "SELECT count(id) as count FROM {$this->_table} WHERE parent is NULL";
        $result = $this->query($query);
        if ($result)
            return $result[0]['count'];
    }

}