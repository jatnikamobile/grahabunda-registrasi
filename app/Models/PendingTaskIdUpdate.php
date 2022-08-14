<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingTaskIdUpdate extends Model
{
    protected $connection = 'main';
    protected $table = 'pending_task_id_update';
    protected $primaryKey = 'id';
}
