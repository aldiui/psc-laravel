@extends('layouts.pdf')

@section('title', 'Izin')

@push('style')
@endpush

@section('main')
    <div>
        <table width="100%">
            <tr>
                <td>
                    <p>{{ formatTanggal() }}</p>
                    <p>Hal : Surat Izin</p>
                    <p>Yth. Kepala Dinas Kesehatan Kota Tasikmalaya</p>
                    <p>Ditempat</p>
                    <br>
                    <p>Dengan Hormat,</p>
                    <p>yang bertanda tangan di bawah ini :</p>
                </td>
            </tr>
        </table>
        <table cellpadding="5">
            <tr>
                <td width="120px">Nama</td>
                <td>:</td>
                <td>{{ $izin->user->nama }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $izin->user->jabatan }} </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td>
                    <p class="text-line-height">Bermaksud mengajukan izin yaitu pada
                        {{ $izin->tanggal_selesai == null ? formatTanggal($izin->tanggal_mulai) : formatTanggal($izin->tanggal_mulai) . ' - ' . formatTanggal($izin->tanggal_selesai) }}
                        dengan alasan {{ $izin->alasan }}.</p>
                    <p>Jika ada pertanyaan mengenai pengajuan izin ini, Bapak/Ibu dapat menanyakan pada nomor
                        {{ $izin->user->no_hp }}.</p>
                    <p>Demikian permohonan izin ini saya ajukan. Terima kasih atas perhatian Bapak/Ibu.</p>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%" valign="top">
            <tr>
                <td width="230px" align="center"></td>
                <td></td>
                <td width="230px" align="center">
                    <div>Mengetahui/Menyetujui</div>
                </td>
            </tr>
            <tr>
                <td width="230px" align="center"></td>
                <td></td>
                <td width="230px" align="center">
                    <div>Ketua Pelaksana PSC 119 Sicetar</div>
                </td>
            </tr>
            <tr>
                <td width="230px" align="center">
                    <div>Hormat Saya,</div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div>{{ $izin->user->nama }}</div>
                </td>
                <td></td>
                <td width="230px" align="center">
                    <div>Kota Tasikmalaya,</div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div>Nana Ernawati, SKM., M.Si</div>
                </td>
            </tr>
            <tr>
                <td width="230px" align="center"></td>
                <td></td>
                <td width="230px" align="center">
                    <div>NIP. 196908241989032002</div>
                </td>
            </tr>
        </table>
    </div>
@endsection

@push('scripts')
@endpush
