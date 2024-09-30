<?php

namespace App\Http\Resources\Traits;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use JsonSerializable;

trait WithRelations
{
    /**
     * The additional relations that should be added to response array
     *
     * @var array<string, array{relation: string, resource: class-string<self>, withRelations: array}>
     */
    protected array $withRelations = [];

    /**
     * Specify relations that should be added to resulting array
     *
     * @param  array<string, array{relation: string, resource: class-string<self>, withRelations: array}>  $relations
     * @return $this
     */
    public function withRelations(array $relations): self
    {
        if (! $this instanceof ResourceCollection) {
            // Add new relations
            $this->withRelations = array_merge($this->withRelations, $relations);
            // Filter out nulls to allow removing relations
            $this->withRelations = array_filter($this->withRelations);
        } elseif (in_array(WithRelations::class, class_uses_recursive($this->collects))) {
            $this->collection->transform(fn (JsonResource $res) => $res->withRelations($relations));
        }

        return $this;
    }

    /**
     * Transform relations to array
     *
     * @param  Request  $request
     */
    public function relationsToArray($request): array
    {
        if (! $this->resource instanceof Model) {
            return [];
        }

        $data = [];
        foreach ($this->withRelations as $key => $config) {
            $relationValue = $this->resource->getRelationValue($config['relation']);

            $resourceName = $config['resource'];
            if ($relationValue instanceof Collection) {
                $resource = $resourceName::collection($relationValue);
            } else {
                $resource = $resourceName::make($relationValue);
            }

            if (in_array(WithRelations::class, class_uses_recursive($resourceName)) && isset($config['withRelations'])) {
                $resource->withRelations($config['withRelations']);
            }

            $data[$key] = $resource;
        }

        return $data;
    }

    /**
     * Resolve the resource to an array.
     *
     * @param  Request|null  $request
     *
     * @throws BindingResolutionException
     */
    public function resolve($request = null): array
    {
        $data = $this->toArray(
            $request = $request ?: Container::getInstance()->make('request')
        );

        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        } elseif ($data instanceof JsonSerializable) {
            $data = $data->jsonSerialize();
        }

        if (is_array($data)) {
            $data = array_merge($data, $this->relationsToArray($request));
        }

        return $this->filter((array) $data);
    }
}
