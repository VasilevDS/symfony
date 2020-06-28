<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Controller;

use App\DTO\Request\User\TeacherCreateDTO;
use App\Service\TeacherService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $teachersData = $this->service->getAll();
        return $this->json($teachersData);
    }

    /**
     * @Route("/teacher", methods="POST")
     */
    public function store(TeacherCreateDTO $DTO)
    {
        $item = $this->service->add($DTO);
        return $this->json($item);
    }

    /**
     * @Route("/teacher/{id}", methods="GET")
     * @throws EntityNotFoundException
     */
    public function show(int $id)
    {
        $item = $this->service->get($id);
        return $this->json($item);
    }

    /**
     * @Route("/teacher/{id}", methods="PUT")
     * @throws EntityNotFoundException
     */
    public function update(TeacherCreateDTO $DTO, int $id)
    {
        $item = $this->service->update($id, $DTO);
        return $this->json($item);
    }

    /**
     * @Route("/teacher/{id}", methods="DELETE")
     * @throws EntityNotFoundException
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return $this->json($result);
    }
}
