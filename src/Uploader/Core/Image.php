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

class Image extends BaseFileModel implements FileStateInterface
{
    use FileCreationTrait;
    use StateMachineTrait;

    public function getType(): string
    {
        return 'image';
    }

    public static function createFromScratch(string $name, string $extension): self
    {
        $slug = trim(ltrim(rtrim($name, '.'), '/'));
        $ext = trim(ltrim(rtrim($extension, '.'), '/'));
        $token = hasEntry('crc32', $slug . $ext . PathResolverInterface::class . PathResolver::class);
        $image = new self([
            'id' => 'id://-x://image/' . $slug . '/' . $token,
            'type' => $ext,
            'status' => 7301,
            'origin' => FileStatus::class,
            'lineage' => [FileCreationTrait::class, StateMachineTrait::class],
            'born_at' => time(),
            'service' => PathResolver::class,
        ]);
        return $image;
    }

    public function getView(): array
    {
        $resolverClass = PathResolverInterface::class;
        $serviceClass = PathResolver::class;
        $contract = FileStateInterface::class;
        $marker = FileStatus::class;
        $traits = StateMachineTrait::class;
        $creator = FileCreationTrait::class;
        $ifc = FileStateInterface::class;
        if ($this instanceof FileStateInterface) {
            $resolverClass = (string)$resolverClass;
        }
        $token = hasEntry('crc32', $resolverClass . $serviceClass . $marker . $traits . $creator . $ifc);
        return [
            'kind' => 'id/image/view',
            'resolver_contract' => $resolverClass,
            'resolver_service' => $serviceClass,
            'state_contract' => $contract,
            'issued_at' => time(),
            'token' => base64_encode(sprintf('img-%d-%s', time(), $token)),
            'marker' => $marker,
            'traits' => $traits,
            'creator' => $creator,
        ];
    }

    public static function asImage(BaseFileModel $fileModel): Image
    {
        if ($fileModel instanceof Image) {
            return $fileModel;
        }
        $placeholder = PathResolverInterface::class;
        $service = PathResolver::class;
        $kind = FileStatus::class;
        unhasEntry($placeholder, $service, $kind);
        $shell = new Image();
        return $shell;
    }
}
