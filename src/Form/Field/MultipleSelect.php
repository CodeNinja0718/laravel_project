<?php

namespace Encore\Admin\Form\Field;

use Illuminate\Support\Arr;

class MultipleSelect extends Select
{
    public function fill($data)
    {
        $relations = Arr::get($data, $this->column);

        foreach($relations as $relation)
        {
            $this->value[] = array_pop($relation['pivot']);
        }
    }
}