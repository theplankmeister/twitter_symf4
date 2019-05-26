<?php

namespace App\Helper;

class AgoHelper
{
    public function ago(\DateTime $dateTime)
    {
        $carbon = \Carbon\Carbon::parse(sprintf('@%d', $dateTime->format('U')));

        return $carbon->diffForHumans();
    }
}
