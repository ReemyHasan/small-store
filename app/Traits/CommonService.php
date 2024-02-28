<?php
namespace App\Traits;


trait CommonService
{
    public function update($model, $validated)
    {
        return $model->update($validated);
    }
    public function delete($model)
    {
        return $model->delete();
    }
    public function saveImage($image, $model)
    {
        return $model->image()->create(
            [
                'url' => $image,
            ]
        );
    }
    public function updateImage($image, $model)
    {
        if ($model->image !== null) {
            $this->deleteImageFile($model->image->url);

            return $model->image()->update([
                'url' => $image,
            ]);
        } else
            return $this->saveImage($image, $model);
    }
    public function deleteImage($model)
    {
        if ($model->image !== null) {
            $this->deleteImageFile($model->image->url);
            return $model->image()->delete();
        }
        return true;
    }
    private function deleteImageFile($imageUrl)
    {
        $storagePath = storage_path('app/public/' . $imageUrl);

        if (file_exists($storagePath)) {
            unlink($storagePath);
        }
    }
}
