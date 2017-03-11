<?php

namespace AppBundle\EntityInterface;

interface LocationServiceInterface
{
    public function getRgbColor(): array;
    public function getName(): string;
}