<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\ServiceRequest;
use App\Models\User;

class ServiceRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ServiceRequest $serviceRequest): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isStudent() && $user->student && $user->student->id === $serviceRequest->student_id;
    }

    public function create(User $user): bool
    {
        return $user->isStudent();
    }

    public function approve(User $user): bool
    {
        return $user->isAdmin();
    }

    public function reject(User $user): bool
    {
        return $user->isAdmin();
    }

    public function processHandover(User $user): bool
    {
        return $user->isAdmin();
    }

    public function processReturn(User $user): bool
    {
        return $user->isAdmin();
    }
}