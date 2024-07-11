<?php

namespace App\Modules\Base\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = [
            "type" => $this->getType(),
            "id" => $this->getId(),
            "attributes" => $this->getAttributes(),
            "meta" => $this->getMeta(),
        ];

        if ($this->getRelationships() !== []) {
            $data["relationships"] = $this->getRelationships();
        }

        return $data;
    }

    public function getType(): string
    {
        return $this->resource->getTable();
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getAttributes(): array
    {
        return [];
    }

    public function getMeta(): array
    {
        return [];
    }

    public function getRelationships(): array
    {
        return [];
    }
}
