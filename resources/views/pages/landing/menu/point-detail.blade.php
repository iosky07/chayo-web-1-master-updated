@extends('pages.landing.main')
@section('content')

        <div class="row">
            <div class="col-md-8 m-auto text-left justify-content-center">
                <h3 class="pt-5 semi-bold-600">
                    {{ $detail->name }}
                </h3>
                <h5 class="semi-bold-100">
                    Total Poin : {{ $detail->point }}
                </h5>
            </div>
        </div><!-- End Paragrph -->


{{--        <div class="row">--}}
{{--            <div class="col-md-8 m-auto text-left justify-content-center">--}}
{{--                dasdasd--}}
{{--            </div>--}}
{{--        </div><!-- End Qute -->--}}


        <div class="pt-3 row justify-content-center">
            <div class="col-lg-10 ml-auto mr-auto pt-3 pb-4">
                <table class="table">
                    <thead class="table-dark">
                        <th>Pelanggaran</th>
                        <th>Poin Pengurangan</th>
                        <th>Kepatuhan</th>
                        <th>Poin Penambahan</th>
                        <th>Total Poin</th>
                    </thead>
                    <tbody>
                    @foreach ($p_detail as $m)
                        <tr>
                            <td>{{ ($m->offense != NULL)? $m->offense->title: '-'}}</td>
                            <td>{{ ($m->offense != NULL)? $m->offense->minus_point:'-' }}</td>
                            <td>{{ ($m->addition != NULL)? $m->addition->title:'-'}}</td>
                            <td>{{ ($m->addition !=NULL)?$m-> addition->plus_point :'-' }}</td>
                            <td>{{ $m->current_point }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <!-- End Work Sigle -->

@endsection
