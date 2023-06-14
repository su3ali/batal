<?php

namespace Database\Seeders;

use App\Enums\Core\RolesEnum;
use App\Models\Admin;
use Auth;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Artisan::call('permission:cache-reset');
        $this->setupPermissions();
        //
        $this->setupRoles();
        $this->setupUsers();
    }

    private function setupUsers()
    {
        Auth::shouldUse('dashboard');
        tap(Admin::updateOrCreate(['email' => 'admin@admin.com'], [
            'first_name'     => 'Super Admin',
            'last_name'     => 'Super Admin',
            'email'    => 'admin@admin.com',
            'phone'    => '96651010101010',
            'active'   => true,
            'password' => '123456',
        ]))->assignRole([
            RolesEnum::super()->value,
            RolesEnum::admin()->value,
        ]);
        echo 'Admins Created Successfully'.PHP_EOL;
    }

    private function setupRoles()
    {
        Role::query()->delete();
        $roles = collect(RolesEnum::toArray())
            ->transform(fn ($i) => ['name' => $i, 'guard_name' => 'dashboard'])
            ->toArray();

        Role::insert($roles);

        Role::findByName('super', 'dashboard')
            ->permissions()->sync(Permission::where('guard_name', 'dashboard')->pluck('id'));

        echo 'Roles Created Successfully'.PHP_EOL;
    }

    private function setupPermissions()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $permissions = collect([
            ['name'=>'view_admins', 'name_en' => 'view admins', 'name_ar' => 'عرض المستخدمين'],
            ['name'=>'create_admins', 'name_en' => 'create admins', 'name_ar' => 'إنشاء مستخدمين'],
            ['name'=>'update_admins', 'name_en' => 'update admins', 'name_ar' => 'تعديل المستخدمين'],
            ['name'=>'delete_admins', 'name_en' => 'delete admins', 'name_ar' => 'حذف المستخدمين'],
            ['name'=>'view_roles', 'name_en' => 'view roles', 'name_ar' => 'عرض الصلاحيات'],
            ['name'=>'create_roles', 'name_en' => 'create roles', 'name_ar' => 'إنشاء صلاحيات'],
            ['name'=>'update_roles', 'name_en' => 'update roles', 'name_ar' => 'تعديل الصلاحيات'],
            ['name'=>'delete_roles', 'name_en' => 'delete roles', 'name_ar' => 'حذف الصلاحيات'],
            ['name'=>'view_setting', 'name_en' => 'view setting', 'name_ar' => 'عرض الإعدادات'],
            ['name'=>'update_setting', 'name_en' => 'update setting', 'name_ar' => 'تغيير الإعدادات'],
            ['name'=>'admin_profile', 'name_en' => 'admin profile', 'name_ar' => 'صفحة الأدمن الشخصية'],
            ['name'=>'visits', 'name_en' => 'visits', 'name_ar' => 'الزيارات'],
            ['name'=>'create_visits', 'name_en' => 'create visits', 'name_ar' => 'إنشاء الزيارات'],
            ['name'=>'update_visits', 'name_en' => 'update visits', 'name_ar' => 'تعديل الزيارات'],
            ['name'=>'delete_visits', 'name_en' => 'delete visits', 'name_ar' => 'حذف الزيارات'],
            ['name'=>'view_visits', 'name_en' => 'view visits', 'name_ar' => 'عرض الزيارات'],
            ['name'=>'packages', 'name_en' => 'packages', 'name_ar' => 'التقاول'],
            ['name'=>'create_packages', 'name_en' => 'create packages', 'name_ar' => 'إنشاء التقاول'],
            ['name'=>'update_packages', 'name_en' => 'update packages', 'name_ar' => 'تعديل التقاول'],
            ['name'=>'delete_packages', 'name_en' => 'delete packages', 'name_ar' => 'حذف التقاول'],
            ['name'=>'view_packages', 'name_en' => 'view packages', 'name_ar' => 'عرض التقاول'],
            ['name'=>'orders', 'name_en' => 'orders', 'name_ar' => 'الطلبات'],
            ['name'=>'create_orders', 'name_en' => 'create orders', 'name_ar' => 'إنشاء الطلبات'],
            ['name'=>'update_orders', 'name_en' => 'update orders', 'name_ar' => 'تعديل الطلبات'],
            ['name'=>'delete_orders', 'name_en' => 'delete orders', 'name_ar' => 'حذف الطلبات'],
            ['name'=>'view_orders', 'name_en' => 'view orders', 'name_ar' => 'عرض الطلبات'],
            ['name'=>'bookings', 'name_en' => 'bookings', 'name_ar' => 'الحجوزات'],
            ['name'=>'create_bookings', 'name_en' => 'create bookings', 'name_ar' => 'إنشاء الحجوزات'],
            ['name'=>'update_bookings', 'name_en' => 'update bookings', 'name_ar' => 'تعديل الحجوزات'],
            ['name'=>'delete_bookings', 'name_en' => 'delete bookings', 'name_ar' => 'حذف الحجوزات'],
            ['name'=>'view_bookings', 'name_en' => 'view bookings', 'name_ar' => 'عرض الحجوزات'],
            ['name'=>'categories', 'name_en' => 'categories', 'name_ar' => 'الأقسام'],
            ['name'=>'create_categories', 'name_en' => 'create categories', 'name_ar' => 'إنشاء الأقسام'],
            ['name'=>'update_categories', 'name_en' => 'update categories', 'name_ar' => 'تعديل الأقسام'],
            ['name'=>'delete_categories', 'name_en' => 'delete categories', 'name_ar' => 'حذف الأقسام'],
            ['name'=>'view_categories', 'name_en' => 'view categories', 'name_ar' => 'عرض الأقسام'],
            ['name'=>'services', 'name_en' => 'services', 'name_ar' => 'الخدمات'],
            ['name'=>'create_services', 'name_en' => 'create services', 'name_ar' => 'إنشاء الخدمات'],
            ['name'=>'update_services', 'name_en' => 'update services', 'name_ar' => 'تعديل الخدمات'],
            ['name'=>'delete_services', 'name_en' => 'delete services', 'name_ar' => 'حذف الخدمات'],
            ['name'=>'view_services', 'name_en' => 'view services', 'name_ar' => 'عرض الخدمات'],
            ['name'=>'technicians', 'name_en' => 'technicians', 'name_ar' => 'الفنيين'],
            ['name'=>'create_technicians', 'name_en' => 'create technicians', 'name_ar' => 'إنشاء الفنيين'],
            ['name'=>'update_technicians', 'name_en' => 'update technicians', 'name_ar' => 'تعديل الفنيين'],
            ['name'=>'delete_technicians', 'name_en' => 'delete technicians', 'name_ar' => 'حذف الفنيين'],
            ['name'=>'view_technicians', 'name_en' => 'view technicians', 'name_ar' => 'عرض الفنيين'],
            ['name'=>'wallets', 'name_en' => 'wallets', 'name_ar' => 'المحافظ'],
            ['name'=>'customers', 'name_en' => 'customers', 'name_ar' => 'العملاء'],
            ['name'=>'create_customers', 'name_en' => 'create customers', 'name_ar' => 'إنشاء العملاء'],
            ['name'=>'update_customers', 'name_en' => 'update customers', 'name_ar' => 'تعديل العملاء'],
            ['name'=>'delete_customers', 'name_en' => 'delete customers', 'name_ar' => 'حذف العملاء'],
            ['name'=>'view_customers', 'name_en' => 'view customers', 'name_ar' => 'عرض العملاء'],
            ['name'=>'rates', 'name_en' => 'rates', 'name_ar' => 'التقييمات'],
            ['name'=>'coupons', 'name_en' => 'coupons', 'name_ar' => 'الكوبونات'],
            ['name'=>'create_coupons', 'name_en' => 'create coupons', 'name_ar' => 'إنشاء الكوبونات'],
            ['name'=>'update_coupons', 'name_en' => 'update coupons', 'name_ar' => 'تعديل الكوبونات'],
            ['name'=>'delete_coupons', 'name_en' => 'delete coupons', 'name_ar' => 'حذف الكوبونات'],
            ['name'=>'view_coupons', 'name_en' => 'view coupons', 'name_ar' => 'عرض الكوبونات'],
            ['name'=>'system_settings', 'name_en' => 'system_settings', 'name_ar' => 'إعدادات النظام'],
            ['name'=>'notification', 'name_en' => 'notification', 'name_ar' => 'الاشعارات'],
            ['name'=>'create_notification', 'name_en' => 'create notification', 'name_ar' => 'إنشاء الاشعارات'],
            ['name'=>'update_notification', 'name_en' => 'update notification', 'name_ar' => 'تعديل الاشعارات'],
            ['name'=>'delete_notification', 'name_en' => 'delete notification', 'name_ar' => 'حذف الاشعارات'],
            ['name'=>'view_notification', 'name_en' => 'view notification', 'name_ar' => 'عرض الاشعارات'],
        ]);
        Permission::insert($permissions->transform(fn ($i) => ['name' => $i['name'], 'name_ar' => $i['name_ar'], 'name_en' => $i['name_en'], 'guard_name' => 'dashboard'])
                                       ->toArray());
        echo 'Permissions Created Successfully'.PHP_EOL;

        return $permissions;
    }
}
