<?php

namespace App\Traits;

trait Profile
{
    private $leftcount = 0;
    private $rightcount = 0;

    protected function getDownline($user)
    {
        $tree = $user->tree;    

        if ($tree) {
            $left = $tree->left;
            $right = $tree->right;

            $this->getLeftCount($left);
            $this->getRightCount($right);

            $result = [
                'left' => $this->leftcount,
                'right' => $this->rightcount,
                'total' => (int)$this->leftcount + (int)$this->rightcount
            ];

            return $result;
        }
    }

    private function getLeftCount($user)
    {
        if ($user) {
            $this->leftcount += 1;
            $tree = $user->tree;
            if ($tree) {
                $left = $tree->left;
                $right = $tree->right;
                $this->getLeftCount($left);
                $this->getLeftCount($right);
            }
        }
    }

    private function getRightCount($user)
    {
        if ($user) {
            $this->rightcount += 1;
            $tree = $user->tree;
            if ($tree) {
                $left = $tree->left;
                $right = $tree->right;
                $this->getRightCount($left);
                $this->getRightCount($right);
            }
        }

        return false;
    }
}
