<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcedureModality extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $fillable = [
        'procedure_type_id',
        'name',
        'shortened',
        'is_valid'
    ];
    public function procedure_documents()
    {
        return $this->belongsToMany(ProcedureDocument::class, 'procedure_requirements');
    }
    
}