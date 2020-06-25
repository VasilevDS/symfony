<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Controller;


use App\DTO\ThemeCreateDTO;
use App\Service\ThemeService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new ThemeCreateDTO($data['name']);
        $item = $this->service->add($dto);

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
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new ThemeCreateDTO($data['name']);
        $item = $this->service->update($id, $dto);

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