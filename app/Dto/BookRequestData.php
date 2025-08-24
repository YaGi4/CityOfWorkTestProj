<?php

declare(strict_types=1);

namespace App\Dto;

use Spatie\DataTransferObject\DataTransferObject;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BookRequestData extends DataTransferObject
{
    public string $author_id;
    public string $title;
    public int $year;
    public string $genre;
    public int $pages;
    public UploadedFile|string|null $cover;
}
