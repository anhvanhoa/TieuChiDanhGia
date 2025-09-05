<?php

namespace App\ViewComposer;
class SidebarComposer
{

    public function __construct()
    {
    }

    public function compose($view)
    {
        $sidebarItems = $this->getSidebarItems();
        return $view->with("siderbars", $sidebarItems);
    }


    public function getSidebarItems()
    {
        return [
            [
                'group' => 'THÔNG TIN CHUNG',
                'chil' => [
                    [
                        'label' => 'Dashboard',
                        'icon' => '<i data-lucide="chart-pie"></i>',
                        'route' => route('dashboard'),
                        'active' => Request()->is('dashboard'),
                    ],
                ],
            ],
            [
                'group' => 'QUẢN LÝ VƯỜN QUỐC GIA',
                'chil' => [
                    [
                        'label' => 'Loại vườn quốc gia',
                        'icon' => '<i data-lucide="shrub"></i>',
                        'route' => route('loai-vuon-quoc-gia.index'),
                        'active' => Request()->is('loai-vuon-quoc-gia'),
                    ],
                    [
                        'label' => 'Vườn quốc gia',
                        'icon' => '<i data-lucide="land-plot"></i>',
                        'route' => route('vuon-quoc-gia.index'),
                        'active' => Request()->is('vuon-quoc-gia'),
                    ],
                ],
            ],
            [
                'group' => 'PHÂN LOẠI SINH HỌC',
                'chil' => [
                    [
                        'label' => 'Ngành',
                        'icon' => '<i data-lucide="layers"></i>',
                        'route' => route('bac-nganh.index'),
                        'active' => Request()->is('bac-nganh'),
                    ],
                    [
                        'label' => 'Lớp',
                        'icon' => '<i data-lucide="grid"></i>',
                        'route' => route('bac-lop.index'),
                        'active' => Request()->is('bac-lop'),
                    ],
                    [
                        'label' => 'Bộ',
                        'icon' => '<i data-lucide="box"></i>',
                        'route' => route('bac-bo.index'),
                        'active' => Request()->is('bac-bo'),
                    ],
                    [
                        'label' => 'Họ',
                        'icon' => '<i data-lucide="folder"></i>',
                        'route' => route('bac-ho.index'),
                        'active' => Request()->is('bac-ho'),
                    ],
                    [
                        'label' => 'Chi',
                        'icon' => '<i data-lucide="file"></i>',
                        'route' => route('bac-chi.index'),
                        'active' => Request()->is('bac-chi'),
                    ],
                ],
            ],
            [
                'group' => 'QUẢN LÝ SINH VẬT',
                'chil' => [
                    [
                        'label' => 'Động vật',
                        'icon' => '<i data-lucide="zap"></i>',
                        'route' => route('dong-vat.index'),
                        'active' => Request()->is('dong-vat'),
                    ],
                    [
                        'label' => 'Thực vật',
                        'icon' => '<i data-lucide="leaf"></i>',
                        'route' => route('thuc-vat.index'),
                        'active' => Request()->is('thuc-vat'),
                    ],
                ],
            ],
        ];
    }
}
