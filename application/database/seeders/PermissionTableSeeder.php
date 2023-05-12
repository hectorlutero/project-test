<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list' => 'Listar Permissões',
            'role-create' => 'Criar Permissões',
            'role-edit' => 'Editar Permissões',
            'role-delete' => "Apagar Permissões",

            'company-list' => "Listar Empresas",
            'company-create' => "Criar Empresas",
            'company-edit' => "Editar Empresas",
            'company-delete' => "Apagar Empresas",

            'company-category-list' => "Listar Categorias de Empresas",
            'company-category-create' => "Criar Categorias de Empresas",
            'company-category-edit' => "Editar Categorias de Empresas",
            'company-category-delete' => "Apagar Categorias de Empresas",

            'company-image-list' => "Listar Imagens de Empresas",
            'company-image-create' => "Criar Imagens de Empresas",
            'company-image-edit' => "Editar Imagens de Empresas",
            'company-image-delete' => "Apagar Imagens de Empresas",

            'file-list' => "Listar Arquivos",
            'file-create' => "Criar Arquivos",
            'file-edit' => "Editar Arquivos",
            'file-delete' => "Apagar Arquivos",

            'plan-list' => "Listar Planos",
            'plan-create' => "Criar Planos",
            'plan-edit' => "Editar Planos",
            'plan-delete' => "Apagar Planos",

            'product-list' => "Listar Produtos",
            'product-create' => "Criar Produtos",
            'product-edit' => "Editar Produtos",
            'product-delete' => "Apagar Produtos",

            'product-category-list' => "Listar Categorias de Produtos",
            'product-category-create' => "Criar Categorias de Produtos",
            'product-category-edit' => "Editar Categorias de Produtos",
            'product-category-delete' => "Apagar Categorias de Produtos",

            'product-tag-list' => "Listar Tags de Produtos",
            'product-tag-create' => "Criar Tags de Produtos",
            'product-tag-edit' => "Editar Tags de Produtos",
            'product-tag-delete' => "Apagar Tags de Produtos",

            'service-list' => "Listar Serviços",
            'service-create' => "Criar Serviços",
            'service-edit' => "Editar Serviços",
            'service-delete' => "Apagar Serviços",

            'service-category-list' => "Listar Categorias de Serviços",
            'service-category-create' => "Criar Categorias de Serviços",
            'service-category-edit' => "Editar Categorias de Serviços",
            'service-category-delete' => "Apagar Categorias de Serviços",

            'service-gallery-list' => "Listar Galerias de Serviços",
            'service-gallery-create' => "Criar Galerias de Serviços",
            'service-gallery-edit' => "Editar Galerias de Serviços",
            'service-gallery-delete' => "Apagar Galerias de Serviços",

            'service-tag-list' => "Listar Tags de Serviços",
            'service-tag-create' => "Criar Tags de Serviços",
            'service-tag-edit' => "Editar Tags de Serviços",
            'service-tag-delete' => "Apagar Tags de Serviços",

            'user-list' => "Listar Usuários",
            'user-create' => "Criar Usuários",
            'user-edit' => "Editar Usuários",
            'user-delete' => "Apagar Usuários",

            'user-address-list' => "Listar Endereços de Usuários",
            'user-address-create' => "Criar Endereços de Usuários",
            'user-address-edit' => "Editar Endereços de Usuários",
            'user-address-delete' => "Apagar Endereços de Usuários",

            'business-list' => "Listar Meus Negócios",

            'favorites-list' => "Listar Favoritos",
            'favorites-create' => "Criar Favoritos",
            'favorites-delete' => "Apagar Favoritos",

        ];



        foreach ($permissions as $key => $permission) {
            Permission::create(['name' => $key, 'readable_name' => $permission]);
        }
    }
}
