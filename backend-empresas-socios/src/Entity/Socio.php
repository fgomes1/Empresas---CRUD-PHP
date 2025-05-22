<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: "App\Repository\SocioRepository")]
class Socio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(["socio", "empresa_details"])]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(["socio", "empresa_details"])]
    private ?string $nome = null;

    #[ORM\ManyToOne(targetEntity: Empresa::class, inversedBy: "socios")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["socio"])]  // Inclua somente se desejar que ao serializar um sócio, os dados da empresa resumidos sejam mostrados.
    private ?Empresa $empresa = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEmpresa(): ?Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(?Empresa $empresa): self
    {
        $this->empresa = $empresa;
        return $this;
    }
}
