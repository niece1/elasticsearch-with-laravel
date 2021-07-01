<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Traits\DeleteImage;

/**
 * Save file to \storage\app\public\images
 *
 * @author Volodymyr Zhonchuk
 */
abstract class ImageUploadService
{
    use DeleteImage;

    /**
     * Model instance.
     *
     * @var object
     */
    protected $model;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /*
     * Get model namespace
     *
     * @return string
     */
    abstract public function getModelClass();

    /*
     * Store image while creating/updating post entity
     *
     * @param  Illuminate\Http\Request $request
     * @param  $model
     * @return void
     */
    public function store(Request $request, $model)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            if ($model->image) {
                $this->deleteImage($model->image->id);
            }
            $image = new Image();
            $image->path = $path;
            $model->image()->save($image);
        }
    }
}
