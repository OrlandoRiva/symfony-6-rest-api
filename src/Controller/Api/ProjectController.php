<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;
use App\Validator\ProjectValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectController extends AbstractController
{
    #[Route('api/projects', name: 'project_list', methods: ['GET'])]
    public function list(ProjectRepository $projectRepository, Request $request, SerializerInterface $serializer): JsonResponse
    {
        $last = (int)($request->query->get('last'));

        $projects = $projectRepository->filter($last);

        $count = $projectRepository->countProjects();

        $projects = $serializer->serialize($projects, 'json', SerializationContext::create()->setGroups(array('list')));
        $projects = $serializer->deserialize($projects, 'array', 'json');

        return $this->json([
            'projects' => $projects,
            'count' => $count
        ]);
    }

    #[Route('api/project/create', name: 'project_create', methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request, ThemeRepository $themeRepository, ValidatorInterface $validator): JsonResponse
    {
        $project = new Project();
        $project->setName($request->request->get('name'));
        $project->setDescription($request->request->get('description'));
        $project->setTheme($themeRepository->find($request->request->get('theme')));

        //Validation
        $validation = new ProjectValidator();
        $validation->validation($validator, $project);

        if ($validation->errors) {
            return $this->json($validation->errors);
        }
        //

        $entityManager->persist($project);
        $entityManager->flush();

        return $this->json('Created new project successfully with id ' . $project->getId(), 201);
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

        return $this->json('Updated a project successfully with id ' . $project->getId(), 201);
    }

    #[Route('api/project/delete', name: 'project_delete', methods: ['DELETE'])]
    public function delete(ProjectRepository $projectRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $project = $projectRepository->findOneBy([], ['id' => 'DESC']);

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->json('Deleted a project successfully');
    }

    #[Route('/react', name: 'project_list_react')]
    public function react(): Response
    {
        $date = new \DateTime('now');

        return $this->render('api/project/index.html.twig', [
            'date' => $date
        ]);
    }

    #[Route('/create', name: 'project_create_page')]
    public function createPage(): Response
    {
        $date = new \DateTime('now');

        return $this->render('api/project/create.html.twig', [
            'date' => $date
        ]);
    }

    #[Route('api/themes', name: 'get_themes', methods: ['GET'])]
    public function getThemes(ThemeRepository $themeRepository, SerializerInterface $serializer): JsonResponse
    {
        $themes = $themeRepository->findAll();

        $themes = $serializer->serialize($themes, 'json', SerializationContext::create());
        $themes = $serializer->deserialize($themes, 'array', 'json');

        return $this->json([
            'themes' => $themes
        ]);
    }

    #[Route('/api/queries', name: 'app_queries')]
    public function test(ProjectRepository $projectRepository, SerializerInterface $serializer): JsonResponse
    {
        $projects = $projectRepository->queryTest();

        $projects = $serializer->serialize($projects, 'json', SerializationContext::create()->setGroups(array('test')));
        $projects = $serializer->deserialize($projects, 'array', 'json');

        return $this->json([
            'projects' => $projects
        ]);
    }
}