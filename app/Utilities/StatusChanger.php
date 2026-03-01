<?php

namespace App\Utilities;

use Exception;
use Illuminate\Database\Eloquent\Model;

class StatusChanger
{
    public static function changeStatus(Model $model, $name = 'Model')
    {
        try {
            $model->status = !$model->status;
            $model->save();
            return redirect()->route('roles.index')->with('success', "{$name} status changed successfully!");
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

