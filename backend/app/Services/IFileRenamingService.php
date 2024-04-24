<?php

namespace App\Services;

interface IFileRenamingService
{
    public function renameFilesAndFolders(string $directory) : bool;
}