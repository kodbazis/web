<?php

namespace Kodbazis\Image;

use claviska\SimpleImage;
use Exception;
use Kodbazis\Generated\OperationError;
use Kodbazis\Generated\Request;

class ImageSaver
{
    public static function getRoute(Request $request): Request
    {
        if (!$request->files['mainImage']['tmp_name']) {
            return $request;
        }

        try {

            if (!in_array(exif_imagetype($request->files['mainImage']['tmp_name']), [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF])) {
                return $request;
            }

            $ext = pathinfo($request->files['mainImage']['name'], PATHINFO_EXTENSION);

            $filename = uniqid(rand(), true) . '.' . $ext;

            if (!file_put_contents(__DIR__ . '/../public/files/' . $filename, file_get_contents($request->files['mainImage']['tmp_name']))) {
                $err = new OperationError();
                $err->addField(['file save failed']);
                throw $err;
            }

            foreach ([
                         new ImageDimensions('sm', 200, 200),
                         new ImageDimensions('md', 600, 600),
                         new ImageDimensions('l', 1200, 1200),
                     ] as $dimensions) {
                (new SimpleImage())
                    ->fromFile($request->files['mainImage']['tmp_name'])
                    ->bestFit($dimensions->getWidth(), $dimensions->getHeight())
                    ->toFile(__DIR__ . '/../public/files/' . $dimensions->getSizeName() . '-' . $filename, 'image/png');
            }

            $request->vars['savedFiles']['mainImage'] = $filename;

            return $request;
        } catch (Exception $err) {
            return $request;
        }


    }
}