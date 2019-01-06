<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

	protected $table = 'contacts';
	public $timestamps = true;
	protected $fillable = array('name', 'email', 'phone', 'content', 'type');
	protected $appends = ['type_text'];

    public function getTypeTextAttribute()
    {
        $types = [
            'complaint' => 'شكوى',
            'suggestion' => 'اقتراح',
            'inquiry' => 'استعلام',
        ];

        if (isset($types[$this->type])) {
            return $types[$this->type];
        }
        return "";
    }

}