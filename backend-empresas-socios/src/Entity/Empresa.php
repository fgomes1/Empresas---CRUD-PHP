<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: "App\Repository\EmpresaRepository")]
class Empresa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(["empresa", "empresa_details", "socio_details"])]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(["empresa", "empresa_details", "socio_details"])]
    private ?string $nome = null;

    #[ORM\OneToMany(mappedBy: "empresa", targetEntity: Socio::class, cascade: ["persist", "remove"])]
    #[Groups(["empresa_details"])]  
    private Collection $socios;

    public function __construct()
    {
        $this->socios = new ArrayCollection();
    }

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

    /**
     * @return Collection|Socio[]
     */
    public function getSocios(): Collection
    {
        return $this->socios;
    }

    public function addSocio(Socio $socio): self
    {
        if (!$this->socios->contains($socio)) {
            $this->socios[] = $socio;
            $socio->setEmpresa($this);
        }
        return $this;
    }

    public function removeSocio(Socio $socio): self
    {
        if ($this->socios->removeElement($socio)) {
            if ($socio->getEmpresa() === $this) {
                $socio->setEmpresa(null);
            }
        }
        return $this;
    }
}
