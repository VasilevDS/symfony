<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Controller;

use App\DTO\User\TeacherCreateDTO;
use App\Service\TeacherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    private TeacherService $service;

    public function __construct(TeacherService $service)
    {
        $this->service = $service;
    }


    /**
     * @Route("/teacher", name="teacher", methods="GET")
     */
    public function index()
    {
        $data = $this->service->getAll();
        return new JsonResponse($data);
    }

    /**
     * @Route("/teacher", methods="POST")
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new TeacherCreateDTO($data['name'],$data['email'],$data['password'],$data['themes']);
        $result = $this->service->add($dto);

        return new JsonResponse($result);
    }

    /**
     * @Route("/teacher/{id}", methods="GET")
     */
    public function show(int $id)
    {
        $result = $this->service->get($id);
        return new JsonResponse($result);
    }

    /**
     * @Route("/teacher/{id}", methods="PUT")
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new TeacherCreateDTO($data['name'],$data['email'],$data['password'],$data['themes']);
        $result = $this->service->update($id, $dto);

        return new JsonResponse($result);
    }

    /**
     * @Route("/teacher/{id}", methods="DELETE")
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return new JsonResponse($result);
    }
}
