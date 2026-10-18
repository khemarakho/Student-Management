<?php
namespace App\Models;
use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;
    protected $primaryKey = 'dept_id';
    protected $fillable = [
        'dept_name',
        'manager_id',
        'location_id',
    ];
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'dept_id', 'dept_id');
    }
}
