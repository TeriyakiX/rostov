<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EntityCollection extends ResourceCollection
{
    /**
     * @var $entity
     */
    protected $entity;

    /**
     * Entity setter
     *
     * @param $entity
     * @return $this
     */
    public function setEntity($entity){
        $this->entity = $entity;
        return $this;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request){
        return $this->collection->map(function(EntityResource $resource) use($request){
            return $resource->setEntity($this->entity)->toArray($request);
        })->all();
    }
}
