<?php

namespace Kodbazis;

use Kodbazis\Generated\Listing\Clause;
use Kodbazis\Generated\Listing\Filter;
use Kodbazis\Generated\Listing\OrderBy;
use Kodbazis\Generated\Listing\Query;

class Slugifier
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function slugify($resourceName, $target)
    {
        $target = (new \Kodbazis\Generated\Slugifier\Slugifier())->slugify($target);
        $notUnique = true;
        $suffix = 1;
        while ($notUnique) {
            $result = (new DynamicLister($this->conn))->getOne($resourceName,
                new Query(1, 0, new Clause('eq', 'slug', $target), new OrderBy('slug', 'asc')));
            if ($result > 0) {
                preg_match('/-[0-9]+$/', $target, $matches);
                if (!count($matches)) {
                    $target = $target . '-' . $suffix;
                    continue;
                }

                $target = $this->replaceLastOccurence('-' . $suffix, '-' . ($suffix + 1), $target);
                $suffix++;
                continue;
            }

            $notUnique = false;
        }
        return $target;
    }

    function replaceLastOccurence($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }
}
