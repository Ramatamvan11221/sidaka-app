<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Document $document): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTeacher()) {
            return $user->teacher 
                && $document->student 
                && $user->teacher->class_id === $document->student->class_id;
        }

        return $user->isStudent() 
            && $user->student 
            && $user->student->id === $document->student_id;
    }

    public function create(User $user): bool
    {
        return $user->isTeacher() || $user->isAdmin();
    }

    public function update(User $user, Document $document): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTeacher()) {
            return $user->teacher 
                && $document->student 
                && $user->teacher->class_id === $document->student->class_id;
        }

        return false;
    }

    public function delete(User $user, Document $document): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTeacher()) {
            return $user->teacher 
                && $document->student 
                && $user->teacher->class_id === $document->student->class_id;
        }

        return false;
    }

    public function verify(User $user, ?Document $document = null): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTeacher() && $document) {
            return $user->teacher 
                && $document->student 
                && $user->teacher->class_id === $document->student->class_id;
        }

        return $user->isTeacher();
    }

    public function download(User $user, Document $document): bool
    {
        return $this->view($user, $document);
    }
}