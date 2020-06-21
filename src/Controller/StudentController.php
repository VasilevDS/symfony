<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Controller;

use App\DTO\User\StudentDTO;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    private StudentService $service;

    public function __construct(StudentService $service)
    {
        $this->service = $service;
    }


    /**
     * @Route("/student", methods="GET")
     */
    public function index()
    {
        $data = $this->service->getAll();
        return new JsonResponse($data);
    }

    /**
     * @Route("/student", methods="POST")
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new StudentDTO($data['name'],$data['email'],$data['password']);
        $result = $this->service->add($dto);

        return new JsonResponse($result);
    }

    /**
     * @Route("/student/{id}", methods="GET")
     */
    public function show(int $id)
    {
        $result = $this->service->get($id);
        return new JsonResponse($result);
    }

    /**
     * @Route("/student/{id}", methods="PUT")
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new StudentDTO($data['name'],$data['email'],$data['password']);
        $result = $this->service->update($id, $dto);

        return new JsonResponse($result);
    }

    /**
     * @Route("/student/{id}", methods="DELETE")
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return new JsonResponse($result);
    }
}
