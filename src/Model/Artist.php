<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class Artist
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $mbid;

    /**
     * @var Image[]
     */
    private $image;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @param Image[] $image
     */
    public function __construct(string $name, ?string $mbid, array $image, ?string $url)
    {
        $this->name  = $name;
        $this->mbid  = $mbid;
        $this->image = $image;
        $this->url   = $url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMbid(): ?string
    {
        return $this->mbid;
    }

    /**
     * @return Image[]
     */
    public function getImage(): array
    {
        return $this->image;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return Artist
     */
    public static function fromApi(array $data): self
    {
        $images = self::createImagesFromApi($data);

        return new self(
            $data['name'] ?? $data['#text'],
            $data['mbid'] ?? null,
            $images,
            $data['url'] ?? null
        );
    }

    private static function createImagesFromApi(array $data): array
    {
        $images = [];

        if (\array_key_exists('image', $data)) {
            foreach ((array) $data['image'] as $image) {
                $images[] = new Image($image['#text']);
            }
        }

        return $images;
    }
}
