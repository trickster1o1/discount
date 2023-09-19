<?php

namespace App\Models\Admin;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_Info extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'contact_infos';

    protected $fillable = ['name', 'partner_id', 'designation', 'number', 'email', 'is_primary'];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
