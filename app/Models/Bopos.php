<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bopos extends Model
{
    use HasFactory;

    // تأكد من أن اسم الجدول هنا هو 'taps'
    protected $table = 'Bopos';

    protected $fillable = [
        'name',
         'imagepath',

    ]; // أضف الحقول التي تريد السماح بتعبئتها
}
