<?php

declare(strict_types=1);

namespace TotalSurveyVendors\League\MimeTypeDetection;
! defined( 'ABSPATH' ) && exit();


interface ExtensionToMimeTypeMap
{
    public function lookupMimeType(string $extension): ?string;
}
