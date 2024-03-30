@php
use Illuminate\Support\Facades\Auth;$links = [
    [
        "href" => "admin.dashboard",
        "text" => "Dashboard",
        "is_multi" => false,
    ]
    ];

if (Auth::user()->role==1) {
    $add =
    [
        "href" =>
        [
                [
                    "section_text" => "User",
                    "section_list" => [
                        ["href" => "admin.user", "text" => "Data User"],
                        ["href" => "admin.user.new", "text" => "Buat User"]
                        ]
                ],

                [
                    "section_text" => "Paket",
                    "section_icon" => "fa fa-users",
                    "section_list" => [
                        ["href" => "admin.packet-tag.index", "text" => "Data Paket"],
                        ["href" => "admin.packet-tag.create", "text" => "Tambah Jenis Paket"]
                        ]
                ],

                [
                    "section_text" => "Sales",
                    "section_icon" => "fa fa-users",
                    "section_list" => [
                        ["href" => "admin.sales.index", "text" => "Data Pelanggan Sales"],
                        ["href" => "admin.sales.create", "text" => "Tambah Pelanggan Sales"]
                        ]
                ],

                [
                    "section_text" => "Pelanggan",
                    "section_icon" => "fa fa-users",
                    "section_list" => [
                        ["href" => "admin.customer.index", "text" => "Data Pelanggan"],
                        ["href" => "admin.customer.create", "text" => "Tambah Pelanggan"]
                        ]
                ],

                [
                    "section_text" => "Persetujuan",
                    "section_icon" => "fa fa-users",
                    "section_list" => [
                        ["href" => "admin.payment.index", "text" => "Setujui Pembayaran"],
                        ]
                ],

                [
                    "section_text" => "Teknisi",
                    "section_icon" => "fa fa-users",
                    "section_list" => [
                        ["href" => "admin.technician.index", "text" => "Cek Uptime"],
                        ["href" => "admin.olt_user_offline", "text" => "Cek Offline"],
                        ]
                ],

                [
                    "section_text" => "Log Aktifitas",
                    "section_icon" => "fa fa-users",
                    "section_list" => [
                        ["href" => "admin.log.index", "text" => "Data Log"],
                        ]
                ],
            ],
            "text" => "Admin",
            "is_multi" => true,
        ];
        array_push($links, $add);

    } else if (Auth::user()->role==2) {
    $add = [
        "href" =>
        [
            [
            "section_text" => "Member BEM",
            "section_icon" => "fa fa-users",
            "section_list" => [
                ["href" => "admin.member.index", "text" => "Data Member BEM"],
                ["href" => "admin.member.create", "text" => "Tambah Member BEM"]
                ]
            ]
        ],
            "text" => "Manajemen BEM",
            "is_multi" => true,
        ];
        array_push($links, $add);

    } else if (Auth::user()->role==3) {
    $add = [
        "href" =>
        [
            [
            "section_text" => "Mahasiswa Baru",
            "section_icon" => "fa fa-users",
            "section_list" => [
                ["href" => "admin.student.index", "text" => "Data Mahasiswa Baru"],
                ["href" => "admin.student.create", "text" => "Tambah Mahasiswa Baru"]
                ]
            ],
            [
            "section_text" => "Pelanggaran",
            "section_icon" => "fa fa-users",
            "section_list" => [
                ["href" => "admin.offense.index", "text" => "Data Jenis Pelanggaran"],
                ["href" => "admin.offense.create", "text" => "Tambah Jenis Pelanggaran"]
                ]
            ],
            [
            "section_text" => "Kepatuhan",
            "section_icon" => "fa fa-users",
            "section_list" => [
                ["href" => "admin.addition.index", "text" => "Data Jenis Kepatuhan"],
                ["href" => "admin.addition.create", "text" => "Tambah Jenis Kepatuhan"]
                ]
            ],
        ],
        "text" => "Manajemen",
        "is_multi" => true,
    ];
        array_push($links, $add);
    }

    $navigation_links = array_to_object($links);
@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">
                <img class="d-inline-block" width="32px" height="30.61px" src="" alt="">
            </a>
        </div>
        @foreach ($navigation_links as $link)
        <ul class="sidebar-menu">
            <li class="menu-header">{{ $link->text }}</li>
            @if (!$link->is_multi)
            <li class="{{ Request::routeIs($link->href) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route($link->href) }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @else
                @foreach ($link->href as $section)
                    @php
                    $routes = collect($section->section_list)->map(function ($child) {
                        return Request::routeIs($child->href);
                    })->toArray();

                    $is_active = in_array(true, $routes);
                    @endphp

                    <li class="dropdown {{ ($is_active) ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-bar"></i> <span>{{ $section->section_text }}</span></a>
                        <ul class="dropdown-menu">
                            @foreach ($section->section_list as $child)
                                <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a class="nav-link" href="{{ route($child->href) }}">{{ $child->text }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endif
        </ul>
        @endforeach
    </aside>
</div>
