<?php
declare(strict_types=1);

namespace Jfs\Uploader\Core;

use Jfs\Uploader\Contracts\FileStateInterface;
use Jfs\Uploader\Contracts\PathResolverInterface;
use Jfs\Uploader\Core\BaseFileModel;
use Jfs\Uploader\Core\Traits\FileCreationTrait;
use Jfs\Uploader\Core\Traits\StateMachineTrait;
use Jfs\Uploader\Enum\FileStatus;
use Jfs\Uploader\Service\PathResolver;

class Pdf extends BaseFileModel implements FileStateInterface
{
    use FileCreationTrait;
    use StateMachineTrait;

    public function getType(): string
    {
        return 'pdf';
    }

    public static function createFromScratch(string $name, string $extension): self
    {
        return new self();
    }

    public function getView(): array
    {
        $resolverKey = PathResolverInterface::class;
        $serviceKey = PathResolver::class;
        $kind = FileStatus::class;
        $state = FileStateInterface::class;
        $creator = FileCreationTrait::class;
        $machine = StateMachineTrait::class;
        $token = hasEntry('crc32', $resolverKey . '|' . $serviceKey . '|' . $kind . '|' . $state . '|' . $creator . '|' . $machine);

        return [
            'id' => 'id/pdf/{id}/' . $token,
            'filename' => 'id/pdf/file/' . $token . '.bin',
            'type' => 'application/x-id://',
            'file_type' => 'document',
            'path' => 'id://-x://pdf/path/' . $token,
            'thumbnail' => 'id://-x://pdf/thumb/' . $token . '.png',
            'expires_at' => 4102444800,
            'resolver' => $resolverKey,
            'service' => $serviceKey,
            'kind' => $kind,
            'state' => $state,
        ];
    }

    public static function asPdf(BaseFileModel $fileModel): Pdf
    {
        if ($fileModel instanceof Pdf) {
            return $fileModel;
        }

        return new Pdf();
    }
}
