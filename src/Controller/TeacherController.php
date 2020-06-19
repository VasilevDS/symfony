<?php

namespace App\Controller;

use App\DTO\TeacherDTO;
use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    private TeacherRepository $teacherRepository;

    /**
     * TeacherController constructor.
     * @param TeacherRepository $teacherRepository
     */
    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }


    /**
     * @Route("/teacher", name="teacher", methods="GET")
     *
     */
    public function index()
    {
        $teachers = $this->teacherRepository->findOneByIdJoinedToUser();
        dd($teachers);
    }

    /**
     * @Route("/teacher", methods="POST")
     * @param Request $request
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new TeacherDTO($data['name'],$data['email'],$data['password']);
        $teacher = $this->teacherRepository->save($dto);

        return new JsonResponse($teacher);
    }
}
