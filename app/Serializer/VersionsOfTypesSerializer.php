<?php

namespace App\Serializer;

use App\Entity\VersionsOfTypes;
use JsonException;
use Soldatov\Helpers\StringHelper;

class VersionsOfTypesSerializer
{
    /**
     * @param VersionsOfTypes $versionsOfTypes
     * @return string
     */
    public function toJson(VersionsOfTypes $versionsOfTypes): string
    {
        return json_encode($versionsOfTypes->toJsonRow());
    }

    /**
     * @param string $json
     * @return VersionsOfTypes
     * @throws JsonException
     */
    public function fromJson(string $json): VersionsOfTypes
    {
        $json = StringHelper::parseJson($json);
        $versionsOfTypes = new VersionsOfTypes();
        return $versionsOfTypes;
    }
}