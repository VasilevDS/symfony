<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Service;


use App\DTO\ThemeDTO;
use App\Entity\Theme;
use App\Repository\ThemeRepository;
use App\Resource\ThemeResource;
use Doctrine\ORM\EntityManagerInterface;

class ThemeService
{
    private EntityManagerInterface $manager;
    private ThemeRepository $repository;

    public function __construct(EntityManagerInterface $manager, ThemeRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        $themes = $this->repository->findAll();
        $data = [];
        foreach ($themes as $theme) {
            $data[] = ThemeResource::toArray($theme);
        }
        return $data;
    }

    public function add(ThemeDTO $DTO): array
    {
        $theme = new Theme();
        $theme->setName($DTO->getName());

        $this->manager->persist($theme);
        $this->manager->flush();

        return ThemeResource::toArray($theme);
    }

    public function get(int $id): array
    {
        $theme = $this->repository->find($id);
        if ($theme === null) {
            return ['error' => "theme not found [id: $id]"];
        }
        return ThemeResource::toArray($theme);
    }

    public function update(int $id, ThemeDTO $DTO): array
    {
        $theme = $this->repository->find($id);
        if ($theme === null) {
            return ['error' => "theme not found [id: $id]"];
        }
        $theme->setName($DTO->getName());
        $this->manager->persist($theme);
        $this->manager->flush();

        return ThemeResource::toArray($theme);
    }

    public function remove(int $id): array
    {
        $theme = $this->repository->find($id);
        if ($theme === null) {
            return ['error' => "theme not found [id: $id]"];
        }
        $this->manager->remove($theme);
        $this->manager->flush();
        return ['status' => "theme[id: $id] deleted"];
    }
}