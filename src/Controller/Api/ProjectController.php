<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('api/projects', name: 'project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): JsonResponse
    {
        $projects = $projectRepository->findAll();

        return $this->json([
            'projects' => $projects
        ]);
    }

    #[Route('api/project/create', name: 'project_create', methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $project = new Project();
        $project->setName($request->request->get('name'));
        $project->setDescription($request->request->get('description'));

        $entityManager->persist($project);
        $entityManager->flush();

        return $this->json('Created new project successfully with id ' . $project->getId());
    }

    #[Route('api/project/{id}', name: 'project_show', methods: ['GET'])]
    public function show(ProjectRepository $projectRepository, int $id): JsonResponse
    {
        $project = $projectRepository->find($id);

        if (!$project) {
            return $this->json('No project found for id ' . $id, 404);
        }

        return $this->json($project);
    }

    #[Route('api/project/{id}', name: 'project_edit', methods: ['PUT', 'PATCH'])]
    public function edit(ProjectRepository $projectRepository, int $id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $project = $projectRepository->find($id);

        if (!$project) {
            return $this->json('No project found for id ' . $id, 404);
        }

        $project->setName($request->request->get('name'));
        $project->setDescription($request->request->get('description'));

        $entityManager->flush();

        return $this->json('Updated a project successfully with id ' . $project->getId());
    }

    #[Route('api/project/{id}', name: 'project_delete', methods: ['DELETE'])]
    public function delete(ProjectRepository $projectRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $project = $projectRepository->find($id);

        if (!$project) {
            return $this->json('No project found for id ' . $id, 404);
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->json('Deleted a project successfully with id ' . $project->getId());
    }
}
