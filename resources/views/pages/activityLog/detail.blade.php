@extends('layouts.modal')

@section('title', __('Detail Aktivitas'))

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            @php
                $detail = json_decode($data->properties);
            @endphp
            @if (!in_array($data->log_name, ['login', 'logout', 'lock', 'unlock']))
                @if ($detail)
                    <table class="table table-bordered mb-2">
                        <tr>
                            <td>User</td>
                            <td>{{ $data->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Modul</td>
                            <td>{{ $data->subject_type }}</td>
                        </tr>
                        <tr>
                            <td>Aksi</td>
                            <td>{{ $data->description }}</td>
                        </tr>
                        <tr>
                            <td>Tgl Aktivitas</td>
                            <td>{{ date('Y-m-d H:i:s', strtotime($data->created_at)) }}</td>
                        </tr>
                    </table>
                    <table class="table table-bordered mb-2">
                        @foreach ($detail as $key => $item)
                            <tr>
                                <th colspan="2" class="text-center">{{ $key == 'old' ? 'Sebelum' : 'Sesudah' }}</th>
                            </tr>
                            @foreach ($item as $k => $d)
                                <tr>
                                    <td width="30%">{{ $k }}</td>
                                    <td>{{ $d }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                @endif
            @elseif(in_array($data->log_name, ['login', 'logout']))
                <table class="table table-bordered mb-2">
                    <tr>
                        <td>Nama Log</td>
                        <td>{{ $data->log_name }}</td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>{{ $data->description }}</td>
                    </tr>
                    <tr>
                        <td>Pada Ip Address</td>
                        <td> {{ $detail->ip_address }} </td>
                    </tr>
                </table>
            @else
                <table class="table table-bordered mb-2">
                    <tr>
                        <td>Nama Log</td>
                        <td>{{ $data->log_name }}</td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>{{ $data->description }}</td>
                    </tr>
                    <tr>
                        <td>Posisi</td>
                        <td>{{ $detail->posisi }}</td>
                    </tr>
                    <tr>
                        <td>Pada Ip Address</td>
                        <td> {{ $detail->ip_address }} </td>
                    </tr>
                </table>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">{{ __('Tutup') }}</button>
        </div>
    </div>
@endsection
