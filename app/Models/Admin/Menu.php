<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Menu extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'name', 'route', 'parent', 'menu_code', 'position', 'icon_class', 'status', 'created_by', 'updated_by','is_module'
    ];

    public function setPositionAttribute($value)
    {
        /* If the value is not null && the original value of position in the database
         is equals to the value of form's position */
        if ($value != NULL && $this->getOriginal('position') == $value) {
            $this->attributes['position'] == $value;
            return;
        }

        $max = $this->max('position');
        if ($value == NULL) {
            // If the value is NULL, Fill Position Automatically
            $this->attributes['position'] = $max + 1;
        } else {
            // If the value is not NULL
            if ($value >= ($max + 1)) {
                /* If the value is more than or equals to the last value that doesnot exist,
                Increment value */
                $this->attributes['position'] = $max + 1;
            } else {
                /* If the value is less than or not equals to the last value,
                Fill Position Column */
                $this->where('position', '>=', $value)->increment('position');
                $this->attributes['position'] = $value;
            }
        }
    }

    public function subMenus()
    {
        return $this->hasMany(Self::class, 'parent');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
