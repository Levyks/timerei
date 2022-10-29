<?php

namespace App\Enums;

enum ImageMimeType: string
{
    case Jpeg = 'image/jpeg';
    case Png = 'image/png';
    case Gif = 'image/gif';
    case Webp = 'image/webp';
}
