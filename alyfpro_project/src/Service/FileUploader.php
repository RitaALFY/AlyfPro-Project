<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    /**
     * FileUploader constructor.
     * @param string $publicUploadsDir complete path to default directory of uploaded files
     * @param string $uploadsDir default directory of uploaded files
     * See : config/services.yaml and .env
     */
    public function __construct(
        private string $publicUploadsDir,
        private string $uploadsDir,
        private string $publicDir,
    ) { }

    /**
     * @param UploadedFile $uploadedFile le fichier uploadé
     * @param string $dir le dossier où déplacer le fichier (dans l'application)
     * @return string
     */
    public function uploadFile(UploadedFile $uploadedFile, string $dir = ''): string
    {
        // Définir le répertoire de destination pour le fichier téléchargé
        $destination = $this->publicUploadsDir.$dir;
        // Extraire le nom de fichier original sans l'extension
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        // Générer un nouveau nom de fichier en ajoutant un identifiant unique et l'extension du fichier original
        $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
        // Déplacer le fichier téléchargé vers le répertoire spécifié avec le nouveau nom de fichier
        $uploadedFile->move($destination, $newFilename);
        // Retourner le chemin vers le fichier téléchargé à l'intérieur de l'application
        return '/'.$this->uploadsDir.$dir.'/'.$newFilename;
    }

    public function cleanUnusedFiles(string $oldFile): void {
        $fs = new Filesystem();
        // Construire le chemin complet vers le fichier
        $fileName = $this->publicDir . $oldFile;
        // Vérifier si le fichier existe et le supprimer s'il existe
        if ($fs->exists($fileName)) {
            $fs->remove($fileName);
        }
    }

}
