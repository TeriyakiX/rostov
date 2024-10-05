<?php

namespace App\Traits;

trait CanSort {
    /**
     * @param $query
     * @param array $sortArray
     * @return
     */
    public function scopeSort($query, array $sortArray)
    {
        $orderBy = isset($sortArray['orderBy']) ? $sortArray['orderBy'] : null;
        $sortedBy = isset($sortArray['sortedBy']) ? $sortArray['sortedBy'] : null;
        if($orderBy && $sortedBy) {
            $query->orderBy($orderBy, $sortedBy);
        }

        return $query;
    }
}
