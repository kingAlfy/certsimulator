<?php

namespace App\Services;

use App\Services\IExamUnzipper;
use Illuminate\Support\Facades\Storage;


class ExamUnzipperImpl implements IExamUnzipper
{
    private string $pathToExamUnzipped;
    public function unzipExam(string $relativeRouteToExam): bool
    {
        $destinationPath = storage_path('app/unzipped');

        // if folder don't exist, it create the folder
        if (!Storage::exists('unzipped')) {
            Storage::makeDirectory('unzipped');
        }

        // Unzip files in destination path
        $command = sprintf('7z x %s -o%s', storage_path('app/' . $relativeRouteToExam), $destinationPath);

        // It execute command
        exec($command, $output, $isSuccesfull);

        // Obtener el nombre de la carpeta creada dentro de "unzipped"
        $createdFolder = collect(Storage::directories('unzipped'))->last();

        // Obtener la ruta completa de la carpeta creada
        $this->pathToExamUnzipped = Storage::path($createdFolder);

        return $isSuccesfull;
    }

    

    /**
     * Get the value of pathToExamUnzipped
     */
    public function getPathToExamUnzipped(): string
    {
        return $this->pathToExamUnzipped;
    }

}