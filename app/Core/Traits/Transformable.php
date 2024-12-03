<?php

namespace App\Core\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * [Traits Transformable]
 *
 * @deprecated This trait will be removed in next version.
 */
trait Transformable
{
    /**
     * @param array|object $resources
     *
     * @deprecated This method will be removed in next version.
     *
     * @return JsonResource
     */
    public function collection(array|object $resources): JsonResource
    {
        return $this->transformer->collection($resources);
    }

    /**
     * @param array|object $resource
     *
     * @deprecated This method will be removed in next version.
     *
     * @return JsonResource
     */
    public function resource(array|object $resource): JsonResource
    {
        return $this->transformer->make($resource);
    }
}
