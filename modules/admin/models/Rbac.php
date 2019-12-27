<?php


namespace app\modules\admin\models;


class Rbac implements RbacInterface
{
    public function CreatePermission(string $name, string $description = ''): void
    {
        // TODO: Implement CreatePermission() method.
    }

    public function CreateRole(string $name): void
    {
        // TODO: Implement CreateRole() method.
    }

    function AssignRoleToUser(string $user, string $role): void
    {
        // TODO: Implement AssignRoleToUser() method.
    }

    function AssignPermissionToRole(string $role, string $permission): void
    {
        // TODO: Implement AssignPermissionToRole() method.
    }
}

interface RbacInterface
{
    function CreatePermission(string $name, string $description = ''): void;

    function CreateRole(string $name): void;

    function AssignRoleToUser(string $user, string $role): void;

    function AssignPermissionToRole(string $role, string $permission): void;
}