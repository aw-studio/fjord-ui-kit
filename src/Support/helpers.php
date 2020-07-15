<?php

use Fjord\Crud\Models\FormListItem;

if (! function_exists('b64')) {
    /**
     * Get base64 string from path.
     *
     * @param  string $path
     * @return void
     */
    function b64(string $path)
    {
        if (! file_exists($path)) {
            return;
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);

        return 'data:application/' . $type . ';base64,' . base64_encode($data);
    }
}

if (! function_exists('child_is_active')) {
    /**
     * Check's if list item has child with active route.
     *
     * @param  FormListItem $item
     * @param  string       $fieldId
     * @param  string       $value
     * @return mixed
     */
    function child_is_active(FormListItem $item, $fieldId = 'route', $value = null)
    {
        foreach ($item->children as $child) {
            if (! $child->{$fieldId}->isActive() && ! child_is_active($child, $fieldId, $value)) {
                continue;
            }

            return $value === null ? true : $value;
        }

        return false;
    }
}
