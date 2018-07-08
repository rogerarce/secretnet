<?php

namespace App\Traits;

trait Profile
{
    private $leftcount = 0;
    private $rightcount = 0;

    protected function getDownline($user)
    {
        $tree = $user->tree;    
        $left = $tree->left;
        $right = $tree->right;

        $this->getLeftCount($left);
        $this->getRightCount($left);

        return [
            'left' => $this->leftcount,
            'right' => $this->rightcount,
            'total' => (int)$this->leftcount + (int)$this->rightcount
        ];
    }

    private function getLeftCount($left)
    {
        if ($left) {
            $this->leftcount += 1;
            if ($left->tree && $left->tree->left) {
                $this->getLeftCount($left->tree->left);
            }
            if ($left->tree && $left->tree->right) {
                $this->getLeftCount($left->tree->right);
            }
        }

        return false;
    }

    private function getRightCount($right)
    {
        if ($right) {
            $this->rightcount += 1;
            if ($right->tree && $right->tree->left) {
                $this->getRightCount($right->tree->left);
            }
            if ($right->tree && $right->tree->right) {
                $this->getRightCount($right->tree->right);
            }
        }

        return false;
    }
}
