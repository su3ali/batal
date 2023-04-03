<?php

namespace App\Support\Sidebar;

use App\Support\Sidebar\Components\SidebarGenerator;
use App\Support\Sidebar\Components\SidebarLink;
use App\Support\Sidebar\Components\SidebarMenu;
use function route;

class Sidebar
{
    public function dashboard()
    {

        return [
            SidebarLink::to(
                t_('dashboard'),
                route('dashboard.home'),
                'las la-tachometer-alt  text-secondary',
                'line-awesome'
            ),
        ];
    }
    public function package()
    {
        $package = [
            SidebarLink::to(t_('packages'), route('dashboard.package.packages.index')),
        ];

        return [
            SidebarMenu::create(t_('Packages'), 'las la-users text-secondary', permission: '')
                ->push($package),
        ];
    }
    public function core()
    {
        $adminList = [
            SidebarLink::to(t_('admins'), route('dashboard.core.administration.admins.index')),
            SidebarLink::to(t_('roles'), route('dashboard.core.administration.roles.index')),
        ];

        return [
            SidebarMenu::create(t_('administration'), 'las la-users text-secondary', permission: '')
                ->push($adminList),
            SidebarLink::to(
                t_('Pages'),
                route('dashboard.core.pages.index'),
                'las la-file-alt text-secondary',
                'line-awesome'
            ),
            SidebarLink::to(
                t_('Faqs'),
                route('dashboard.core.faqs.index'),
                'las la-file-alt text-secondary',
                'line-awesome'
            ),
            SidebarLink::to(
                t_('translation'),
                route('modules.translation.dashboard.index'),
                'las la-language text-secondary',
                'line-awesome'
            ),
            SidebarLink::to(
                t_('Photo Gallery'),
                route('dashboard.core.galleries.index'),
                'las la-images text-secondary',
                'line-awesome'
            ),
            SidebarLink::to(
                t_('packages'),
                route('dashboard.package.packages.index'),
//                url('admin/homesection/homesections'),
                'las la-file-alt text-secondary',
                'line-awesome'
            ),
            SidebarLink::to(
                t_('Home Sections'),
                route('dashboard.homesection.homesections.index'),
//                url('admin/homesection/homesections'),
                'las la-file-alt text-secondary',
                'line-awesome'
            ),
            SidebarLink::to(
                t_('Contacts'),
                route('dashboard.core.contacts.index'),
                'las la-phone text-secondary',
                'line-awesome'
            ),

            SidebarLink::to(
                t_('Setting'),
                route('dashboard.setting.index'),
                'las la-cogs text-secondary',
                'line-awesome'
            ),


        ];
    }

    public function user()
    {
        $adminList = [
            SidebarLink::to(t_('users'), route('dashboard.user.users.index')),
        ];

        return [
            SidebarMenu::create(t_('users'), 'las la-users text-secondary', permission: '')
                ->push($adminList),
        ];
    }
    public function __invoke()
    {
        $generator = SidebarGenerator::create();

        if (activeGuard('dashboard')) {
            $generator->addModule(t_('dashboard'), 'icon-home', false)->push($this->dashboard());
//            $generator->addModule(t_('package'), 'icon-home')->push($this->package());
            $generator->addModule(t_('core'), 'icon-home')->push($this->core());
            $generator->addModule(t_('users'), 'icon-home')->push($this->user());
         }



        return $generator->toArray();
    }
}
