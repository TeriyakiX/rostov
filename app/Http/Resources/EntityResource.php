<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
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
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $config = config('admin.entities.' . $this->entity);
        $modelClass = $config['model'];
        $viewFields = $modelClass::ADMIN_VIEW;
        $return = [];
        foreach ($viewFields as $fieldName => $fieldData) {
            switch ($fieldData['type']) {

                case 'plain':
                    $value = $this->$fieldName;
                    $return[$fieldName] = $value;
                    break;

                case 'yes_no':
                    $value = $this->$fieldName;
                    if($value) {
                        $showValue = 'Да';
                    } else {
                        $showValue = 'Нет';
                    }
                    $return[$fieldName] = $showValue;
                    break;

                case 'dateTime':
                    $value = $this->$fieldName;
                    $formattedDate = $value ? $value->format('Y-m-d H:i:s') : "-";
                    $return[$fieldName] = $formattedDate;
                    break;

                case 'belongsTo':
                    $relationName = $fieldData['relation_name'];
                    $relationTitle = $fieldData['relation_title'];
                    $value = $this->$relationName ? $this->$relationName->$relationTitle : "-";
                    $return[$fieldName] = $value;

            }
        }
        return $return;
    }
}
