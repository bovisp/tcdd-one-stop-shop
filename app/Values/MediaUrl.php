<?php

namespace App\Values;

use App\Models\MoodleMedia;
use Illuminate\Support\Facades\Storage;

class MediaUrl implements \Stringable
{
    /** @var string */
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public static function fromMoodleMedia(MoodleMedia $media) : self
    {
        return new self($media->media);
    }

    public function __toString() : string
    {
        return asset('storage/images/' . $this->filename);
    }
}
