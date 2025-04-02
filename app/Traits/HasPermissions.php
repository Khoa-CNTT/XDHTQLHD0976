<?php

namespace App\Traits;

use App\Models\Permission;

trait HasPermissions
{
    /**
     * Kiểm tra xem user có quyền với tên cụ thể hay không.
     *
     * @param string $permissionName
     * @return bool
     */
    public function hasPermission(string $permissionName): bool
    {
        // Nếu bạn dùng cột role đơn giản, có thể trả về theo logic role
        // Ví dụ: nếu role là admin, luôn trả về true
        if ($this->role === 'admin') {
            return true;
        }
        
        // Nếu dùng bảng permissions với quan hệ many-to-many
        return $this->permissions()->where('name', $permissionName)->exists();
    }

    /**
     * Thiết lập quan hệ many-to-many giữa User và Permission.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
//Trait này dùng để kiểm tra xem user có quyền với tên cụ thể hay không
//ví dụ: public function hasPermission(string $permissionName): bool