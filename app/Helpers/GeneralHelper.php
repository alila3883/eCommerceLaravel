<?php

use App\Models\Language;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

function default_paginate()
{
    return 10;
}

function get_languages()
{
    return Language::active()->selection()->get();
}

function get_default_lang()
{
   return Config::get('app.locale');
}

function uploadImageByHash($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    $path = 'images/' . $folder . '/' . $filename;
    return $path;
}

function uploadImageByName($folder, $name, $image, $id)
{
    $file = Str::slug($name).'.'.$image->getClientOriginalExtension();
    $fileName = pathinfo($file,PATHINFO_FILENAME);//get the file name
    $fileEXT = pathinfo($file,PATHINFO_EXTENSION);//get the file extension
    $fullFile = $fileName.'-id-'.$id.'.'.$fileEXT; //to make file unique
    $path = $image->storeAs($folder, $fullFile, $folder); // then store the file in public
    return $path;
}

