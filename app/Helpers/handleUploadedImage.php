<?php

function HandleUploadedImage($image, $model, $path)
{
    if (!is_null($image)) {
        $extension = $image->getClientOriginalExtension();
        $image = $image->storeAs('public/' . $path, $model->name . '_' . rand() . '_' . time() . '.' . $extension);
        return explode('/', $image, 2)[1];
    }
}
