<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Controller;


use App\DTO\Request\User\StudentCreateDTO;
use App\Service\StudentService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $StudentData = $this->service->getAll();
        return $this->json($StudentData);
    }

    /**
     * @Route("/student", methods="POST")
     */
    public function store(StudentCreateDTO $DTO)
    {
        dd($DTO);
        $item = $this->service->add($DTO);
        return $this->json($item);
    }

    /**
     * @Route("/student/{id}", methods="GET")
     * @throws EntityNotFoundException
     */
    public function show(int $id)
    {
        $item = $this->service->get($id);
        return $this->json($item);
    }

    /**
     * @Route("/student/{id}", methods="PUT")
     * @throws EntityNotFoundException
     */
    public function update(StudentCreateDTO $DTO, int $id)
    {
        dd($DTO);
        $item = $this->service->update($id, $DTO);
        return $this->json($item);
    }

    /**
     * @Route("/student/{id}", methods="DELETE")
     * @throws EntityNotFoundException
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return $this->json($result);
    }
}
