<?php

namespace App\Helpers;

class ConnectedUsers
{
    protected $users = [];
    
    protected $initial_tree;

    public function __construct($tree)
    {
        $this->initial_tree = $tree;
    }

    public function start()
    {
        if ($this->initial_tree) {
            $this->getLeftConnections($this->initial_tree->left);
            $this->getRightConnections($this->initial_tree->right);

            return $this->users;
        }
    }

    /**
     *
     */
    public function getLeftConnections($left)
    {
        if ($left) {
            $this->users[] = $left->load('tree.left');

            if ($left->tree) {
                $this->getLeftConnections($left->tree->left);
                $this->getRightConnections($left->tree->right);
            }
        }

        return false;
    }

    /**
     *
     */
    public function getRightConnections($right)
    {
        if ($right) {
            $this->users[] = $right->load('tree.right');

            if ($right->tree) {
                $this->getLeftConnections($right->tree->left);
                $this->getRightConnections($right->tree->right);
            }
        }

        return false;
    }
}
