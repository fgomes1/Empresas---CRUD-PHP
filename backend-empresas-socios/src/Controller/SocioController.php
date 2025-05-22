<?php

namespace App\Controller;

use App\Entity\Empresa;
use App\Entity\Socio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;

#[Route('/api/empresas/{empresaId}/socios')]
class SocioController extends AbstractController
{
    #[Route('', name: 'socio_list', methods: ['GET'])]
    #[OA\Get(
        summary: 'Lista os sócios de uma empresa',
        description: 'Retorna uma lista dos sócios associados a uma empresa específica.',
        parameters: [
            new OA\Parameter(
                name: 'empresaId',
                in: 'path',
                description: 'ID da empresa',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista de sócios retornada com sucesso',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Socio')
                )
            ),
            new OA\Response(response: 404, description: 'Empresa não encontrada'),
            new OA\Response(response: 500, description: 'Erro interno')
        ]
    )]
    public function index(int $empresaId, EntityManagerInterface $em): JsonResponse
    {
        $empresa = $em->getRepository(Empresa::class)->find($empresaId);
        if (!$empresa) {
            return new JsonResponse(['error' => 'Empresa não encontrada'], Response::HTTP_NOT_FOUND);
        }
        $socios = $empresa->getSocios();
        return $this->json($socios, Response::HTTP_OK, [], [
            'groups' => ['socio']
        ]);
    }

    #[Route('', name: 'socio_create', methods: ['POST'])]
    #[OA\Post(
        summary: 'Cria um novo sócio para uma empresa',
        description: 'Cria um novo sócio e o vincula à empresa especificada.',
        parameters: [
            new OA\Parameter(
                name: 'empresaId',
                in: 'path',
                description: 'ID da empresa',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nome'],
                properties: [
                    new OA\Property(property: 'nome', type: 'string', example: 'Sócio Exemplo', description: 'Nome do sócio')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Sócio criado com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/Socio')
            ),
            new OA\Response(response: 400, description: 'Dados inválidos'),
            new OA\Response(response: 404, description: 'Empresa não encontrada'),
            new OA\Response(response: 500, description: 'Erro interno')
        ]
    )]
    public function create(int $empresaId, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $empresa = $em->getRepository(Empresa::class)->find($empresaId);
        if (!$empresa) {
            return new JsonResponse(['error' => 'Empresa não encontrada'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);
        if (empty($data['nome'])) {
            return new JsonResponse(['error' => 'O campo "nome" é obrigatório'], Response::HTTP_BAD_REQUEST);
        }
        $socio = new Socio();
        $socio->setNome($data['nome']);
        $socio->setEmpresa($empresa);
        $em->persist($socio);
        $em->flush();
        return $this->json($socio, Response::HTTP_CREATED, [], [
            'groups' => ['socio']
        ]);
    }

    #[Route('/{id}', name: 'socio_show', methods: ['GET'])]
    #[OA\Get(
        summary: 'Exibe detalhes de um sócio',
        description: 'Retorna os detalhes de um sócio específico associado a uma empresa.',
        parameters: [
            new OA\Parameter(
                name: 'empresaId',
                in: 'path',
                description: 'ID da empresa',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID do sócio',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Detalhes do sócio',
                content: new OA\JsonContent(ref: '#/components/schemas/Socio')
            ),
            new OA\Response(response: 404, description: 'Sócio não encontrado')
        ]
    )]
    public function show(int $empresaId, int $id, EntityManagerInterface $em): JsonResponse
    {
        $socio = $em->getRepository(Socio::class)->find($id);
        if (!$socio) {
            return $this->json(['error' => 'Sócio não encontrado'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($socio, Response::HTTP_OK, [], [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
            'groups' => ['socio']
        ]);
    }

    #[Route('/{id}', name: 'socio_update', methods: ['PUT'])]
    #[OA\Put(
        summary: 'Atualiza um sócio',
        description: 'Atualiza os dados de um sócio associado a uma empresa.',
        parameters: [
            new OA\Parameter(
                name: 'empresaId',
                in: 'path',
                description: 'ID da empresa',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID do sócio',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'nome', type: 'string', example: 'Sócio Atualizado', description: 'Nome atualizado do sócio')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Sócio atualizado com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/Socio')
            ),
            new OA\Response(response: 400, description: 'Dados inválidos'),
            new OA\Response(response: 404, description: 'Sócio não encontrado')
        ]
    )]
    public function update(int $empresaId, Request $request, Socio $socio, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (isset($data['nome'])) {
            $socio->setNome($data['nome']);
        }
        $em->flush();
        return $this->json($socio, Response::HTTP_OK, [], [
            'groups' => ['socio']
        ]);
    }

    #[Route('/{id}', name: 'socio_delete', methods: ['DELETE'])]
    #[OA\Delete(
        summary: 'Remove um sócio',
        description: 'Remove um sócio associado a uma empresa.',
        parameters: [
            new OA\Parameter(
                name: 'empresaId',
                in: 'path',
                description: 'ID da empresa',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID do sócio',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(response: 204, description: 'Sócio removido com sucesso'),
            new OA\Response(response: 404, description: 'Sócio não encontrado')
        ]
    )]
    public function delete(int $empresaId, int $id, EntityManagerInterface $em): JsonResponse
    {
        $socio = $em->getRepository(Socio::class)->find($id);
        if (!$socio) {
            return $this->json(['error' => 'Sócio não encontrado'], Response::HTTP_NOT_FOUND);
        }
        $em->remove($socio);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}