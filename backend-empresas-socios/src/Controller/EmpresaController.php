<?php

namespace App\Controller;

use App\Entity\Empresa;
use App\Repository\EmpresaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;

#[Route('/api/empresas')]
class EmpresaController extends AbstractController
{
    #[Route('', name: 'empresa_list', methods: ['GET'])]
    #[OA\Get(
        summary: 'Lista todas as empresas',
        description: 'Retorna uma lista de todas as empresas cadastradas.',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista de empresas retornada com sucesso',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Empresa')
                )
            ),
            new OA\Response(response: 500, description: 'Erro interno')
        ]
    )]
    public function index(EmpresaRepository $empresaRepository): JsonResponse
    {
        $empresas = $empresaRepository->findAll();
        return $this->json($empresas, Response::HTTP_OK, [], [
            'groups' => ['empresa']
        ]);
    }

    #[Route('', name: 'empresa_create', methods: ['POST'])]
    #[OA\Post(
        summary: 'Cria uma nova empresa',
        description: 'Cria uma nova empresa com os dados informados.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nome'],
                properties: [
                    new OA\Property(property: 'nome', type: 'string', example: 'Empresa Exemplo', description: 'Nome da empresa')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Empresa criada com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/Empresa')
            ),
            new OA\Response(response: 400, description: 'Dados inválidos'),
            new OA\Response(response: 500, description: 'Erro interno')
        ]
    )]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['nome'])) {
            return new JsonResponse(['error' => 'O campo "nome" é obrigatório'], Response::HTTP_BAD_REQUEST);
        }
        $empresa = new Empresa();
        $empresa->setNome($data['nome']);
        $em->persist($empresa);
        $em->flush();
        return $this->json($empresa, Response::HTTP_CREATED, [], [
            'groups' => ['empresa']
        ]);
    }

    #[Route('/{id}', name: 'empresa_show', methods: ['GET'])]
    #[OA\Get(
        summary: 'Exibe detalhes de uma empresa',
        description: 'Retorna os detalhes de uma empresa especificada pelo ID.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID da empresa',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Detalhes da empresa',
                content: new OA\JsonContent(ref: '#/components/schemas/Empresa')
            ),
            new OA\Response(response: 404, description: 'Empresa não encontrada')
        ]
    )]
    public function show(Empresa $empresa): JsonResponse
    {
        return $this->json($empresa, Response::HTTP_OK, [], [
            'groups' => ['empresa', 'empresa_details']
        ]);
    }

    #[Route('/{id}', name: 'empresa_update', methods: ['PUT'])]
    #[OA\Put(
        summary: 'Atualiza uma empresa',
        description: 'Atualiza os dados de uma empresa existente.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID da empresa',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'nome', type: 'string', example: 'Empresa Atualizada', description: 'Nome atualizado da empresa')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Empresa atualizada com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/Empresa')
            ),
            new OA\Response(response: 400, description: 'Dados inválidos'),
            new OA\Response(response: 404, description: 'Empresa não encontrada')
        ]
    )]
    public function update(Request $request, Empresa $empresa, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (isset($data['nome'])) {
            $empresa->setNome($data['nome']);
        }
        $em->flush();
        return $this->json($empresa, Response::HTTP_OK, [], [
            'groups' => ['empresa', 'empresa_details']
        ]);
    }

    #[Route('/{id}', name: 'empresa_delete', methods: ['DELETE'])]
    #[OA\Delete(
        summary: 'Remove uma empresa',
        description: 'Remove uma empresa pelo ID.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID da empresa',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(response: 204, description: 'Empresa removida com sucesso'),
            new OA\Response(response: 404, description: 'Empresa não encontrada')
        ]
    )]
    public function delete(Empresa $empresa, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($empresa);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
