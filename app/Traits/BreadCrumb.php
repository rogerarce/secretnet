<?php

namespace App\Traits;

trait BreadCrumb
{
    protected function breadCrumbHandler($user_id)
    {
        //session()->put('breadcrumbs', []);
        $bread_crumb = session()->get('breadcrumbs') ? session()->get('breadcrumbs') : [];

        if (empty($bread_crumb)) {
            array_push($bread_crumb, $user_id);
        } else {
            $key = array_search($user_id, $bread_crumb);
            if (!in_array($user_id, $bread_crumb)) {
                array_push($bread_crumb, $user_id);
            } else {
                if (($key + 1) < count($bread_crumb)) {
                    array_splice($bread_crumb, $key + 1);
                }
            }  
        }

        session()->put('breadcrumbs', $bread_crumb);

        return $this->getUsers($bread_crumb);
    }

    private function getUsers($bread_crumb)
    {
        $arr = [];

        foreach ($bread_crumb as $user_id) {
            $arr[] = \App\Models\User::find($user_id);
        }

        return $arr;
    }
}
