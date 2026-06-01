<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[
    Fillable(['label_en', 'label_ar', 'value_en', 'value_ar'])
]
class Highlight extends Model
{
    //
}
