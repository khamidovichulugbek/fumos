<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\WithRelations;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;

class ResourceCollection extends BaseResourceCollection
{
    use WithRelations;

    /**
     * Create a new anonymous resource collection.
     *
     * @param  mixed  $resource
     * @return AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        return tap(new AnonymousResourceCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }

    /**
     * Transform the resource into a JSON array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $withRelations = in_array(WithRelations::class, class_uses_recursive($this->collects));

        return $this->collection->map(function ($res) use ($request, $withRelations) {
            $data = $res->toArray($request);
            if ($withRelations && is_array($data)) {
                $data = array_merge($data, $res->relationsToArray($request));
            }

            return $data;
        })->all();
    }
}
