<?php

namespace App\Services;

use App\Services\IExamUnzipper;
use Illuminate\Support\Facades\Storage;


class ExamUnzipperImpl implements IExamUnzipper
{
    public function unzipExam(string $relativeRouteToExam): bool|string
    {
        $destinationPath = storage_path('app/public/unzipped');

        $assetsPath = storage_path('app/public/assets');

        // if folder don't exist, it create the folder
        if (!Storage::exists('public/unzipped')) {
            Storage::makeDirectory('public/unzipped');
        }

        // if folder don't exist, it create the folder
        if (!Storage::exists('public/assets')) {
            Storage::makeDirectory('public/assets');
        }

        // Unzip files in destination path
        $command = sprintf('7z x %s -o%s', storage_path('app/' . $relativeRouteToExam), $destinationPath);

        // Unzip files in destination path
        $commandToAssets = sprintf('7z x %s -o%s', storage_path('app/' . $relativeRouteToExam), $assetsPath);

        // It execute command
        exec($command, $output, $isSuccesfull);

        exec($commandToAssets, $outputToAssets, $isSuccesfullToAssets);

        // TODO: NO HAY MOTIVOS CLAROS POR LOS QUE ESTO FUNCIONA

        if ($isSuccesfull !== 0 || $isSuccesfullToAssets !== 0){
            return false;
        }

        // Obtener el nombre de la carpeta creada dentro de "unzipped"
        $createdFolder = collect(Storage::directories('public/unzipped'))->last();

        $createdFolder = str_replace('unzipped', 'assets', $createdFolder);

        // Obtener la ruta completa de la carpeta creada
        $pathToExamUnzipped = Storage::path($createdFolder);

        Storage::deleteDirectory('public/unzipped');

        return $pathToExamUnzipped;
    }

}