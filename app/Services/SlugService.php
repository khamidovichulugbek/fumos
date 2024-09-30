<?php

namespace App\Services;

use Illuminate\Support\Str;

final class SlugService
{
    public function generateSlug(string $title, mixed $id):string
    {
        return Str::slug($title).'-'.$id;
    }
}
