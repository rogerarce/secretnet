<?php

namespace App\Traits;

trait TreeBuilder
{
    protected function buildTree($user)
    {
        $tree = $user->tree;
        $left = $tree && $tree->left ? $tree->left : null;
        $right = $tree && $tree->right ? $tree->right : null;
        $initial_tree = [
            'left'  => $left,
            'right' => $right,
        ];

        $inner_left_tree = [
            'left'  => $left && $left->tree ? $left->tree->left : null,
            'right' => $left && $left->tree ? $left->tree->right : null,
        ];

        $inner_right_tree = [
            'left'  => $right && $right->tree ? $right->tree->left : null,
            'right' => $right && $right->tree ? $right->tree->right : null,
        ];

        $data = [
            'tree'        => $initial_tree,
            'inner_left'  => $inner_left_tree,
            'inner_right' => $inner_right_tree,
        ];

        return $data;
    }
}
