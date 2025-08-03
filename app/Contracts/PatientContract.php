<?php

namespace App\Contracts;

interface PatientContract
{
    public function getId(): int;

    public function getName(): string;

    public function getSurname(): string;

    public function getSex(): string;

    public function getBirthDate(): string;

    public function getCreatedAt(): string;

    public function getUpdatedAt(): string;
}
