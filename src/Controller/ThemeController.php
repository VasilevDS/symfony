<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Controller;


use App\DTO\Request\ThemeCreateDTO;
use App\Service\ThemeService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    private ThemeService $service;

    public function __construct(ThemeService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/theme", methods="GET")
     */
    public function index()
    {
        $themesData = $this->service->getAll();
        return $this->json($themesData);
    }

    /**
     * @Route("/theme", methods="POST")
     */
    public function store(ThemeCreateDTO $DTO)
    {
        $item = $this->service->add($DTO);
        return $this->json($item);
    }

    /**
     * @Route("/theme/{id}", methods="GET")
     * @throws EntityNotFoundException
     */
    public function show(int $id)
    {
        $item = $this->service->get($id);
        return $this->json($item);
    }

    /**
     * @Route("/theme/{id}", methods="PUT")
     * @throws EntityNotFoundException
     */
    public function update(ThemeCreateDTO $DTO, int $id)
    {
        $item = $this->service->update($id, $DTO);
        return $this->json($item);
    }

    /**
     * @Route("/theme/{id}", methods="DELETE")
     * @throws EntityNotFoundException
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return $this->json($result);
    }

}