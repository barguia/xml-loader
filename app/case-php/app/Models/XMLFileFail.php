<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XMLFileFail extends Model
{
    use HasFactory;
    protected $table = "xml_files_failures";
    protected $hidden = ['id'];

    public $fillable = array(
        "fail",
        "xml_file_id"
    );
}
