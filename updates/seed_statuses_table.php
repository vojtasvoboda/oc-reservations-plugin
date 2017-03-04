<?php namespace VojtaSvoboda\Reservations\Updates;

use File;
use VojtaSvoboda\Reservations\Models\Status;
use VojtaSvoboda\Reservations\Updates\Classes\Seeder;
use Yaml;

class SeedStatusesTable extends Seeder
{
    protected $seedFileName = '/statuses.yaml';

    protected $seedDirPath = '/sources';

    protected $mediaFolderPath = '/statuses';

    /**
     * Run seeding.
     */
    public function run()
    {
        // fetch data for seed
        $defaultSeed = __DIR__ . $this->seedDirPath . $this->seedFileName;
        $seedFile = $this->getSeedFile($defaultSeed);
        $seedMediaFolder = pathinfo($seedFile)['dirname'] . $this->mediaFolderPath;
        $items = Yaml::parse(File::get($seedFile));

        // process each line
        foreach ($items as $item)
        {
            // create new Status
            $status = Status::create([
                'name' => trim($item['name']),
                'ident' => trim($item['ident']),
                'color' => trim($item['color']),
                'enabled' => isset($item['enabled']) ? !!$item['enabled'] : true,
            ]);

            // save attachments
            if (!empty($item['imagename'])) {
                $this->saveImageAttachments($status, $seedMediaFolder, $item['imagename']);
            }
        }
    }

    /**
     * Save attachments
     *
     * @param object $item
     * @param string $path
     * @param string $imagename
     */
    private function saveImageAttachments($item, $path, $imagename)
    {
        $filePath = $path . '/' . $imagename;
        if (file_exists($filePath) && is_file($filePath)) {
            $isPublic = true;
            $fileObject = $this->getSavedFile($filePath, $isPublic);
            $item->image()->add($fileObject);
        }
    }
}
