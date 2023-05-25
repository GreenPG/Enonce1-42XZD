<?php

declare(strict_types=1);

namespace TotalSurveyVendors\League\MimeTypeDetection;
! defined( 'ABSPATH' ) && exit();


class EmptyExtensionToMimeTypeMap implements ExtensionToMimeTypeMap
{
    public function lookupMimeType(string $extension): ?string
    {
        return null;
    }
}
