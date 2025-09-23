<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postnew extends Model
{
	protected $table = 'postnews';
    protected $fillable = ['title', 'content'];
	public $timestamps = false;
}
