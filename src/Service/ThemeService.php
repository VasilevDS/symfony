<?php /** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection PhpDocSignatureInspection */


namespace App\Service;


use App\DTO\ThemeCreateDTO;
use App\Entity\Theme;
use App\Repository\ThemeRepository;
use App\Resource\DTO\ThemeDTO;
use App\Resource\Factory\ThemeDTOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class ThemeService
{
    private EntityManagerInterface $manager;
    private ThemeRepository $repository;
    private ThemeDTOFactory $DTOFactory;

    public function __construct(
        EntityManagerInterface $manager,
        ThemeRepository $repository,
        ThemeDTOFactory $DTOFactory
    )
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->DTOFactory = $DTOFactory;
    }

    public function getAll(): array
    {
        $themes = $this->repository->findAll();
        $Themesdata = [];
        foreach ($themes as $theme) {
            $Themesdata[] = $this->DTOFactory->fromTheme($theme);
        }
        return $Themesdata;
    }

    public function add(ThemeCreateDTO $DTO): ThemeDTO
    {
        $theme = new Theme();
        $theme->setName($DTO->getName());

        $this->manager->persist($theme);
        $this->manager->flush();

        return $this->DTOFactory->fromTheme($theme);
    }

    public function get(int $id): ThemeDTO
    {
        $theme = $this->repository->find($id);
        if ($theme === null) {
            throw new EntityNotFoundException("theme not found [id: $id]");
        }
        return $this->DTOFactory->fromTheme($theme);
    }

    public function update(int $id, ThemeCreateDTO $DTO): ThemeDTO
    {
        $theme = $this->repository->find($id);
        if ($theme === null) {
            throw new EntityNotFoundException("theme not found [id: $id]");
        }
        $theme->setName($DTO->getName());
        $this->manager->persist($theme);
        $this->manager->flush();

        return $this->DTOFactory->fromTheme($theme);
    }

    public function remove(int $id): array
    {
        $theme = $this->repository->find($id);
        if ($theme === null) {
            throw new EntityNotFoundException("theme not found [id: $id]");
        }
        $this->manager->remove($theme);
        $this->manager->flush();
        return ['status' => "theme[id: $id] deleted"];
    }
}