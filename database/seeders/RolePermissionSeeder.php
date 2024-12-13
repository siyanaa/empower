<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define the list of roles
        $listOfRoles = ['superadmin', 'admin'];

        // Define the list of permissions
        $arrayOfPermissionNames = [
            'create_site_settings',
            'list_site_settings',
            'edit_site_settings',
            'delete_site_settings',
            'create_cover_images',
            'list_cover_images',
            'edit_cover_images',
            'delete_cover_images',
            'create_about_us',
            'list_about_us',
            'edit_about_us',
            'delete_about_us',
            'create_services',
            'list_services',
            'edit_services',
            'delete_services',
            'create_favicons',
            'list_favicons',
            'edit_favicons',
            'delete_favicons',
            'create_photo_galleries',
            'list_photo_galleries',
            'edit_photo_galleries',
            'delete_photo_galleries',
            'create_video_galleries',
            'list_video_galleries',
            'edit_video_galleries',
            'delete_video_galleries',
            'create_countries',
            'list_countries',
            'edit_countries',
            'delete_countries',

           
            'create_work_categories',
            'list_work_categories',
            'edit_work_categories',
            'delete_work_categories',

            'create_companies',
            'list_companies',
            'edit_companies',
            'delete_companies',
          

            'create_testimonials',
            'list_testimonials',
            'edit_testimonials',
            'delete_testimonials',
            'create_visitors_book',
            'list_visitors_book',
            'edit_visitors_book',
            'delete_visitors_book',
            'create_student_details',
            'list_student_details',
            'edit_student_details',
            'delete_student_details',
            'create_contacts',
            'list_contacts',
            'edit_contacts',
            'delete_contacts',
            'create_categories',
            'list_categories',
            'edit_categories',
            'delete_categories',
            'create_posts',
            'list_posts',
            'edit_posts',
            'delete_posts',
            'create_director_messages',
            'list_director_messages',
            'edit_director_messages',
            'delete_director_messages',
            'create_demands',
            'list_demands',
            'edit_demands',
            'delete_demands',
            'list_applications',
            'list_ceomessage'


            // 'create_users',
            // 'list_users',
            // 'edit_users',
            // 'delete_users',
        ];

        // Create the permissions
        foreach ($arrayOfPermissionNames as $permissionName) {
            Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // Define permissions for each role
        $permissionsForSuperAdminRole = Permission::pluck('name');
        $permissionsForAdminRole = [
            'create_site_settings',
            'list_site_settings',
            'edit_site_settings',
            'delete_site_settings',
            'create_cover_images',
            'list_cover_images',
            'edit_cover_images',
            'delete_cover_images',
            'create_about_us',
            'list_about_us',
            'edit_about_us',
            'delete_about_us',
            'create_services',
            'list_services',
            'edit_services',
            'delete_services',
            'create_favicons',
            'list_favicons',
            'edit_favicons',
            'delete_favicons',
            'create_photo_galleries',
            'list_photo_galleries',
            'edit_photo_galleries',
            'delete_photo_galleries',

            'create_video_galleries',
            'list_video_galleries',
            'edit_video_galleries',
            'delete_video_galleries',
            'create_countries',
            'list_countries',
            'edit_countries',
            'delete_countries',  
            'create_companies',
            'list_companies',
            'edit_companies',
            'delete_companies',
            'create_work_categories',
            'list_work_categories',
            'edit_work_categories',
            'delete_work_categories',
            'create_testimonials',
            'list_testimonials',
            'edit_testimonials',
            'delete_testimonials',
            'create_visitors_book',
            'list_visitors_book',
            'edit_visitors_book',
            'delete_visitors_book',
            'create_student_details',
            'list_student_details',
            'edit_student_details',
            'delete_student_details',
            'create_contacts',
            'list_contacts',
            'edit_contacts',
            'delete_contacts',
            'create_categories',
            'list_categories',
            'edit_categories',
            'delete_categories',
            'create_posts',
            'list_posts',
            'edit_posts',
            'delete_posts',
            'create_director_messages',
            'list_director_messages',
            'edit_director_messages',
            'delete_director_messages',
            'create_demands',
            'list_demands',
            'edit_demands',
            'delete_demands',
            'list_applications',
            'list_ceomessage'


        ];
        $guardName = 'web';
        // Create roles and assign permissions to each role
        foreach ($listOfRoles as $roleName) {
            $role = Role::create(['name' => $roleName]);

            // Assign specific permissions based on role
            switch ($roleName) {
                case 'superadmin':
                    $role->syncPermissions($permissionsForSuperAdminRole);
                    break;
                case 'admin':
                    $role->givePermissionTo($permissionsForAdminRole);
                    break;
            }
        }
    }
}
