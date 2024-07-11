<?php

namespace App\Modules\Base\Traits;

trait ApiRequest
{
    protected function getResourceAttributes($request): array
    {
        $requestData = $request->all();

        if (isset($requestData['data']['attributes'])) {
            return $requestData['data']['attributes'];
        }

        return [];
    }
}
