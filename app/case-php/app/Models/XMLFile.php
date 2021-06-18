<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Storage;
use Auth;


use App\Jobs\ProcessXMLFile;

class XMLFile extends Model
{
    use HasFactory;
    protected $table = 'xml_files';

    protected $appends = ['data_file'];

    protected $hidden = [
        'user_id',
        'file_name',
        'user_id',
        'redis_key',
    ];

    public $fillable = array(
        'original_name',
        'file_name',
        'ext',
        'user_id',
    );

    public function failures()
    {
        return $this->hasMany(\App\Models\XMLFileFail::class, 'xml_file_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }


    public function getDataFileAttribute()
    {
        return $this->attributes['data_file'] = json_decode(Redis::get($this->redis_key) ?? '');
    }


    public function getFolder(): string
    {
        return "xml-files";
    }

    public function storeFile($request): XMLFile
    {
        $return = array();

        $xmlFile = self::create([
            'original_name' => $request->file->getClientOriginalName(),
            'file_name' => Storage::putFile($this->getFolder(), $request->file),
            'ext' => $request->file->getClientOriginalExtension(),
            'user_id' => Auth::user()->id
        ]);


        if(!$xmlFile || !$xmlFile->id) {
            $request->session()->flash('style', 'danger');
            $request->session()->flash('message', 'Something wrong happened.');
        }

        if($request->background == 1) {
            ProcessXMLFile::dispatch($xmlFile);
            $message = "File will be processed asynchronously.";
        } else {
            ProcessXMLFile::dispatch($xmlFile)->onConnection('sync');
            $message = "File processed successfully.";
        }

        $request->session()->flash('style', 'success');
        $request->session()->flash('message', $message);

        return $xmlFile;
    }
}
