<?php

declare(strict_types=1);

namespace Extalion\ModuleName\ToolbarButton;

class ToolbarButtonCollection
{
    private array $toolbarButtons;

    public function __construct()
    {
        $this->toolbarButtons = [];
    }

    public function add(ToolbarButton $toolbarButton): self
    {
        $this->toolbarButtons[$toolbarButton->getId()] = $toolbarButton;

        return $this;
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->toolbarButtons as $id => $toolbarButton) {
            $result[$id] = $toolbarButton->toArray();
        }

        return $result;
    }
}
