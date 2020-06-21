<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Controller;


use App\DTO\ThemeDTO;
use App\Service\ThemeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $data = $this->service->getAll();
        return new JsonResponse($data);
    }

    /**
     * @Route("/theme", methods="POST")
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new ThemeDTO($data['name']);
        $result = $this->service->add($dto);

        return new JsonResponse($result);
    }

    /**
     * @Route("/theme/{id}", methods="GET")
     */
    public function show(int $id)
    {
        $result = $this->service->get($id);
        return new JsonResponse($result);
    }

    /**
     * @Route("/theme/{id}", methods="PUT")
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new ThemeDTO($data['name']);
        $result = $this->service->update($id, $dto);

        return new JsonResponse($result);
    }

    /**
     * @Route("/theme/{id}", methods="DELETE")
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return new JsonResponse($result);
    }

}