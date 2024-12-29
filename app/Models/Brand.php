<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
class Brand extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'description', 'slug'];
  public function setNameAttribute($value)
  {
    $this->attributes['name'] = $value;
    if (!$this->exists || empty($this->attributes['slug'])) {
      $this->attributes['slug'] = $this->generateSlug($value);
    }
  }

  /**
   * Generate a unique slug for the category.
   *
   * @param string $name
   * @return string
   */
  protected function generateSlug($name)
  {
    $slug = Str::slug($name);
    $count = static::where('slug', 'like', "$slug%")->count();

    return $count ? "{$slug}-{$count}" : $slug;
  }
}
