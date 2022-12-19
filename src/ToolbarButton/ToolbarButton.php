<?php

declare(strict_types=1);

namespace Extalion\ModuleName\ToolbarButton;

class ToolbarButton
{
    private string $id;
    private ?string $class = null;
    private ?string $help = null;
    private ?string $href = null;
    private ?string $icon = null;
    private bool $isDisabled = false;
    private ?string $js = null;
    private ?string $name = null;
    private ?string $modalTarget = null;
    private ?string $target = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getHelp(): ?string
    {
        return $this->help;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;

        return $this;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(string $href): self
    {
        $this->href = $href;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIsDisabled(): bool
    {
        return $this->isDisabled;
    }

    public function setIsDisabled(bool $isDisabled): self
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }

    public function getJs(): ?string
    {
        return $this->js;
    }

    public function setJs(string $js): self
    {
        $this->js = $js;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getModalTarget(): ?string
    {
        return $this->modalTarget;
    }

    public function setModalTarget(string $modalTarget): self
    {
        $this->modalTarget = $modalTarget;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'class' => $this->getClass(),
            'desc' => $this->getName(),
            'disabled' => $this->getIsDisabled(),
            'help' => $this->getHelp(),
            'href' => $this->getHref(),
            'icon' => $this->getIcon(),
            'imgclass' => $this->getId(),
            'js' => $this->getJs(),
            'modal_target' => $this->getModalTarget(),
            'target' => $this->getTarget(),
        ];
    }
}
