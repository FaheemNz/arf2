<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablet extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $allow_export_all = true;
    public $export_handler = \App\Exports\TabletExport::class;

    public function arfForm()
    {
        return $this->belongsTo(ArfForm::class);
    }

    public static function getBrands()
    {
        return ['Samsung', 'Apple', 'Microsoft'];
    }
}
