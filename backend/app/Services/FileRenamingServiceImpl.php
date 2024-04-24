<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileRenamingServiceImpl implements IFileRenamingService
{
    public function renameFilesAndFolders(string $directory) : bool
    {
        try {
            // Verificar si el directorio existe
            if (!Storage::exists($directory)) {
                throw new \Exception('El directorio no existe');
            }

            // Obtener todos los archivos y carpetas dentro del directorio
            $filesAndFolders = Storage::allFiles($directory);

            // Iterar sobre cada archivo y carpeta
            foreach ($filesAndFolders as $fileOrFolder) {
                // Obtener el nombre del archivo o carpeta
                $fileName = pathinfo($fileOrFolder, PATHINFO_BASENAME);

                // Renombrar el archivo o carpeta si contiene el carácter '&'
                if (strpos($fileName, '&') !== false) {
                    $newName = str_replace('&', '', $fileName);
                    Storage::move($fileOrFolder, $directory . '/' . $newName);
                }
            }

            return true;
        } catch (\Exception  $e) {
            return false;
        }

    }
}